<?php

namespace App\Repositories;

use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ArticleRepository implements ArticleRepositoryInterface
{

    public function getAllArticles(): LengthAwarePaginator
    {
        return Article::query()->with('comment')->paginate(10);
    }

    public function getArticleByID(int $id): Model
    {
        return Article::query()->find($id);
    }

    public function createArticle(array $data): Model
    {
        return Article::query()->create($data);
    }

    public function deleteArticle(int $id)
    {
        $article = Article::query()->find($id);
        if (File::exists($article->image)) {
            File::delete($article->image);
        }
        return $article->delete();
    }
}
