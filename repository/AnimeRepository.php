<?php

declare (strict_types = 1);

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../model/Anime.php';

class AnimeRepository extends BaseRepository {
    public function add($data) {}
    public function update($data) {}
    public function delete($data) {}
    public function searchByID(int $id) {}
    public function searchByName(string $name) {}
}