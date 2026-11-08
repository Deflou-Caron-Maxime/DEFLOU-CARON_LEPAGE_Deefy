<?php

namespace iutnc\deefy\action;

class DefaultAction extends Action {
    
    public function __construct(){
        Action::__construct();
    }

    public function execute() : string {
        return 'Bienvenue ! ' ;
    }

}