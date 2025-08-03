<?php

namespace App\Validation;

class ItemValidation
{
    public function getRules(): array
    {
        return [
            'id' => [
                'label' => 'Id',
                'rules' => 'permit_empty|is_natural_no_zero'
            ],
            'amount' => [
                'label' => 'Quantidade',
                'rules' => "required",
                'errors' => [
                    'required' => 'Digite a {field} do item',
                ],
            ],
            'order_id' => [
                'label' => 'Id da ordem',
                'rules' => "required",
                'errors' => [
                    'required' => 'Digite o {field}',
                ],
            ],
            'product_id' => [
                'label' => 'Id do produto',
                'rules' => "required",
                'errors' => [
                    'required' => 'Digite o {field}',
                ],
            ],

        ];
    }
}
