<?php

declare (strict_types = 1);

class Anime {
    private int $id;
    private string $name;
    private string $russianname;
    private int $episodes;
    private int $year;
    private string $posterURL;
    private string $description;
    public function __construct(int $id, string $name, string $russianname, int $episodes,
                                int $year, string $posterURL, string $description) {
        $this->id = $id;
        $this->name = $name;
        $this->russianname = $russianname;
        $this->episodes = $episodes;
        $this->year = $year;
        $this->posterURL = $posterURL;
        $this->description = $description;
    }
    public function getId(): int {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
    public function getRussianName(): string {
        return $this->russianname;
    }
    public function getEpisodes(): int {
        return $this->episodes;
    }
    public function getYear(): int {
        return $this->year;
    }
    public function getPosterURL(): string {
        return $this->posterURL;
    }
    public function getDescription(): string {
        return $this->description;
    }
    public function setId(int $id): Anime {
        $this->id = $id;
        return $this;
    }
    public function setName(string $name): Anime {
        $this->name = $name;
        return $this;
    }
    public function setRussianName(string $russianname): Anime {
        $this->russianname = $russianname;
        return $this;
    }
    public function setEpisodes(int $episodes): Anime {
        $this->episodes = $episodes;
        return $this;
    }
    public function setYear(int $year): Anime {
        $this->year = $year;
        return $this;
    }
    public function setPosterURL(string $posterURL): Anime {
        $this->posterURL = $posterURL;
        return $this;
    }
    public function setDescription(string $description): Anime {
        $this->description = $description;
        return $this;
    }
}