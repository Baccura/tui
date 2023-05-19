<?php

declare(strict_types=1);

namespace Baccura\Lib;

use Exception;
use PDO;

class DatabaseConnection
{
    public ?PDO $database = null;

    /**
     * Création de la connexion à la base de données
     * @return PDO
     */
    public function getConnection(): PDO
    {
        try {
            if (!$this->database)
                $this->database = new PDO('mysql:host=db;dbname=tui;charset=utf8', 'root', 'root');

            return $this->database;
        } catch (Exception $e) {
            throw new Exception('Impossible de se connecter à la base de données');
        }
    }
}
