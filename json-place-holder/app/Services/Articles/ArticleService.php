<?php

namespace App\Services\Articles;


use App\Repositories\Article\JsonPlaceHolderArticleRepository;

class ArticleService
{
    protected object $repository;
    protected object $articleRequest;

    public function __construct(ArticleRequest $articleRequest)
    {
        $this->articleRequest = $articleRequest;
        $this->repository = new JsonPlaceHolderArticleRepository($articleRequest->getUri());
    }

    public function execute(): ArticleResponse
    {
        return new ArticleResponse($this->repository);
    }
}