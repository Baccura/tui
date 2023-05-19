<?php

declare(strict_types=1);

namespace Baccura\Model;

class Reservation
{
    public int $id;
    public int $volId;
    public string $prenom;
    public string $nom;
    public string $email;
    public string $telephone;
}
