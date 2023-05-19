<?php

declare(strict_types=1);

namespace Baccura\Controllers;

use Baccura\Lib\DatabaseConnection;
use Baccura\Repository\VolRepository;

class VolController
{
    /**
     * Récupérer la liste des vols pour la recherche en paramètre
     * @param array $input          Données du formulaire
     * @param int $page          Numéro de page à récupérer
     */
    public function list(array $inputs, int $page = 1): void
    {
        $page = $page ?? 1;

        // Récupération des vols
        $volRepository = new VolRepository();
        $volRepository->connection = new DatabaseConnection();
        $total = $volRepository->count($inputs);

        if (!$total) {
            $result = [
                'status' => 201,
                'total' => $total,
            ];

            echo json_encode($result);
        } else {
            $vols = $volRepository->list($inputs, $page);

            $result = [
                'status' => 201,
                'data' => $vols,
                'total' => $total,
                'page' => $page,
                'perPage' => $volRepository::NB_PER_PAGE
            ];

            echo json_encode($result);
        }
    }
}
