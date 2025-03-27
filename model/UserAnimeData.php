<?php

declare (strict_types = 1);

namespace Model;

class UserAnimeData {
    private int $animeid;
    private bool $isWatched;
    private int $rating;
    private string $comment;
    public function __construct(int $animeid, bool $isWatched, int $rating, string $comment) {
        $this->animeid = $animeid;
        $this->isWatched = $isWatched;
        $this->rating = $rating;
        $this->comment = $comment;
    }
    public function getAnimeID(): int {
        return $this->animeid;
    }
    public function getIsWatched(): bool {
        return $this->isWatched;
    }
    public function getRating(): int {
        return $this->rating;
    }
    public function getComment(): string {
        return $this->comment;
    }
    public function setAnimeid(int $animeid): UserAnimeData {
        $this->animeid = $animeid;
        return $this;
    }
    public function setIsWatched(bool $isWatched): UserAnimeData {
        $this->isWatched = $isWatched;
        return $this;
    }
    public function setRating(int $rating): UserAnimeData {
        $this->rating = $rating;
        return $this;
    }
    public function setComment(string $comment): UserAnimeData {
        $this->comment = $comment;
        return $this;
    }
}