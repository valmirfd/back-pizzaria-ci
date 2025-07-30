<?php

namespace App\Controllers\Api\V1;

use App\Entities\Produto;
use App\Models\ProdutoModel;
use App\Services\ImageService;
use App\Validation\ProdutoValidation;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ProdutosController extends ResourceController
{
    protected $modelName = ProdutoModel::class;
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        return $this->respond($this->model->listarProdutos());
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $produto = $this->model->produtoID($id);

        if ($produto === null) {

            return $this->failNotFound(code: ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->respond(data: $produto, status: ResponseInterface::HTTP_OK);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = (new ProdutoValidation)->getRules();


        if (!$this->validate($rules)) {

            return $this->failValidationErrors($this->validator->getErrors());
        }

        $produto = new Produto($this->request->getVar());

        // upload image
        $images = $this->request->getFiles('images');
        //$final_file_name = prefixed_product_file_name($file_image->getName());
        //$file_image->move(ROOTPATH . 'public/assets/images/products', $final_file_name, true);

        $this->model->salvar($produto);

        $id = $this->model->getInsertID();

        $dataImages = ImageService::storeImages($images, 'produtos', 'produto_id', $id);

        $this->model->salvarImagens($dataImages);


        return $this->respondCreated(data: $produto);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $produto = $this->model->find($id);

        if ($produto === null) {
            return $this->failNotFound(code: ResponseInterface::HTTP_NOT_FOUND);
        }

        $this->model->delete($id);

        return $this->respondDeleted();
    }
}
