<?php 

namespace iutnc\deefy\audio\lists;
use \iutnc\deefy\exception as xpt;
use \iutnc\deefy\audio\tracks as trk;

class AudioList {

    private int $nb_pistes, $duree_totale = 0;

    public function __construct(private string $nom, private Array $pistes = []){
        
        foreach ($pistes as $track){
            $this->duree_totale += $track->duree;   
        }
        $this->nb_pistes = count($pistes);
    }

    public function __get($at){
        if (property_exists($this, $at)) return $this->$at;
        return new xpt\InvalidPropertyNameException("Attribut introuvable !");
    }

    public function addTrack(trk\AudioTrack $music) : void {
        $this->pistes[] = $music;
        $this->nb_pistes++;
        $this->duree_totale += $music->duree;
    }

}