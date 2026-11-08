<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\tracks;

abstract class AudioTrack {

	private string $genre; 
	private int $duree;
	
	public function __construct(
		private string $titre,
		private string $chemin,
	) {}
	
	public function __toString() : string {
		return json_encode(get_object_vars($this));
	}
	
	public function __get(string $at):mixed {
		if (property_exists ($this, $at)) return $this->$at;
		throw new Exception ("$at: invalid property");
	}
	
}