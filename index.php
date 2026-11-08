<?php
declare(strict_types=1);

use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\action as act;

require_once('vendor/autoload.php');

session_start();

$dispatcher = new Dispatcher();

$dispatcher->addRoute('default', act\DefaultAction::class)
            ->addRoute('add-playlist', act\AddPlaylistAction::class)
            ->addRoute('add-track', act\AddPodcastTrackAction::class)
            ->addRoute('add-user', act\AddUserAction::class)
            ->addRoute('clear-session', act\ViderSessionAction::class);

$dispatcher->run();

    