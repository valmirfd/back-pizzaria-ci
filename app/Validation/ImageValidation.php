<?php

namespace App\Validation;

class ImageValidation
{
    public function getRules(): array
    {
        return [
            'id' => [
                'label' => 'Id',
                'rules' => 'permit_empty|is_natural_no_zero'
            ],
            'file_image' => [
                'label' => 'imagem do produto',
                'rules' => [
                    'uploaded[file_image]',
                    'mime_in[file_image,image/jpg,image/jpeg,image/png,image/webp]',
                    'max_size[file_image,2048]',
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
