<?php

declare (strict_types = 1);

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../model/Anime.php';

class AnimeRepository extends BaseRepository {
    public function add($data): bool {
        return true;
    }
    public function update($data): bool {
        return true;
    }
    public function delete($data): bool {
        return true;
    }
    public function searchByID(int $id): Anime | false {
        return false;
    }
    public function searchByName(string $name): array {
        return [];
    }
}