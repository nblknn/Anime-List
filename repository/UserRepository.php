<?php

declare (strict_types = 1);

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../model/User.php';

class UserRepository extends BaseRepository {
    private const string TABLE_NAME = 'user';

    public function __construct() {
        $this->dbConnection = EntityManager::getInstance()->getConnection();
    }

    public function add($data): bool {
        return $this->dbConnection->query($this->insertDataToQuery(
            'INSERT INTO ' . self::TABLE_NAME . ' VALUES ($id, $firstName, $lastName, $email, $password, $salt, $token, $isVerified);', $data));
    }

    public function update($data): bool {
        return $this->dbConnection->query($this->insertDataToQuery(
            'UPDATE ' . self::TABLE_NAME . ' SET firstName = $firstName, lastName = $lastName, email = $email, password = $password, salt = $salt, token = $token, isVerified = $isVerified WHERE id = $id', $data));
    }

    public function delete($data): bool {
        return $this->dbConnection->query($this->insertDataToQuery('DELETE FROM ' . self::TABLE_NAME . ' WHERE id = $id', $data));
    }

    private function getDataFromQueryResult(mysqli_result $queryResult): array {
        $result = [];
        foreach ($queryResult as $row) {
            $result[] = new User($row["firstName"], $row["lastName"], $row["email"], $row["password"], $row["salt"], $row["token"], (bool)$row["isVerified"], (int)$row["id"]);
        }
        return $result;
    }

    public function searchByID(int $id): User | false {
        return $this->getDataFromQueryResult($this->searchByParams(["id" => $id], self::TABLE_NAME))[0] ?? false;
    }

    public function searchByEmail(string $email): User | false {
        return $this->getDataFromQueryResult($this->searchByParams(["email" => $email], self::TABLE_NAME))[0] ?? false;
    }
}