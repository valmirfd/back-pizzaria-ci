<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class ProdutoSuportController extends BaseController
{
    use ResponseTrait;

    public function getProdutosPorCategorias(int $categoryID)
    {
        $produtos = model(ProdutoModel::class)->asObject()->produtosByCategory($categoryID);

        return $this->respond(
            [
                'code'      => 200,
                'produtos'   => $produtos

            ]
        );
    }
}
