<?php
declare(strict_types=1);

namespace iutnc\deefy\render;

use \iutnc\deefy\audio\tracks as atr;


class PodcastTrackRender{


	
	public function __construct( 
		public atr\PodcastTrack $piste
	) {}
	
	public function render(): string {
		 return "<div>"
            . "<h3>" . htmlspecialchars($this->piste->titre) . "</h3>"
            . "<p>Auteur : " . htmlspecialchars($this->piste->getAuteur()) . "</p>"
            . "<p>Date : " . htmlspecialchars($this->piste->getDate()) . "</p>"
            . "<p>Chemin : " . htmlspecialchars($this->piste->chemin) . "</p>"
            . "</div>";
	}
	
}