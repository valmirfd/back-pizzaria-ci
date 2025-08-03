<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

    public function index(): ResponseInterface
    {
        $user = auth()->user();
        $user->roles = $user->getGroups();

        return $this->respond($user);
    }
}
