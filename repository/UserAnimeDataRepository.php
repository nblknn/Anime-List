<?php

declare (strict_types = 1);

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../model/UserAnimeData.php';

class UserAnimeDataRepository extends BaseRepository {
    public function add($data): bool {
        return true;
    }
    public function update($data): bool {
        return true;
    }
    public function delete($data): bool {
        return true;
    }
    public function searchByWatched(bool $isWatched): array {
        return [];
    }
    public function searchByAnimeID(int $animeID): UserAnimeData | false {
        return false;
    }
}