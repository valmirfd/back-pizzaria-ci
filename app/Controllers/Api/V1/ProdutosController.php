<?php

namespace App\Controllers\Api\V1;

use App\Entities\Produto;
use App\Models\ProdutoModel;
use App\Services\ImageService;
use App\Validation\ImageProdutoValidation;
use App\Validation\ProdutoValidation;
use CodeIgniter\HTTP\ResponsableInterface;
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
        return $this->respond($this->model->asObject()->listarProdutos());
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
        $produto = $this->model->asObject()->produtoID($id);

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

        $rules = (new ImageProdutoValidation)->getRules();

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $produto = new Produto($this->request->getVar());

        // upload image
        $images = $this->request->getFiles('images');
        //$final_file_name = prefixed_product_file_name($file_image->getName());
        //$file_image->move(ROOTPATH . 'public/assets/images/products', $final_file_name, true);


        // Contamos o número de imagens que estão vindo no post
        $quantidadeImagensPost = count(array_filter($_FILES['images']['name']));

        if ($quantidadeImagensPost > 3) {

            return $this->respond(
                [
                    'code'      => 401,
                    'message'   => 'Escolha apenas 3 imagens.'
                ]
            );
        }

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
        $produto = $this->model->produtoID($id);

        if ($produto === null) {

            return $this->failNotFound(code: ResponseInterface::HTTP_NOT_FOUND);
        }

        $inputRequest = esc($this->request->getJSON(assoc: true));

        $produto->fill($inputRequest);

        $rules = (new ProdutoValidation)->getRules($id);

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $this->model->salvar($produto);

        $produto = (object) $produto;

        return $this->respond($produto, status: ResponseInterface::HTTP_OK);
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
        try {

            $produto = $this->model->asObject()->produtoID($id);

            if ($produto === null) {
                return $this->failNotFound(code: ResponseInterface::HTTP_NOT_FOUND);
            }

            $nomeImagem = [];

            foreach ($produto->images as $key => $imagem) {

                $nomeImagem[] = $imagem->image;

                //Aqui exclui todas as imagens do produto no file system
                ImageService::destroyImage('produtos', $nomeImagem[$key]);
            }

            //Aqui exclui o produto no Banco de dados
            $this->model->delete($id);
        } catch (\Exception $e) {
            die('Erro ao excluir imagens!');
        }

        return $this->respond(data: $produto, status: ResponseInterface::HTTP_OK);
    }
}
