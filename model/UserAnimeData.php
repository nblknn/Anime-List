<?php

declare (strict_types = 1);

class UserAnimeData {
    private int $animeID;
    private bool $isWatched;
    private int | null $rating;
    private string | null $comment;
    public function __construct(int $animeid, bool $isWatched, int | null $rating = null, string | null $comment = null) {
        $this->animeID = $animeid;
        $this->isWatched = $isWatched;
        $this->rating = $rating;
        $this->comment = $comment;
    }
    public function getAnimeID(): int {
        return $this->animeID;
    }
    public function getIsWatched(): bool {
        return $this->isWatched;
    }
    public function getRating(): int | null {
        return $this->rating;
    }
    public function getComment(): string | null {
        return $this->comment;
    }
    public function setAnimeID(int $animeid): UserAnimeData {
        $this->animeID = $animeid;
        return $this;
    }
    public function setIsWatched(bool $isWatched): UserAnimeData {
        $this->isWatched = $isWatched;
        return $this;
    }
    public function setRating(int | null $rating): UserAnimeData {
        $this->rating = $rating;
        return $this;
    }
    public function setComment(string | null $comment): UserAnimeData {
        $this->comment = $comment;
        return $this;
    }
}