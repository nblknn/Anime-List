<?php

declare (strict_types = 1);

require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/MailService.php';

class UserService {
    private UserRepository $userRepository;
    private MailService $mailService;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->mailService = new MailService();
    }

    public function getCurrentUser(): User | false {
        if ($this->checkLogin())
            return $this->userRepository->searchByID($_SESSION["userID"]);
        else
            return false;
    }

    public function registerUser(string $firstName, string $lastName, string $email, string $password, string $salt): bool {
        $password = hash("sha256", $password . $salt);
        if ($this->userRepository->searchByEmail($email) !== false)
            return false;
        if (!$this->userRepository->add(new User($firstName, $lastName, $email, $password, $salt)))
            return false;
        $this->startSession($email);
        $this->startVerification();
        return true;
    }

    public function loginUser(string $email, string $password, bool $rememberMe): bool {
        $user = $this->userRepository->searchByEmail($email);
        if (!$user)
            return false;
        $password = hash("sha256", $password . $user->getSalt());
        if ($password !== $user->getPassword())
            return false;
        if ($rememberMe) {
            $token = bin2hex(random_bytes(32));
            $this->userRepository->update($user->setToken($token));
            setcookie("token", $token, time() + (60 * 60 * 24 * 30), "/");
            setcookie("email", $email, time() + (60 * 60 * 24 * 30), "/");
        }
        $this->startSession($email);
        $this->mailService->sendLoginMessage($user);
        return true;
    }

    private function startSession(string $email): void {
        session_start();
        $_SESSION["userID"] = $this->userRepository->searchByEmail($email)->getID();
    }

    public function checkLogin(): bool {
        if (!isset($_COOKIE[session_name()]) && isset($_COOKIE["token"]) && isset($_COOKIE["email"])) {
            $token = $_COOKIE["token"];
            $user = $this->userRepository->searchByEmail($_COOKIE["email"]);
            if (!$user || $user->getToken() !== $token)
                return false;
            $this->startSession($_COOKIE["email"]);
        }
        else if (isset($_COOKIE[session_name()])) {
            if (session_status() != PHP_SESSION_ACTIVE)
                session_start();
        }
        else
            return false;
        return true;
    }

    public function logoutUser(): bool {
        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();
        $params = session_get_cookie_params();
        setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
        setcookie("email", '', time() - 100, "/");
        setcookie("token", '', time() - 100, "/");
        session_destroy();
        session_write_close();
        return true;
    }

    public function startVerification(): bool {
        if (!$this->checkLogin())
            return false;
        $verificationToken = bin2hex(random_bytes(32));
        $_SESSION["verificationToken"] = $verificationToken;
        return $this->mailService->sendVerificationMessage($this->getCurrentUser(), "http://127.0.0.1/user/confirmVerification?token=" . $verificationToken);
    }

    public function verifyUser(string $verificationToken): bool {
        if (!$this->checkLogin())
            return false;
        if (isset($_SESSION["verificationToken"]) && $_SESSION["verificationToken"] === $verificationToken && !$this->getCurrentUser()->getIsVerified())
            return $this->userRepository->update($this->getCurrentUser()->setIsVerified(true));
        return false;
    }
}