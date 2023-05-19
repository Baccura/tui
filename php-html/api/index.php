<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Baccura\Controllers\ReservationController;
use Baccura\Controllers\VolController;

header('Content-Type: application/json; charset=utf-8');

// Routeur
try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'rechercher':
                // Affichage de la liste des vols
                $page = $_GET['page'] ?? 1;
                (new VolController())->list($_POST, $page);
                break;
            case 'reserver':
                // Réserver un vol
                if (isset($_GET['volId']) && $_GET['volId'] > 0) {
                    $volId = $_GET['volId'];

                    (new ReservationController())->add($volId, $_POST);
                } else {
                    throw new Exception("Le vol n'existe pas !");
                }
                break;
            default:
                // Affichage de la liste des vols
                $page = $_GET['page'] ?? 1;
                (new VolController())->list($_POST, $page);
                break;
        }
    } else {
        throw new Exception("Cet appel api n'existe pas !");
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    $result = [
        'status' => 500,
        'error' => $errorMessage
    ];
    echo json_encode($result);
}
