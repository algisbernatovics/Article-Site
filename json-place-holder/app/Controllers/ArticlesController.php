<?php

namespace App\Controllers;

use App\Core\Renderer;
use App\Services\Articles\ArticleRequest;
use App\Services\Articles\ArticleService;
use App\Services\Comments\CommentRequest;
use App\Services\Comments\CommentService;


class ArticlesController
{
<<<<<<< HEAD
    private object $articleService;
    private object $commentService;
    public function __construct(articleService $articleService,commentService $commentService)
    {
        $this->articleService = $articleService;
        $this->commentService = $commentService;
    }

=======
>>>>>>> refs/remotes/origin/main
    public function home(): string

    {
        return $this->allPosts();
    }

    public function allPosts(): string
    {
<<<<<<< HEAD
        $articleRequest = new ArticleRequest('/posts');
        $articleResponse = $this->articleService->execute();
        return (new Renderer())->viewPosts(
            'Posts.twig',
            $articleResponse->getResponse()->getArticles($articleRequest->getUri()));
=======
        $articleService = new ArticleService(new ArticleRequest('/posts'));
        $articleResponse = $articleService->execute();
        return (new Renderer())->viewPosts('Posts.twig', $articleResponse->getPosts());
>>>>>>> refs/remotes/origin/main
    }

    public function post(): string
    {
<<<<<<< HEAD
        $articleRequest = new ArticleRequest($_SERVER["REQUEST_URI"]);
        $articleResponse = $this->articleService->execute();

        $commentRequest = new CommentRequest($_SERVER["REQUEST_URI"] . '/comments');
        $commentResponse = $this->commentService->execute();
        return (new Renderer())->viewPostAndComments
        (
            'SinglePost.twig',
            $articleResponse->getResponse()->getArticles($articleRequest->getUri()),
            $commentResponse->getResponse()->getComments($commentRequest->getUri())
=======
        $postService = new ArticleService(new ArticleRequest($_SERVER["REQUEST_URI"]));
        $postResponse = $postService->execute();

        $commentService = new CommentService(new CommentRequest($_SERVER["REQUEST_URI"] . '/comments'));
        $commentResponse = $commentService->execute();
        return (new Renderer())->viewPostAndComments
        (
            'SinglePost.twig',
            $postResponse->getPosts(),
            $commentResponse->getComment()
>>>>>>> refs/remotes/origin/main
        );
    }
}