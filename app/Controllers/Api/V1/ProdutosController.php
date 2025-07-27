<?php

namespace App\Controllers\Api\V1;

use App\Models\ProdutoModel;
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
        return $this->respond($this->model->findAll());
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
        $produto = $this->model->asObject()->find($id);

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

        $inputRequest =  esc($this->request->getVar());

        $id = $this->model->insert($inputRequest);

        $produtoCreated = $this->model->find($id);

        return $this->respondCreated(data: $produtoCreated);
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
        //
    }
}
