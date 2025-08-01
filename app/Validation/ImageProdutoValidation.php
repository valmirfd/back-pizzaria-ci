<?php

namespace App\Validation;

class ImageProdutoValidation
{
    public function getRules(): array
    {
        return [
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
