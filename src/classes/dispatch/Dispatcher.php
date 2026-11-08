<?php

namespace iutnc\deefy\dispatch;

class Dispatcher {
    private String $action;
    private array $routes;
    public function __construct(){
        if (isset($_GET['action'])){
            $this->action = $_GET['action'];
        } else {
            $this->action = 'default';
        }
        
    }

    public function run() : void {
        if (isset($this->routes[$this->action])) {
			$html = (new ($this->routes[$this->action])())->execute();
			$this->renderPage($html);	
		} else {
			throw new \Exception("Action '{$this->action}' not found");	
		}
    }
            

    public function addRoute(string $action, string $class) : self {
        $this->routes[$action] = $class;
        return $this;
    }

    private function renderPage(string $html) : void {
        echo "<!DOCTYPE HTML>
        <html lang='fr'>
        <head>
            <title>Deefy</title>
        </head>
        <body>
        <h1>Deefy</h1>
            $html
            <a href='?action=clear-session'>Vider le cache</a>
            <a href='?action=add-user'>Inscription</a>
            <a href='?action=add-playlist'>Nouvelle playlist</a>
            <a href='?action=default'>Accueil</a>
        </body>
        </html>";
    }
}