<?php

namespace App\Validation;

class ProdutoValidation
{
    public function getRules(?int $id = null): array
    {
        return [
            'id' => [
                'label' => 'Id',
                'rules' => 'permit_empty|is_natural_no_zero'
            ],
            'nome' => [
                'label' => 'Produto',
                'rules' => "required|is_unique[produtos.nome,id,{$id}]",
                'errors' => [
                    'required' => 'Digite o nome do {field}',
                    'is_unique' => 'Este {field} já existe',
                ],
            ],
            'price' => [
                'label' => 'Preço',
                'rules' => "required",
                'errors' => [
                    'required' => 'Digite o preço do {field}',
                ],
            ],
            'description' => [
                'label' => 'Descrição',
                'rules' => "required",
                'errors' => [
                    'required' => 'Digite a {field} do produto',
                ],
            ],
            'category_id' => [
                'label' => 'Id da categoria',
                'rules' => "required",
                'errors' => [
                    'required' => 'Digite o {field}',
                ],
            ],
            'images' => [
                'label' => 'imagem do produto',
                'rules' => [
                    'uploaded[images]',
                    'mime_in[images,image/jpg,image/jpeg,image/png,image/webp]',
                    'max_size[images,2048]',
                    'max_dims[images,1920,1200]'
                ],
                'errors' => [
                    'uploaded' => 'O campo {field} é obrigatório',
                    'mime_in' => 'O campo {field} deve ser uma imagem PNG',
                    'max_size' => 'O campo {field} deve ter no máximo 200KB',
                    'max_dims' => 'O campo {field} deve ter a dimenção máxima de 1920x1200',
                ]
            ],


        ];
    }
}
