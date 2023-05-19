<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Baccura\Controllers\VolController;

// Routeur
try {
	if (isset($_GET['action'])) {
		switch ($_GET['action']) {
			case 'rechercher':
				// Récupérer la liste des vols pour la recherche
				if ($data = file_get_contents("php://input")) {
					$page = $_GET['page'] ?? 1;
					(new VolController())->rechercher($data, $page);
				} else {
					throw new Exception("Error lors de la recherche");
				}
				break;
			case 'reserver':
				// Réserver un vol
				$data = file_get_contents("php://input");

				if ($data && isset($_GET['volId']) && $_GET['volId'] > 0) {
					$volId = $_GET['volId'];

					(new VolController())->reserver($volId, $data);
				} else {
					throw new Exception("Le vol n'existe pas !");
				}
				break;
			default:
				// Affichage de la liste des vols
				require 'templates/vols/list.php';
				break;
		}
	} else {
		require 'templates/vols/list.php';
	}
} catch (Exception $e) {
	$errorMessage = $e->getMessage();

	require 'templates/error.php';
}
