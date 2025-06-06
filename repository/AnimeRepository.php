<?php

declare (strict_types = 1);

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../model/Anime.php';

class AnimeRepository extends BaseRepository {
    private const string TABLE_NAME = 'anime';

    public function __construct() {
        $this->dbConnection = EntityManager::getInstance()->getConnection();
    }

    public function add($data): bool {
        return $this->dbConnection->query($this->insertDataToQuery(
            'INSERT INTO ' . self::TABLE_NAME . ' VALUES ($id, $name, $russianName, $episodes, $year, $description);', $data));
    }

    public function update($data): bool {
        return $this->dbConnection->query($this->insertDataToQuery(
            'UPDATE ' . self::TABLE_NAME . ' SET name = $name, russianName = $russianName, episodes = $episodes, year = $year, description = $description WHERE id = $id', $data));
    }

    public function delete($data): bool {
        return $this->dbConnection->query($this->insertDataToQuery('DELETE FROM ' . self::TABLE_NAME . ' WHERE id = $id', $data));
    }

    private function getDataFromQueryResult(mysqli_result $queryResult): array {
        $result = [];
        foreach ($queryResult as $row) {
            $result[] = new Anime((int)$row["id"], $row["name"], $row["russianName"], (int)$row["episodes"], (int)$row["year"], $row["description"]);
        }
        return $result;
    }

    public function searchByID(int $id): Anime | false {
        return $this->getDataFromQueryResult($this->searchByParams(["id" => $id], self::TABLE_NAME))[0] ?? false;
    }

    public function searchByName(string $name): array {
        return $this->getDataFromQueryResult($this->dbConnection->query(
            "SELECT * FROM " . self::TABLE_NAME . " WHERE name LIKE '%$name%' OR russianName LIKE '%$name%'"));
    }
}