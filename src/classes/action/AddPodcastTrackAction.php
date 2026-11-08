<?php

namespace iutnc\deefy\action;
use iutnc\deefy\render as rdr;
use iutnc\deefy\audio\tracks as trk;

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
            $titre = $_POST['titre'];
            $chemin = $_POST['chemin'];
            $auteur = $_POST['auteur'];
            if ($_POST['date'] === "") {
                $date = date('d/m/Y');
                
            } else {
                $date = $_POST['date'];   
            }
            

            $titre = filter_var($titre, FILTER_SANITIZE_SPECIAL_CHARS);
            $chemin = filter_var($chemin, FILTER_SANITIZE_SPECIAL_CHARS);
            $auteur = filter_var($auteur, FILTER_SANITIZE_SPECIAL_CHARS);
            $date = filter_var($date, FILTER_SANITIZE_SPECIAL_CHARS);

        
            if (isset($_FILES['fichier']) &&
                $_FILES['fichier']['error'] !== UPLOAD_ERR_NO_FILE) {

                $fichier = $_FILES['fichier'];

            
                if ($fichier['error'] !== UPLOAD_ERR_OK ||
                    !is_uploaded_file($fichier['tmp_name']) ||
                    substr($fichier['name'], -4) !== '.mp3' ||
                    $fichier['type'] !== 'audio/mpeg') {

                    return "Erreur : le fichier sélectionné n'est pas un MP3 valide.";
                }


                $nomAleatoire = uniqid();  
                // dirname pour remonter de 3 dossiers depuis le dossier actuel          
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

            $_SESSION['playlist'] = $playlist;

            $render = new rdr\AudioListRenderer($_SESSION['playlist']);

            return $render->render() . '<br><a href="?action=add-track">Ajouter encore une piste</a>';
        }
    }


}