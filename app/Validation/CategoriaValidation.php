<?php

namespace App\Validation;

class CategoriaValidation
{
    public function getRules(?int $id = null): array
    {
        return [
            'id' => [
                'label' => 'Id',
                'rules' => 'permit_empty|is_natural_no_zero'
            ],
            'nome' => [
                'label' => 'Categoria',
                'rules' => "required|is_unique[categorias.nome,id,{$id}]",
                'errors' => [
                    'required' => 'Digite o nome da {field}',
                    'is_unique' => 'Esta {field} já existe',
                ],
            ],

        ];
    }
}
