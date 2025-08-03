<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Item extends Entity
{

    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];
}
