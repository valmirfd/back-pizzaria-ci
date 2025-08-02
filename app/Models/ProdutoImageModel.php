<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoImageModel extends Model
{
    protected $table            = 'produtos_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'produto_id',
        'image'
    ];

    


}
