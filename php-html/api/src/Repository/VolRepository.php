<?php

declare(strict_types=1);

namespace Baccura\Repository;

use Baccura\Lib\DatabaseConnection;
use Baccura\Model\Vol;
use DateTime;
use PDO;

class VolRepository
{
    public const NB_PER_PAGE = 2;
    public DatabaseConnection $connection;

    /**
     * Récupération de la liste des vols pour la recherche en paramètre
     * @param array $inputs         Les paramètres de recherches (villeDepart, villeRetour, dateDepart, dateRetour, nombrePassagers)
     * @param int $page             Numéro de page recherché
     * @return array    Tableau content le nombre de vols et la liste des vols
     */
    public function list(array $inputs, int $page = 1): array
    {
        $firstElem = ($page * self::NB_PER_PAGE) - self::NB_PER_PAGE;
        $villeDepart = $inputs['villeDepart'] ?? null;
        $villeRetour = $inputs['villeRetour'] ?? null;
        $dateDepart = $inputs['dateDepart'] ?? null;
        $dateRetour = $inputs['dateRetour'] ?? null;
        $nombrePassagers = $inputs['nombrePassagers'] ?? null;

        $where = [];
        if ($villeDepart)
            $where[] = "ville_depart = :villeDepart";
        if ($dateDepart)
            $where[] = "date_depart = :dateDepart";
        if ($villeRetour)
            $where[] = "ville_retour = :villeRetour";
        if ($dateRetour)
            $where[] = "date_retour = :dateRetour";
        if ($nombrePassagers)
            $where[] = "places_restante >= :nombrePassagers";

        $query = "SELECT id, ville_depart, ville_retour, date_depart, heure_depart, date_retour, heure_retour, prix 
            FROM vols 
            WHERE " . join(' AND ', $where) . "
            ORDER BY prix ASC
            LIMIT :first,:perPage";

        $statement = $this->connection->getConnection()->prepare($query);

        $statement->bindValue(':first', $firstElem, PDO::PARAM_INT);
        $statement->bindValue(':perPage', self::NB_PER_PAGE, PDO::PARAM_INT);

        if ($villeDepart)
            $statement->bindValue(':villeDepart', htmlspecialchars($villeDepart), PDO::PARAM_STR);
        if ($dateDepart)
            $statement->bindValue(':dateDepart', htmlspecialchars($dateDepart), PDO::PARAM_STR);
        if ($villeRetour)
            $statement->bindValue(':villeRetour', htmlspecialchars($villeRetour), PDO::PARAM_STR);
        if ($dateRetour)
            $statement->bindValue(':dateRetour', htmlspecialchars($dateRetour), PDO::PARAM_STR);
        if ($nombrePassagers)
            $statement->bindValue(':nombrePassagers', htmlspecialchars($nombrePassagers), PDO::PARAM_INT);

        $statement->execute();

        $vols = [];

        while ($row = $statement->fetch()) {
            $vol = new Vol();

            $vol->id = $row['id'];
            $vol->villeDepart = $row['ville_depart'];
            $vol->villeRetour = $row['ville_retour'];
            $vol->dateDepart = (new DateTime($row['date_depart']))->format('d/m/Y');
            $vol->heureDepart = $row['heure_depart'];
            $vol->dateRetour = (new DateTime($row['date_retour']))->format('d/m/Y');
            $vol->heureRetour = $row['heure_retour'];
            $vol->prix = number_format($row['prix'], 2, ',', '');

            $vols[] = $vol;
        }

        return $vols;
    }

    /**
     * Récupération du nombre de vols pour la rechercheen paramètre
     * @param array $inputs         Les paramètres de recherches (villeDepart, villeRetour, dateDepart, dateRetour, nombrePassagers)
     * @return int      Nombre de vols
     */
    public function count(array $inputs): int
    {
        $villeDepart = $inputs['villeDepart'] ?? null;
        $villeRetour = $inputs['villeRetour'] ?? null;
        $dateDepart = $inputs['dateDepart'] ?? null;
        $dateRetour = $inputs['dateRetour'] ?? null;
        $nombrePassagers = $inputs['nombrePassagers'] ?? null;

        $where = [];
        if ($villeDepart)
            $where[] = "ville_depart = :villeDepart";
        if ($dateDepart)
            $where[] = "date_depart = :dateDepart";
        if ($villeRetour)
            $where[] = "ville_retour = :villeRetour";
        if ($dateRetour)
            $where[] = "date_retour = :dateRetour";
        if ($nombrePassagers)
            $where[] = "places_restante >= :nombrePassagers";

        $query = "SELECT COUNT(id) AS nbVols FROM vols WHERE " . join(' AND ', $where);

        $statement = $this->connection->getConnection()->prepare($query);

        if ($villeDepart)
            $statement->bindValue(':villeDepart', htmlspecialchars($villeDepart), PDO::PARAM_STR);
        if ($dateDepart)
            $statement->bindValue(':dateDepart', htmlspecialchars($dateDepart), PDO::PARAM_STR);
        if ($nombrePassagers)
            $statement->bindValue(':nombrePassagers', htmlspecialchars($nombrePassagers), PDO::PARAM_INT);
        if ($villeRetour)
            $statement->bindValue(':villeRetour', htmlspecialchars($villeRetour), PDO::PARAM_STR);
        if ($dateRetour)
            $statement->bindValue(':dateRetour', htmlspecialchars($dateRetour), PDO::PARAM_STR);
        if ($nombrePassagers)
            $statement->bindValue(':nombrePassagers', htmlspecialchars($nombrePassagers), PDO::PARAM_INT);

        $statement->execute();

        $row = $statement->fetch();

        return (int) $row['nbVols'];
    }
}
