<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack {

	private string $auteur;
	private string $date;

	public function __get(string $at):mixed {
		if (property_exists ($this, $at)) return $this->$at;
		throw new xpt\InvalidPropertyNameException ("$at: invalid property");
	}
	
	public function setAuteur(string $auteur) {
		$this->auteur = $auteur;
	}	
	
	public function setDate(string $date) {
		$this->date = $date;
	}
	
	public function getAuteur(): string {
        return $this->auteur;
    }

    public function getDate(): string {
        return $this->date;
    }

	
}