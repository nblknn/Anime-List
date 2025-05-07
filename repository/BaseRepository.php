<?php

declare (strict_types = 1);

require_once __DIR__ . '/../database/EntityManager.php';

abstract class BaseRepository {
    protected mysqli $dbConnection;
    public abstract function add($data): bool;
    public abstract function update($data): bool;
    public abstract function delete($data): bool;

    protected function insertDataToQuery(string $query, $object): string {
        preg_match_all('/\$[A-Za-z_][A-Za-z_0-9]*/', $query, $dataFields);
        $replaceArr = [];
        foreach ($dataFields[0] as $field) {
            $method = "get" . ucFirst(substr($field, 1));
            if (!method_exists($object, $method)) continue;
            $value = $object->$method();
            $replaceArr[$field] = match (gettype($value)) {
                'string' => "'" . $this->dbConnection->real_escape_string($value) . "'",
                'NULL' => 'null',
                default => (string)(int)$value,
            };
        }
        foreach ($replaceArr as $key => $value) {
            $query = str_replace($key, $value, $query);
        }
        return $query;
    }

    protected function searchByParams(array $params, string $tableName): bool | mysqli_result {
        $paramString = "";
        foreach ($params as $key => $value) {
            if (is_string($value))
                $value = "'" . $value . "'";
            $paramString .= $key . "=" . $value . " AND ";
        }
        $paramString = substr($paramString, 0, strlen($paramString) - 5);
        return $this->dbConnection->query("SELECT * FROM $tableName WHERE " . $paramString);
    }
}