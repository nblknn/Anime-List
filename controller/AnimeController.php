<?php

declare (strict_types = 1);

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../service/AnimeService.php';
require_once __DIR__ . '/../TemplateEngine.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../service/UserService.php';

class AnimeController extends BaseController {
    private const string LIST_TEMPLATE = __DIR__ . '/../view/html/animeList.html';
    private const string SEARCH_TEMPLATE = __DIR__ . '/../view/html/search.html';
    private AnimeService $service;
    private TemplateEngine $templateEngine;
    private User $user;

    public function __construct() {
        $this->user = (new UserService())->getCurrentUser();
        $this->service = new AnimeService($this->user->getID());
        $this->templateEngine = new TemplateEngine();
    }

    public function plannedAction(): string {
        return $this->templateEngine->render(self::LIST_TEMPLATE,
            ["list" => $this->service->getUserAnimeList(false), "isSearch" => false, "page" => "planned", "user" => $this->user]);
    }

    public function watchedAction(): string {
        return $this->templateEngine->render(self::LIST_TEMPLATE,
            ["list" => $this->service->getUserAnimeList(true), "isSearch" => false, "page" => "watched", "user" => $this->user]);
    }

    public function searchAction(): string {
        if (isset($_GET["name"]))
            return $this->templateEngine->render(self::SEARCH_TEMPLATE,
                ["isSearch" => true, "searchValue" => $_GET["name"], "list" => $this->service->searchAnimeByName($_GET["name"]), "page" => "search", "user" => $this->user]);
        else
            return $this->templateEngine->render(self::SEARCH_TEMPLATE,
                ["isSearch" => false, "page" => "search", "user" => $this->user]);
    }

    public function addListItemAction(): string {
        return $this->handleAction($this->service->addAnimeToUserList((int)$_GET["id"]),
            "Ошибка при добавлении аниме в список");
    }

    public function updateListItemAction(): string {
        return $this->handleAction($this->service->updateAnimeInUserList((int)$_GET["id"], isset($_POST["isWatched"]), (int)$_POST["rating"], $_POST["comment"]),
            "Ошибка при изменении элемента списка");
    }

    public function deleteListItemAction(): string {
        return $this->handleAction($this->service->deleteAnimeFromUserList((int)$_GET["id"]),
            "Ошибка при удалении аниме из списка");
    }

    public function defaultAction(): string {
        header("Location: /anime/watched");
        return $this->watchedAction();
    }
}