<?php 

namespace iutnc\deefy\render;
use \iutnc\deefy\audio\lists as lst;
use iutnc\deefy\audio\tracks as trk;

class AudioListRenderer{

    public function __construct( 
		public lst\AudioList $playlist,
	) {}
	
	public function render(): string {

        $ch = 'Nom : ' . $this->playlist->__get("nom");
        foreach($this->playlist->__get('pistes') as $p){
           if ($p instanceof trk\PodcastTrack) {
                $prender = new PodcastTrackRender($p);

            } elseif ($p instanceof trk\AlbumTrack) {
                $prender = new AlbumTrackRenderer($p);

            }

            $ch .= $prender->render() . '<br>';
            
        }
        return $ch;
	}
}