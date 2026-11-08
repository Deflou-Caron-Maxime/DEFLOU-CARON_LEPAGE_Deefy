<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\tracks;

use \iutnc\deefy\exception as xpt;

abstract class AudioTrack {

	private string $genre; 
	private int $duree = 0;
	
	public function __construct(
		private string $titre,
		private string $chemin,
	) {}
	
	public function __toString() : string {
		return json_encode(get_object_vars($this));
	}
	
	public function __get(string $at):mixed {
		if (property_exists ($this, $at)) return $this->$at;
		throw new xpt\InvalidPropertyNameException ("$at: invalid property");
	}

	public function setDuree(int $d) : void {
		if ($d > 60) throw new xpt\InvalidPropertyValueException("Durée trop grande !");
		$this->duree = $d;
	}

	public function setGenre(string $g) : void {
		$this->genre = $g;
	}


	
}