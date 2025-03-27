<?php

declare (strict_types = 1);

namespace Repository;

use Model\Anime;

class AnimeRepository {
    public function add(Anime $anime) {}
    public function update(Anime $anime) {}
    public function delete(Anime $anime) {}
    public function searchByID(int $id) {}
    public function searchByName(string $name) {}
}