<?php

namespace iutnc\deefy\action;
use iutnc\deefy\render as rdr;
use iutnc\deefy\repo\DeefyRepository;
use iutnc\deefy\audio\lists\AudioList;

class AfficherPlaylistAction extends Action{
    function __construct(){
        Action::__construct();
    }

    function execute() : string{
        $listePlaylistBD = [];

        try{
            $repo = DeefyRepository::getInstance();
            $listePlaylistBD = $repo->listePlaylist();

        } catch (\Exception $e){
            return 'Erreur (AfficherPlaylistAction) : ' . $e->getMessage();
        }

        if(empty($listePlaylistBD)){
            $html = '<p>Pas de playlist enregistré</p>';
        }

        $html = '<p>Cliquer sur une playlist remplacera votre playlist courante.<p>
                 <p>Vos playlists : </p>'; 
        foreach($listePlaylistBD as $playlist){
            $nom = $playlist->__get('nom');
            $id = $playlist->__get('id');

            $html .= "<div class='liste-playliste'>";
            $html .= "<a href='?action=afficher-detail&id={$id}'>{$nom}</a><br>";
        }
        return $html;
    } 
}