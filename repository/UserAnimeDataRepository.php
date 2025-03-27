<?php

declare (strict_types = 1);

namespace Repository;

use Model\UserAnimeData;

class UserAnimeDataRepository {
    public function add(UserAnimeData $data) {}
    public function delete(UserAnimeData $data) {}
    public function searchByWatched(bool $isWatched) {}
}