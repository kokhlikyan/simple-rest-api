<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class CommentRepository implements CommentRepositoryInterface
{

    public function add(array $data): Model
    {
        return Comment::query()->create($data);
    }
}
