<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\tracks;

use \iutnc\deefy\exception as xpt;

class AlbumTrack extends AudioTrack {

	protected string $artiste;
	protected string $annee;
	
	public function __construct(
		string $titre,
		string $chemin,
		protected string $album,
		protected int $numero, 
	) {
		parent::__construct($titre, $chemin);
	}
		
	public function setArtiste(string $artiste) {
		$this->artiste = $artiste;
	}		
	public function setAnnee(int $annee) {
		if ($annee > 2027) throw new xpt\InvalidPropertyValueException("Année trop grande");
		$this->annee = $annee;
	}
	

	public function __get(string $at):mixed {
		if (property_exists ($this, $at)) return $this->$at;
		return parent::__get($at);
	}
	
}