<?php

declare(strict_types=1);

namespace Baccura\Model;

class Vol
{
    public int $id;
    public string $villeDepart;
    public string $villeRetour;
    public string $dateDepart;
    public string $heureDepart;
    public string $dateRetour;
    public string $heureRetour;
    public string $prix;
}
