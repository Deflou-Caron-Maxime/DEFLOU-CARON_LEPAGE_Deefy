<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render as rdr;
use iutnc\deefy\repo\DeefyRepository;

class DetaillerPlaylistAction extends Action{
    function __construct(){
        Action::__construct();
    }

    function execute(): string{
        $html = '';

        if(!isset($_GET['id'])){
            $html .= '<p>Aucune piste enregistré pour cette playlist';
        }

        $idPlaylist = $_GET['id'];
        
        try{
            $repo = DeefyRepository::getInstance();
            $playlistCourante = $repo->getPlaylistId($idPlaylist);
            $albumPlaylist = $repo->getAlbumTrackPlaylist($idPlaylist);
            $podcastPlaylist = $repo->getPodcastTrackPlaylist($idPlaylist);

        }catch (\Exception $e){
            return 'Erreur (DetaillerPlaylistAction) : ' . $e->getMessage();
        } 
        $_SESSION['playlist'] = serialize($playlistCourante);

        $html .= '<p>Playlist : </p><br>';
        $renderPlaylist = new rdr\AudioListRenderer($playlistCourante);
        $html .= $renderPlaylist->render() . '<br>';

        return $html;
    }
}