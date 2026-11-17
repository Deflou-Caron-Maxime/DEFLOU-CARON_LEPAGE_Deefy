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

        $html = '';
        foreach($listePlaylistBD as $playlist){
            $render = new rdr\AudioListRenderer($playlist);
            $html .= $render->render() . "<br>";
        }
        return $html;
    } 
}