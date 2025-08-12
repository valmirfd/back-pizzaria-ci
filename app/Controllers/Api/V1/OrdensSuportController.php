<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class OrdensSuportController extends BaseController
{
    use ResponseTrait;

    public function fecharPedido(int $orderID)
    {
        $order = model(OrderModel::class)->find($orderID);

        if ($order === null) {
            return $this->failNotFound(code: ResponseInterface::HTTP_NOT_FOUND);
        }

        $order->draft = 0;


        //$inputRequest = esc($this->request->getJSON(assoc: true));

        model(OrderModel::class)->update($order->id, $order);

        return $this->respond(
            [
                'code'      => 200,
                'message'   => 'success'

            ]
        );
    }
}
