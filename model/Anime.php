<?php

declare (strict_types = 1);

class Anime {
    private int $id;
    private string $name;
    private string $russianName;
    private int $episodes;
    private int $year;
    private string $description;

    public function __construct(int $id, string $name, string $russianName, int $episodes,
                                int $year, string $description) {
        $this->id = $id;
        $this->name = $name;
        $this->russianName = $russianName;
        $this->episodes = $episodes;
        $this->year = $year;
        $this->description = $description;
    }

    public function getID(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getRussianName(): string {
        return $this->russianName;
    }

    public function getEpisodes(): int {
        return $this->episodes;
    }

    public function getYear(): int {
        return $this->year;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setID(int $id): Anime {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): Anime {
        $this->name = $name;
        return $this;
    }

    public function setRussianName(string $russianName): Anime {
        $this->russianName = $russianName;
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

    public function setDescription(string $description): Anime {
        $this->description = $description;
        return $this;
    }
}