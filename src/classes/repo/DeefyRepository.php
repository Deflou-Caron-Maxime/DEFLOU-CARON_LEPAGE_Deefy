<?php
namespace iutnc\deefy\repo;
use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;

//Reprit des TD de cours

class DeefyRepository {
    protected \PDO $pdo;
    protected static ?DeefyRepository $instance = null;
    protected static array $config = [ ];

    protected function __construct(array $conf) {
        $this->pdo = new \PDO($conf['dsn'], $conf['user'], $conf['pass'],
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public static function getInstance(){
        if (is_null(static::$instance)) {
            static::$instance = new static(self::$config);
        }
        return static::$instance;
    }

    public static function setConfig(string $file) {
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Error reading configuration file");
        }
        self::$config = [ 'dsn'=> "{$conf['driver']}:host={$conf['host']};dbname={$conf['database']}",
                            'user'=> $conf['username'],
                            'pass'=> $conf['password'] ];
    }



    public function insererPlaylist(AudioList $playlist): int {
        $query = "INSERT INTO Playlist (nom, duree, nbpistes) VALUES (:nom, :duree, :nbpistes)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'nom'      => $playlist->nom,
            'duree'    => $playlist->duree_totale,
            'nbpistes' => $playlist->nb_pistes
        ]);

        $idPlaylist = (int)$this->pdo->lastInsertId();
        $playlist->setIdPlayList($idPlaylist);

        return $idPlaylist;
    }

    
    public function insererAlbumTrack(AlbumTrack $piste, int $idPlaylist): void {
        $stmtTrack = $this->pdo->prepare(
            "INSERT INTO Albumtrack (titre, chemin, artiste, album, genre, duree, annee) 
             VALUES (:titre, :chemin, :artiste, :album, :genre, :duree, :annee)"
        );
        $stmtTrack->execute([
            ':titre' => $piste->titre,
            ':chemin' => $piste->chemin,
            ':artiste' => $piste->artiste ?? '',
            ':album' => $piste->album,
            ':genre' => $piste->genre ?? '',
            ':duree' => $piste->duree,
            ':annee' => $piste->annee ?? date('Y-m-d')
        ]);

        $numTrack = (int)$this->pdo->lastInsertId();

        $stmtLien = $this->pdo->prepare(
            "INSERT INTO PlaylistAlbum (id, numero) VALUES (:id, :numero)"
        );
        $stmtLien->execute([
            ':id'     => $idPlaylist,
            ':numero' => $numTrack
        ]);
    }

   
    public function insererPodcastTrack(PodcastTrack $piste, int $idPlaylist): void {
        $stmtTrack = $this->pdo->prepare(
            "INSERT INTO Podcasttrack (auteur, datePodcasttrack, genre, duree, titre, chemin) 
             VALUES (:auteur, :datePodcasttrack, :genre, :duree, :titre, :chemin)"
        );
        $stmtTrack->execute([
            ':auteur' => $piste->__get('auteur') ?? '',
            ':datePodcasttrack' => $piste->__get('date') ?? date('Y-m-d'),
            ':genre' => $piste->__get('genre') ?? '',
            ':duree' => $piste->__get('duree'),
            ':titre' => $piste->__get('titre'),
            ':chemin' => $piste->__get('chemin')
        ]);

        $numTrack = (int)$this->pdo->lastInsertId();

        $stmtLien = $this->pdo->prepare(
            "INSERT INTO PlaylistPodcast (id, numero) VALUES (:id, :numero)"
        );
        $stmtLien->execute([
            ':id' => $idPlaylist,
            ':numero' => $numTrack
        ]);
    }


    public function listePlaylist() : array{
        $query = "SELECT * FROM Playlist";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $lignes = $stmt->fetchAll();

        $listePlaylist = [];

        foreach($lignes as $ligne){
            //Récupérer la liste de piste avant **
            $playlist = new AudioList($ligne['nom']);
            $playlist->setIdPlayList($ligne['id']);
            $playlist->setDuree($ligne['duree']);
            $playlist->setNbPistes($ligne['nbpistes']);

            $listePlaylist[] = $playlist;
        }
        return $listePlaylist;
    }

    public function getAlbumTrackPlaylist(int $id): array {
        $query = "SELECT Albumtrack.* 
                  FROM Albumtrack
                  INNER JOIN PlaylistAlbum ON Albumtrack.numero = PlaylistAlbum.numero
                  WHERE PlaylistAlbum.id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        $lignes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $tracks = [];
        foreach ($lignes as $ligne) {
            $track = new AlbumTrack(
                $ligne['titre'],
                $ligne['chemin'],
                $ligne['album'],
                (int)$ligne['numero']
            );

            $track->setArtiste($ligne['artiste']);
            $track->setGenre($ligne['genre']);
            $track->setDuree((int)$ligne['duree']);

            if (!empty($ligne['annee'])) {
                $track->setAnnee($ligne['annee']);
            }

            $tracks[] = $track;
        }

        return $tracks;
    }
    
    public function getPodcastTrackPlaylist($id){
        $query = "SELECT Podcasttrack.* 
                  FROM Podcasttrack 
                  INNER JOIN PlaylistPodcast ON Podcasttrack.numero = PlaylistPodcast.numero
                  WHERE PlaylistPodcast.id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        $lignes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $tracks = [];
        foreach ($lignes as $ligne) {
            $track = new PodcastTrack(
                $ligne['titre'],
                $ligne['chemin']
            );

            $track->setAuteur($ligne['auteur']);
            $track->setDate($ligne['datePodcasttrack']);
            $track->setGenre($ligne['genre']);
            $track->setDuree((int)$ligne['duree']);

            $tracks[] = $track;
        }

        return $tracks;
    }
}