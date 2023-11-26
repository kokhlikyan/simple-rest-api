<?php

namespace App\Interfaces;

interface ArticleRepositoryInterface
{
    public function getAllArticles();

    public function getArticleByID(int $id);

    public function createArticle(array $data);

    public function deleteArticle(int $id);
}
