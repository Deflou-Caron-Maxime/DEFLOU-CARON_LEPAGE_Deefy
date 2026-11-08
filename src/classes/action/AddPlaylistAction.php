<?php

namespace iutnc\deefy\action;
use iutnc\deefy\audio\lists as lst;
use iutnc\deefy\render as rdr;

class AddPlaylistAction extends Action {
    
    public function __construct(){
        Action::__construct();
    }

    public function execute() : string {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return <<<HTML
                    <form method="post" action="?action=add-playlist">
                    <label for="Nom">Nom de la playlist</label>
                    <input type="text" id="nom" name="nom" placeholder="Nom">
                    HTML;
        } else {
            $nom = $_POST['nom'];
            $nom = filter_var($nom, FILTER_SANITIZE_SPECIAL_CHARS);
            
            if ($nom === ''){
                return 'Veuillez entrez un nom de playlist valide.';
            }

            $playlist = new lst\AudioList($nom);
            $_SESSION['playlist'] = $playlist;

            $render = new rdr\AudioListRenderer($playlist);
            return $render->render() . '<p><a href="?action=add-track">Ajouter une piste</a></p>';
             
        }

    }

}