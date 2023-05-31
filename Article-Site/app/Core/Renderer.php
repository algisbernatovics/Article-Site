<?php

namespace App\Core;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class Renderer
{
    protected FilesystemLoader $loader;
    protected Environment $twig;
    protected ?string $sessionId;

    public function __construct()
    {
        $loader = new FilesystemLoader(ROOT_DIR . '/app/Views');
        $this->twig = new Environment($loader, [
            'debug' => true,
        ]);
        $this->twig->addExtension(new DebugExtension());
        if (isset($_SESSION['user_id'])) {
            $this->sessionId = $_SESSION['user_id'];
        } else $this->sessionId = NULL;
    }

    public function showAllArticles(string $template, array $posts): string
    {
        return $this->twig->render($template, ['posts' => $posts, 'sessionState' => $this->sessionId]);
    }

    public function showArticleAndComments(string $template, array $posts, array $comments): string
    {
        return $this->twig->render($template, ['posts' => $posts, 'comments' => $comments, 'sessionState' => $this->sessionId]);
    }

    public function showAllUsers(string $template, array $users): string
    {
        return $this->twig->render($template, ['users' => $users, 'sessionState' => $this->sessionId]);
    }

    public function showSingleUser(string $template, array $user, array $posts): string
    {
        return $this->twig->render($template, ['user' => $user, 'posts' => $posts, 'sessionState' => $this->sessionId]);
    }

    public function showArticleInputForm(string $template): string
    {
        return $this->twig->render($template, ['sessionState' => $this->sessionId]);
    }

    public function userAddEditForm(string $template, bool $status): string
    {
        return $this->twig->render($template, ['sessionState' => $this->sessionId, 'status' => $status]);
    }

    public function showLoginInputForm(string $template, bool $loginStatus): string
    {
        return $this->twig->render($template, ['sessionState' => $this->sessionId, 'correctPassword' => $loginStatus]);
    }

    public function error(string $template): string
    {
        return $this->twig->render($template, ['sessionState' => $this->sessionId]);
    }

    public function errorVoid(string $template): void
    {
        $this->twig->load($template)->display();
    }

    public function unauthorizedErrorVoid(string $template): void
    {
        $this->twig->load($template)->display();
    }

    public function showArticleEditForm(string $template, array $article): string
    {
        return $this->twig->render(
            $template,
            ['sessionState' => $this->sessionId,
                'articles' => $article
            ]);
    }

    public function showCommentEditForm(string $template, array $comment): string
    {
        return $this->twig->render(
            $template,
            ['sessionState' => $this->sessionId,
                'comments' => $comment
            ]);
    }
}