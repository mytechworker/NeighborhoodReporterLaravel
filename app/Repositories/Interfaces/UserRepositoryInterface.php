<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function all();
    
    public function getInfoById($id);
    
    public function getUserByColumn($column, $value);
}
