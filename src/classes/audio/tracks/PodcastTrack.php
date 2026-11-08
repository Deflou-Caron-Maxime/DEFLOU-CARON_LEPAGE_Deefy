<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack {

	private string $auteur;
	private string $date;
	
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