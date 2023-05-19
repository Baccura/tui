<?php

declare(strict_types=1);

namespace Baccura\Controllers;

use Baccura\Lib\DatabaseConnection;
use Baccura\Repository\ReservationRepository;
use Exception;

class ReservationController
{
    /**
     * Création d'une réservation
     * @param string $volId     ID du vol
     * @param array $input      Données du formulaire
     */
    public function add(string $volId, array $inputs): void
    {
        $nom = null;
        $prenom = null;
        $email = null;
        $telephone = null;

        // Vérification des données du formulaires
        if (isset($inputs['nom']) && $inputs['nom'] && isset($inputs['prenom']) && $inputs['prenom'] && isset($inputs['email']) && $inputs['email'] && isset($inputs['telephone']) && $inputs['telephone']) {
            $nom = $inputs['nom'];
            $prenom = $inputs['prenom'];
            $email = $inputs['email'];
            $telephone = $inputs['telephone'];

            // Création de la réservation
            $reservationRepository = new ReservationRepository();
            $reservationRepository->connection = new DatabaseConnection();
            $success = $reservationRepository->add($volId, $nom, $prenom, $email, $telephone);

            if (!$success) {
                throw new Exception("Impossible de créer la réservation");
            } else {
                $result = [
                    'status' => 201,
                    'data' => $volId
                ];
                echo json_encode($result);
            }
        } else {
            throw new Exception("Aucunes données saisies pour la réservation");
        }
    }
}
