<?php

declare (strict_types = 1);

require_once __DIR__ . '/../model/UserAnimeData.php';

class UserAnimeDataRepository {
    public function add(UserAnimeData $data) {}
    public function delete(UserAnimeData $data) {}
    public function searchByWatched(bool $isWatched) {}
}