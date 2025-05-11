<?php

declare (strict_types = 1);

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../TemplateEngine.php';
require_once __DIR__ . '/../service/UserService.php';

class UserController extends BaseController {
    private const string AUTH_TEMPLATE = __DIR__ . '/../view/html/authorization.html';
    private UserService $service;
    private TemplateEngine $templateEngine;

    public function __construct() {
        $this->service = new UserService();
        $this->templateEngine = new TemplateEngine();
    }

    private function authAction(string $page): string {
        if ($this->service->checkLogin()) {
            header("Location: /");
            exit;
        }
        return $this->templateEngine->render(self::AUTH_TEMPLATE, ["page" => $page,]);
    }

    public function loginAction(): string {
        return $this->authAction("login");
    }

    public function registrationAction(): string {
        return $this->authAction("registration");
    }

    public function confirmLoginAction(): string {
        return $this->handleAction($this->service->loginUser($_POST["email"], $_POST["password"], (bool)$_POST["rememberMe"]),
        "Произошла ошибка при входе в аккаунт! Проверьте корректность введенных данных.");
    }

    public function confirmRegistrationAction(): string {
        return $this->handleAction($this->service->registerUser($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["password"], $_POST["salt"]),
        "Произошла ошибка при регистрации! Проверьте корректность введенных данных.");
    }

    public function verifyAction(): string {
        return $this->handleAction($this->service->startVerification(), "Произошла ошибка при отправке письма!");
    }

    public function confirmVerificationAction(): string {
       if ($this->service->verifyUser($_GET["token"]))
           return "Ваша электронная почта была успешно подтверждена.";
       else
           return "Произошла ошибка при подтверждении электронной почты! Войдите в аккаунт или проверьте ссылку.";
    }

    public function logoutAction(): string {
        $this->service->logoutUser();
        header("Location: /");
        exit;
    }

    public function defaultAction(): string {
        header("Location: /user/login");
        return $this->loginAction();
    }
}