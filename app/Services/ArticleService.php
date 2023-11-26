<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use Illuminate\Database\Eloquent\Model;

class ArticleService
{
    public function create(array $data, ArticleRepository $repository): Model
    {
        $path = $data['image']->store('images/articles', 'public');
        return $repository->createArticle([
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => "storage/$path",
        ]);
    }

}
