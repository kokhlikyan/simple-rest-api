<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface CommentRepositoryInterface
{
    public function add(array $data): Model;
}
