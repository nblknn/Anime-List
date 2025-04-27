<?php

declare (strict_types = 1);

class UserAnimeData {
    private int $animeID;
    private int $userID;
    private bool $isWatched;
    private ?int $rating;
    private ?string $comment;

    public function __construct(int $animeid, int $userID, bool $isWatched, ?int $rating = null, ?string $comment = null) {
        $this->animeID = $animeid;
        $this->userID = $userID;
        $this->isWatched = $isWatched;
        $this->rating = $rating;
        $this->comment = $comment;
    }

    public function getAnimeID(): int {
        return $this->animeID;
    }

    public function getUserID(): int {
        return $this->userID;
    }

    public function getIsWatched(): bool {
        return $this->isWatched;
    }

    public function getRating(): ?int {
        return $this->rating;
    }

    public function getComment(): ?string {
        return $this->comment;
    }

    public function setAnimeID(int $animeID): UserAnimeData {
        $this->animeID = $animeID;
        return $this;
    }

    public function setUserID(int $userID): UserAnimeData {
        $this->userID = $userID;
        return $this;
    }

    public function setIsWatched(bool $isWatched): UserAnimeData {
        $this->isWatched = $isWatched;
        return $this;
    }

    public function setRating(?int $rating): UserAnimeData {
        $this->rating = $rating;
        return $this;
    }

    public function setComment(?string $comment): UserAnimeData {
        $this->comment = $comment;
        return $this;
    }
}