<?php

namespace App\Validation;

class OrderEditValidation
{
    public function getRules(?int $id = null): array
    {
        return [
            'id' => [
                'label' => 'Id',
                'rules' => 'permit_empty|is_natural_no_zero'
            ],
            'table' => [
                'label' => 'Mesa',
                'rules' => "required|is_unique[orders.table,id,{$id}]",
                'errors' => [
                    'required' => 'Digite o número da {field}',
                    'is_unique' => 'Esta {field} já está em uso',
                ],
            ],
            'status' => [
                'label' => 'Status',
                'rules' => "required",
                'errors' => [
                    'required' => 'Digite o {field} da ordem',
                ],
            ],

        ];
    }
}
