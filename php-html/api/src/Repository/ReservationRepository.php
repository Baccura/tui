<?php

declare(strict_types=1);

namespace Baccura\Repository;

use Baccura\Lib\DatabaseConnection;
use PDO;

class ReservationRepository
{
    public DatabaseConnection $connection;

    /**
     * Création de la réservation
     * @param string $volId     ID du vol
     * @param string $nom       Nom du passager
     * @param string $prenom       Prenom du passager
     * @param string $email       Email du passager
     * @param string $telephone       Téléphone du passager
     * @return bool
     */
    public function add(string $volId, string $nom, string $prenom, string $email, string $telephone): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO reservations (vols_id, nom, prenom, email, telephone) VALUES (:volId, :nom, :prenom, :email, :telephone)"
        );

        $statement->bindValue(':volId', htmlspecialchars($volId), PDO::PARAM_INT);
        $statement->bindValue(':nom', htmlspecialchars($nom), PDO::PARAM_STR);
        $statement->bindValue(':prenom', htmlspecialchars($prenom), PDO::PARAM_STR);
        $statement->bindValue(':email', htmlspecialchars($email), PDO::PARAM_STR);
        $statement->bindValue(':telephone', htmlspecialchars($telephone), PDO::PARAM_STR);

        $affectedLines = $statement->execute();

        return ($affectedLines > 0);
    }
}
