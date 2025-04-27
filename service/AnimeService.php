<?php

declare (strict_types = 1);

require_once __DIR__ . '/../model/Anime.php';
require_once __DIR__ . '/../model/UserAnimeData.php';
require_once __DIR__ . '/../repository/AnimeRepository.php';
require_once __DIR__ . '/../repository/UserAnimeDataRepository.php';

class AnimeService {
    private const string IMAGE_DIR = '/view/images';
    private AnimeRepository $animeRepository;
    private UserAnimeDataRepository $userAnimeDataRepository;
    private int $userID = 1;

    public function __construct() {
        $this->animeRepository = new AnimeRepository();
        $this->userAnimeDataRepository = new UserAnimeDataRepository();
    }

    public function getPosterURL(int $animeID): string {
        return self::IMAGE_DIR . "/$animeID.jpg";
    }

    public function getListItem(Anime $anime, UserAnimeData | false $userAnime = false): array {
        $result = ["id" => $anime->getID(),
            "name" => $anime->getName(),
            "russianName" => $anime->getRussianName(),
            "episodes" => $anime->getEpisodes(),
            "year" => $anime->getYear(),
            "posterURL" => $this->getPosterURL($anime->getID()),
            "description" => $anime->getDescription(),
            "isInList" => $userAnime != false,
        ];
        if ($userAnime) {
            $result["isWatched"] = $userAnime->getIsWatched();
            $result["comment"] = $userAnime->getComment();
            $result["rating"] = $userAnime->getRating();
        }
        return $result;
    }

    public function getUserAnimeList(bool $isWatched): array {
        $userAnimes = $this->userAnimeDataRepository->searchByWatched($isWatched, $this->userID);
        $result = [];
        foreach ($userAnimes as $userAnime) {
            $anime = $this->animeRepository->searchByID($userAnime->getAnimeID());
            $result[] = $this->getListItem($anime, $userAnime);
        }
        return $result;
    }

    public function searchAnimeByName(string $name): array {
        $animes = $this->animeRepository->searchByName($name);
        $result = [];
        foreach ($animes as $anime) {
            $userAnimeData = $this->userAnimeDataRepository->searchByAnimeID($anime->getID(), $this->userID);
            $result[] = $this->getListItem($anime, $userAnimeData);
        }
        return $result;
    }

    public function addAnimeToUserList(int $animeID): bool {
        return $this->userAnimeDataRepository->add(new UserAnimeData($animeID, $this->userID,false));
    }

    public function deleteAnimeFromUserList(int $animeID): bool {
        return $this->userAnimeDataRepository->delete($this->userAnimeDataRepository->searchByAnimeID($animeID, $this->userID));
    }

    public function updateAnimeInUserList(int $animeID, bool $isWatched, int $rating, string $comment): bool {
        return $this->userAnimeDataRepository->update(new UserAnimeData($animeID, $this->userID, $isWatched, $rating, $comment));
    }
}