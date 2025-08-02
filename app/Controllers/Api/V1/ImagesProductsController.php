<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\ProdutoImageModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Factories;

class ImagesProductsController extends BaseController
{
    use ResponseTrait;

    private $produtoImageModel;

    public function __construct()
    {
        $this->produtoImageModel = Factories::models(ProdutoImageModel::class);
    }

    public function index()
    {
        //
    }

    private function defineQuantidadeImagens(int $produto_id): array
    {

        // Recupero as imagens que o produto já possui
        $existentes = $this->produtoImageModel->where('produto_id', $produto_id)->countAllResults();

        // Contamos o número de imagens que estão vindo no post
        $quantidadeImagensPost = count(array_filter($_FILES['images']['name']));

        $retorno = [
            'existentes' => $existentes,
            'totalImagens' => $existentes + $quantidadeImagensPost,
        ];

        return $retorno;
    }
}
