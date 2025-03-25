<?php

class UserAnimeData {
    private int $animeid;
    private bool $isWatched;
    private int $rating;
    private string $comment;
    public function __construct($animeid, $isWatched, $rating, $comment) {
        $this->animeid = $animeid;
        $this->isWatched = $isWatched;
        $this->rating = $rating;
        $this->comment = $comment;
    }
    public function getAnimeid() {
        return $this->animeid;
    }
    public function getIsWatched() {
        return $this->isWatched;
    }
    public function getRating() {
        return $this->rating;
    }
    public function getComment() {
        return $this->comment;
    }
    public function setAnimeid($animeid) {
        $this->animeid = $animeid;
    }
    public function setIsWatched($isWatched) {
        $this->isWatched = $isWatched;
    }
    public function setRating($rating) {
        $this->rating = $rating;
    }
    public function setComment($comment) {
        $this->comment = $comment;
    }
}