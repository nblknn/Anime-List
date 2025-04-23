<?php

declare (strict_types = 1);

require_once __DIR__ . '/../model/Anime.php';
require_once __DIR__ . '/../model/UserAnimeData.php';
require_once __DIR__ . '/../repository/AnimeRepository.php';
require_once __DIR__ . '/../repository/UserAnimeDataRepository.php';

class AnimeService {
    private const string IMAGE_DIR = '/view/images';
    private array $animes;
    private array $userAnimes;
    private AnimeRepository $animeRepository;
    private UserAnimeDataRepository $userAnimeDataRepository;

    public function __construct() {
        $this->animeRepository = new AnimeRepository();
        $this->userAnimeDataRepository = new UserAnimeDataRepository();

        $this->animes[] = new Anime(0, "Mob Psycho 100", "Моб Психо 100", 12, 2016, "Бросив первый поверхностный взгляд, мы узрим банальнейший сюжет, коих перевидали сотни: школа, кружки по интересам, ученики, пытающиеся выстроить свою личность и отношения в коллективе, разумеется, первая любовь, комплексы и тому подобные подростковые проблемы.
Однако эта история не будет ординарной. Эта история будет экстраординарной. И таковой ее сделает выдающийся главный герой. Шигэо Кагэяма вроде бы обычный японский школьник — стеснительный, старающийся не привлекать внимания, не блещущий умом, красотой или чувством юмора. И самое большое его желание — привлечь внимание любимой девушки. Но! У этого восьмиклассника есть экстрасенсорные способности. С детства он взглядом гнет ложки и передвигает предметы. И пусть общественность пока этого не оценила, зато выгоду в этом очень скоро нашел его «ментальный наставник», эксплуатирующий способности Кагэямы себе на поживу.
Как будет искать свой путь в этом привычно жестоком мире юный экстрасенс — нам и предстоит увидеть.");
        $this->animes[] = new Anime(1, "Shingeki no Kyojin", "Атака титанов", 25, 2013, "С давних времён человечество ведёт свою борьбу с титанами. Титаны — это огромные существа, ростом с многоэтажный дом, которые не обладают большим интеллектом, но сила их просто ужасна. Они едят людей и получают от этого удовольствие. После продолжительной борьбы остатки человечества создали стену, окружившую мир людей, через которую не пройдут даже титаны.
С тех пор прошло сто лет. Человечество мирно живёт под защитой стены. Но в один день мальчик Эрен и его сводная сестра Микаса становятся свидетелями страшного события: участок стены был разрушен супертитаном, появившимся прямо из воздуха. Титаны атакуют город, и двое детей в ужасе видят, как один из монстров заживо съедает их мать.
Брат и сестра выживают, и Эрен клянётся, что убьёт всех титанов и отомстит за всё человечество!");
        $this->animes[] = new Anime(2, "Boku no Hero Academia", "Моя геройская академия", 13, 2016, "Четырнадцатилетний Идзуку Мидория рано осознал, что люди не рождаются равными. А пришло это понимание, когда его начали дразнить одноклассники, одарённые особой силой. Несмотря на то, что большинство людей в этом мире рождаются с необычными способностями, Идзуку оказался среди тех немногих, кто напрочь их лишён.
        Однако это не стало помехой для мальчика в стремлении стать таким же легендарным героем, как Всемогущий. Для осуществления мечты Идзуку не без помощи своего кумира поступает в самую престижную академию героев — Юэй.
        Но это, очевидно, лишь начало его удивительных приключений.");

        $this->userAnimes[] = new UserAnimeData(0, true, 9);
        $this->userAnimes[] = new UserAnimeData(1, false);
        $this->userAnimes[] = new UserAnimeData(2, true, 10, "megacomment");
    }

    public function getPosterURL(int $animeID): string {
        return self::IMAGE_DIR . "/$animeID.jpg";
    }

    public function getListItem(Anime $anime, UserAnimeData | false $userAnime = false): array {
        $result = ["id" => $anime->getID(),
            "name" => $anime->getName(),
            "russianname" => $anime->getRussianName(),
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
        //without database
        $result = [];
        foreach ($this->userAnimes as $userAnime) {
            if ($userAnime->getIsWatched() === $isWatched) {
                $anime = $this->animes[$userAnime->getAnimeID()];
                $result[] = $this->getListItem($anime, $userAnime);
            }
        }
        return $result;

        //with database
        $userAnimes = $this->userAnimeDataRepository->searchByWatched($isWatched);
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
            $userAnimeData = $this->userAnimeDataRepository->searchByAnimeID($anime->getID());
            $result[] = $this->getListItem($anime, $userAnimeData);
        }
        return $result;
    }

    public function addAnimeToUserList(int $animeID): bool {
        return $this->userAnimeDataRepository->add(new UserAnimeData($animeID, false));
    }

    public function deleteAnimeFromUserList(int $animeID): bool {
        return $this->userAnimeDataRepository->delete($animeID);
    }

    public function updateAnimeInUserList(int $animeID, bool $isWatched, int $rating, string $comment): bool {
        return $this->userAnimeDataRepository->update(new UserAnimeData($animeID, $isWatched, $rating, $comment));
    }
}