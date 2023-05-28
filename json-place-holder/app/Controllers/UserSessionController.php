<?php

namespace App\Controllers;

use App\Core\Functions;
use App\Core\Renderer;
use App\Services\Users\Show\UserRequest;
use App\Services\Users\Show\UserService;

class UserSessionController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showLoginForm(): string
    {
        return (new Renderer())->showArticleInputForm('ViewLoginForm.twig');
    }

    public function login(): void
    {
        if (!isset($_SESSION['state'])) {
            $response = $this->userService->execute();
            $response->getResponse()->userLogin($_POST);
            $userId = ($response->getResponse()->userLogin($_POST));
            $userRequest = new UserRequest($userId);
            $userResponse = $this->userService->execute();
            $userId = (int)($userResponse->getResponse())->getUsers($userRequest->getUri())[0]->getId();
            $_SESSION["state"] = $userId;
            functions::redirect('/');
        } else (new ErrorController())->errorVoid();
    }

    public function logout(): void
    {
        unset($_SESSION['state']);
        functions::redirect('/');
    }
}