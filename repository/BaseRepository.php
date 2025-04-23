<?php

abstract class BaseRepository {
    public abstract function add($data): bool;
    public abstract function update($data): bool;
    public abstract function delete($data): bool;
}