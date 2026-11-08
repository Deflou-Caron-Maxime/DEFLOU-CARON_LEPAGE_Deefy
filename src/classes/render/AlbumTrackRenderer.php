<?php
declare(strict_types=1);

namespace iutnc\deefy\render;

use \iutnc\deefy\audio\tracks as atr;


class AlbumTrackRenderer{

	// public string $genre; 

	
	public function __construct( 
		public atr\AlbumTrack $piste,
	) {}
	
	public function render(): string {
		return "<div>" 
            . "<p>{$this->piste->titre}</p>"
            . "<p>{$this->piste->album}</p>"
            . "</div>";
	}
	
}