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
                'rules' => [
                    'uploaded[images]',
                    'ext_in[images,png,jpg,webp]',
                    'max_size[images,2048]',
                    'max_dims[images,1920,1200]',
                ],
            ],

        ];
    }
}
