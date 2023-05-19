<?php

declare(strict_types=1);

namespace Baccura\Controllers;

use GuzzleHttp\Client;

class VolController
{
    /**
     * Récupération du résultat de la recherche
     * @param string $data      Données de recherche
     * @param int $page         Page à récupérer
     */
    public function rechercher(string $data, int $page): void
    {
        $data = json_decode($data, true);

        $client = new Client();

        $response = $client->request('POST', "api?action=rechercher&page=$page", [
            'form_params' => $data
        ]);

        $body = $response->getBody();

        echo $body->getContents();
    }

    /**
     * Création de la réservation pour le vol
     * @param string $volId         ID du vol
     * @param string $data          Données de la réservation
     */
    public function reserver(string $volId, string $data): void
    {
        $data = json_decode($data, true);

        $client = new Client();

        $response = $client->request('POST', "api?action=reserver&volId=$volId", [
            'form_params' => $data
        ]);

        $body = $response->getBody();

        echo $body->getContents();
    }
}
