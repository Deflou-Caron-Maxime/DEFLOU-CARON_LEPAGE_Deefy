<?php
declare(strict_types=1);

use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\action as act;
use iutnc\deefy\repo\DeefyRepository;

require_once('vendor/autoload.php');

session_start();

DeefyRepository::setConfig(__DIR__ . '/config.ini');

$dispatcher = new Dispatcher();

$dispatcher->addRoute('default', act\DefaultAction::class)
            ->addRoute('add-playlist', act\AddPlaylistAction::class)
            ->addRoute('add-track', act\AddPodcastTrackAction::class)
            ->addRoute('add-user', act\AddUserAction::class)
            ->addRoute('clear-session', act\ViderSessionAction::class)
            ->addRoute('show-playlist', act\AfficherPlaylistAction::class)
            ->addRoute('afficher-detail', act\DetaillerPlaylistAction::class)
            ->addRoute('playlist-session', act\AfficherPlaylistSessionAction::class);

$dispatcher->run();

    