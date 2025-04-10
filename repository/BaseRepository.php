<?php

abstract class BaseRepository {
    public abstract function add($data);
    public abstract function update($data);
    public abstract function delete($data);
}