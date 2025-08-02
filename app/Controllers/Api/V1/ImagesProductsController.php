<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\ProdutoImageModel;
use App\Models\ProdutoModel;
use App\Services\ImageService;
use App\Validation\ImageProdutoValidation;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Factories;

class ImagesProductsController extends BaseController
{
    use ResponseTrait;

    private $produtoModel;
    private $produtoImageModel;

    public function __construct()
    {
        $this->produtoModel = Factories::models(ProdutoModel::class);
        $this->produtoImageModel = Factories::models(ProdutoImageModel::class);
    }



    public function editarImagensProduto($id = null)
    {
        $rules = (new ImageProdutoValidation)->getRules();

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $produto = $this->produtoModel->asObject()->produtoID($id);
        $imagemAntiga = $produto->images[0]->image;


        if ($produto === null) {
            return $this->failNotFound(code: ResponseInterface::HTTP_NOT_FOUND);
        }

        $produto->images = $this->produtoImageModel->where('produto_id', $produto->id)->findAll();

        $imagem = $this->request->getFiles('images');

        //Contar a quantidade de imagens no post
        $postImage = count(array_filter($_FILES['images']['name']));

        if ($postImage > 1) {
            return $this->respond(
                [
                    'code'      => 401,
                    'message'   => 'Por favor escolha apenas uma imagem.'
                ]
            );
        }

        $dataImages = ImageService::storeImages($imagem, 'produtos', 'produto_id', $id);

        //Exclui a imagem antiga no file system
        ImageService::destroyImage('produtos', $imagemAntiga);

        $this->produtoModel->salvarImagens($dataImages);

        //Exclui a imagem antiga no Banco de Dados
        $this->produtoModel->tryDeleteProdutoImage($produto->id, $imagemAntiga);

        return $this->respond(
            [
                'code'      => 200,
                'message'   => 'Imagem atualizada com sucesso!'
            ]
        );
    }

    public function excluirImageProduto(int $produtoID, $image = null)
    {

        try {

            $produto = $this->produtoModel->asObject()->find($produtoID);


            if ($produto === null) {
                return $this->failNotFound(code: ResponseInterface::HTTP_NOT_FOUND);
            }

            $existentes = $this->produtoImageModel->where('produto_id', $produto->id)->countAllResults();

            if ( $existentes == 1) {

                return $this->respond(
                    [
                        'code'      => 401,
                        'message'   => 'O produto deve ter pelo menos uma imagem.'
                    ]
                );
            }

            $this->produtoModel->tryDeleteProdutoImage($produto->id, $image);

            ImageService::destroyImage('produtos', $image);
        } catch (\Exception $e) {

            die('Erro ao excluir imagem!');
        }

        return $this->respond(
            [
                'code'      => 200,
                'message'   => 'Imagem excluída com sucesso!'
            ]
        );
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
