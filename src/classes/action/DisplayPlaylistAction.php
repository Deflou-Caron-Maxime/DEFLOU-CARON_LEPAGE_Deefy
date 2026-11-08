<?php

namespace iutnc\deefy\action;

class DisplayPlaylistAction extends Action {
    
    public function __construct(){
        Action::__construct();
    }

    public function execute() : string {
        if (isset($_SESSION['playlist'])){
            echo $_SESSION['playlist']->render();
        } else {
            echo 'Aucune playlist dans la session...';
        }
    }

}