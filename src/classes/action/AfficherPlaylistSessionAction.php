<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render\AudiolistRenderer;

class AfficherPlaylistSessionAction extends Action{
    
    public function execute():string{
        if(empty($_SESSION['playlist'])){
            return '<p>Aucune playlist enregistré dans votre session, ajoutez-en une !</p>';
        }

    
        $playlistCourante = unserialize($_SESSION['playlist']);
        $render = new AudiolistRenderer($playlistCourante);
        
        $html = $render->render();
        
        $html .= '<p><a href="?action=add-track">Ajouter une piste à votre playlist</a>';


        return $html;

    }
    
}