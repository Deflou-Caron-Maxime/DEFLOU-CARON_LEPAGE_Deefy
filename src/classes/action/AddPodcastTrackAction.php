<?php

namespace iutnc\deefy\action;
use iutnc\deefy\audio\tracks as trk;
use iutnc\deefy\render as rdr;
use iutnc\deefy\repo\DeefyRepository;


class AddPodcastTrackAction extends Action {
    
    public function __construct(){
        Action::__construct();
    }

    public function execute() : string {
         if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return <<<HTML
                    <form method="post" action="?action=add-track" enctype="multipart/form-data">
                    <label for="Titre">Titre</label>
                    <input type="text" id="titre" name="titre" placeholder="Titre">
                    <label for="Chemin">Chemin</label>
                    <input type="text" id="chemin" name="chemin" placeholder="Chemin">
                    <label for="auteur">Auteur</label>
                    <input type="text" id="auteur" name="auteur" placeholder="Auteur">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" placeholder="Date">
                    <label for="ficher">Fichier Audio</label>
                    <input type="file" id="fichier" name="fichier" accept=".mp3">
                    <button type="submit">Valider</button>
                    HTML;
        } else {
            $titre = filter_var($_POST['titre'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $chemin = filter_var($_POST['chemin'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $auteur = filter_var($_POST['auteur'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            $date = empty($_POST['date']) ? date('Y-m-d') : filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS);

            if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] !== UPLOAD_ERR_NO_FILE) {
                $fichier = $_FILES['fichier'];

                if ($fichier['error'] !== UPLOAD_ERR_OK ||
                    !is_uploaded_file($fichier['tmp_name']) ||
                    substr($fichier['name'], -4) !== '.mp3' ||
                    $fichier['type'] !== 'audio/mpeg') {

                    return "Erreur : le fichier sélectionné n'est pas un MP3 valide.";
                }

                $nomAleatoire = uniqid();
                $upload_dir = dirname(__DIR__, 3) . '/audio/';
                $destination = $upload_dir . $nomAleatoire . '.mp3';

                if (move_uploaded_file($fichier['tmp_name'], $destination)) {
                    $chemin = 'audio/' . $nomAleatoire . '.mp3';
                } else {
                    return "Erreur lors de l'enregistrement du fichier.";
                }
            }

            $track = new trk\PodcastTrack($titre, $chemin);
            $track->setAuteur($auteur);
            $track->setDate($date);

            $playlist = $_SESSION['playlist'];
            $playlist->addTrack($track);

            try {
                $repo = DeefyRepository::getInstance();
                // On passe bien l'ID entier ($playlist->id) et non l'objet $playlist
                $repo->insererPodcastTrack($track, $playlist->id);
            } catch (\Exception $e) {
                return $e->getMessage();
            }

            $_SESSION['playlist'] = serialize($playlist);

            $render = new rdr\AudioListRenderer($_SESSION['playlist']);
            return $render->render() . '<br><a href="?action=add-track">Ajouter encore une piste</a>';
        }
    }


}