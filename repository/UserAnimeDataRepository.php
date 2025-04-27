<?php

declare (strict_types = 1);

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../model/UserAnimeData.php';
require_once __DIR__ . '/../database/EntityManager.php';

class UserAnimeDataRepository extends BaseRepository {
    private const string TABLE_NAME = 'useranime';

    public function __construct() {
        $this->dbConnection = EntityManager::getInstance()->getConnection();
    }

    public function add($data): bool {
        return $this->dbConnection->query($this->insertDataToQuery(
            'INSERT INTO ' . self::TABLE_NAME . ' VALUES ($userID, $animeID, $isWatched, $rating, $comment);', $data));
    }

    public function update($data): bool {
        return $this->dbConnection->query($this->insertDataToQuery(
            'UPDATE ' . self::TABLE_NAME . ' SET isWatched = $isWatched, rating = $rating, comment = $comment WHERE userID = $userID AND animeID = $animeID;', $data));
    }

    public function delete($data): bool {
        return $this->dbConnection->query($this->insertDataToQuery('DELETE FROM ' . self::TABLE_NAME . ' WHERE userID = $userID AND animeID = $animeID;', $data));
    }

    private function getDataFromQueryResult(mysqli_result $queryResult): array {
        $result = [];
        foreach ($queryResult as $row) {
            $result[] = new UserAnimeData((int)$row["animeID"], (int)$row["userID"], (bool)$row["isWatched"], (int)$row["rating"], $row["comment"]);
        }
        return $result;
    }

    public function searchByWatched(bool $isWatched, int $userID): array {
        return $this->getDataFromQueryResult($this->searchByParams(["isWatched" => (int)$isWatched, "userID" => $userID], self::TABLE_NAME));
    }

    public function searchByAnimeID(int $animeID, int $userID): UserAnimeData | false {
        return $this->getDataFromQueryResult($this->searchByParams(["animeID" => $animeID, "userID" => $userID], self::TABLE_NAME))[0] ?? false;
    }
}