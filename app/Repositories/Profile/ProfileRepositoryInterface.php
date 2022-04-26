<?php

namespace App\Repositories\Profile;

use App\Repositories\RepositoryInterface;

interface ProfileRepositoryInterface extends RepositoryInterface
{
    public function updateByUserId($userId, $data);
}
