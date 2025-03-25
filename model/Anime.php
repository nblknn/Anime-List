<?php

class Anime {
    private int $id;
    private string $name;
    private string $russianname;
    private int $episodes;
    private int $year;
    private string $posterURL;
    private string $description;
    public function __construct($id, $name, $russianname, $episodes, $year, $posterURL, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->russianname = $russianname;
        $this->episodes = $episodes;
        $this->year = $year;
        $this->posterURL = $posterURL;
        $this->description = $description;
    }
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getRussianName() {
        return $this->russianname;
    }
    public function getEpisodes() {
        return $this->episodes;
    }
    public function getYear() {
        return $this->year;
    }
    public function getPosterURL() {
        return $this->posterURL;
    }
    public function getDescription() {
        return $this->description;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function setRussianName($russianname) {
        $this->russianname = $russianname;
    }
    public function setEpisodes($episodes) {
        $this->episodes = $episodes;
    }
    public function setYear($year) {
        $this->year = $year;
    }
    public function setPosterURL($posterURL) {
        $this->posterURL = $posterURL;
    }
    public function setDescription($description) {
        $this->description = $description;
    }
}