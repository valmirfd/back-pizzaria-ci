<?php

namespace App\Controllers\Api\V1;

use App\Models\ItemModel;
use App\Models\OrderModel;
use App\Models\ProdutoModel;
use App\Validation\OrderEditValidation;
use App\Validation\OrderValidation;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class OrdersController extends ResourceController
{
    protected $modelName = OrderModel::class;
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        return $this->respond($this->model->getOrdersOpen());
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
        $order = $this->model->asObject()->find($id);

        if ($order === null) {
            return $this->failNotFound(code: ResponseInterface::HTTP_NOT_FOUND);
        }

        $order->products = model(ProdutoModel::class)->asObject()->where('id', $order->id)->findAll();
        $order->items = model(ItemModel::class)->where('order_id', $order->id)->findAll();

        return $this->respond(data: $order, status: ResponseInterface::HTTP_OK);
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
        $rules = (new OrderValidation)->getRules();

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $inputRequest = esc($this->request->getJSON(assoc: true));

        $id = $this->model->insert($inputRequest);

        $orderCreated = $this->model->find($id);

        return $this->respondCreated(data: $orderCreated);
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
        $rules = (new OrderEditValidation)->getRules($id);

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $order = $this->model->find($id);


        if ($order === null) {
            return $this->failNotFound(code: ResponseInterface::HTTP_NOT_FOUND);
        }

        $inputRequest = esc($this->request->getJSON(assoc: true));

        $order->status = $inputRequest['status'];

        if ($order->status == '1') {
            $order->draft = '0';
        } else {
            $order->status = '0';
            $order->draft = '1';
        }

        $this->model->update($id, $order);


        return $this->respondUpdated(data: $order);
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

            $ordem = $this->model->find($id);

            if ($ordem === null) {
                return $this->failNotFound(code: ResponseInterface::HTTP_NOT_FOUND);
            }

            $this->model->delete($id);
        } catch (\Exception $e) {
            die('Erro ao excluir a Ordem!');
        }

        return $this->respond(data: $ordem, status: ResponseInterface::HTTP_OK);
    }
}
