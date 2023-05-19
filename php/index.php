<?php

declare(strict_types=1);

class Reservation
{
	static function TrouverChambresDisponibles(array $chambres, DateTime $dateDebut, DateTime $dateFin, int $nombreChambres, int $nombrePersonnes): array
	{
		$disponibilites = [];

		// On parcours la liste des chambres disponibles
		foreach ($chambres as $chambre) {
			// On vérifie que la chambre correspond aux dates demandées
			if (($dateDebut >= $chambre['dateDebut']) && ($dateFin <= $chambre['dateFin'])) {
				// On récupère le numéro de la chambre et on met à jour le nombre de chambres et le nombre de personnes recherchés
				if ($nombreChambres > 1) {
					$disponibilites[] = $chambre['numChambre'];

					$nombrePersonnes -= $chambre['capacite'];
					--$nombreChambres;
					// On vérifie la capacité pour la dernière chambre à rechercher et on termine le traitement
				} elseif ($nombrePersonnes <= $chambre['capacite']) {
					$disponibilites[] = $chambre['numChambre'];

					break;
				}
			}
		}

		// On retourne les numéros de chambres correspondant à la recherche, sinon on retourne un tableau vide
		return (count($disponibilites) < $nombreChambres) ? [] : $disponibilites;
	}
}

$chambres = [
	['numChambre' => 101, 'dateDebut' => new DateTime('2023-03-01'), 'dateFin' => new DateTime('2023-03-05'), 'capacite' => 2],
	['numChambre' => 101, 'dateDebut' => new DateTime('2023-03-07'), 'dateFin' => new DateTime('2023-03-10'), 'capacite' => 2],
	['numChambre' => 102, 'dateDebut' => new DateTime('2023-03-01'), 'dateFin' => new DateTime('2023-03-10'), 'capacite' => 2],
	['numChambre' => 103, 'dateDebut' => new DateTime('2023-03-03'), 'dateFin' => new DateTime('2023-03-08'), 'capacite' => 3],
	['numChambre' => 103, 'dateDebut' => new DateTime('2023-03-10'), 'dateFin' => new DateTime('2023-03-15'), 'capacite' => 3],
	['numChambre' => 104, 'dateDebut' => new DateTime('2023-03-01'), 'dateFin' => new DateTime('2023-03-15'), 'capacite' => 4],
];

// exemple :
$disponibilites = Reservation::TrouverChambresDisponibles($chambres, new DateTime('2023-03-03'), new DateTime('2023-03-05'), 2, 4);

echo "recherche - 2 chambres, pour 4 personnes, du 03/03/2023 au 05/03/2023 :\n";

foreach ($disponibilites as $chambre) {
	echo "Chambre disponible : $chambre\n";
}

echo "__________________________\n";

// exemple :
$disponibilites = Reservation::TrouverChambresDisponibles($chambres, new DateTime('2023-04-03'), new DateTime('2023-04-05'), 2, 4);

echo "recherche - 2 chambres, pour 4 personnes, du 03/04/2023 au 05/04/2023 :\n";

foreach ($disponibilites as $chambre) {
	echo "Chambre disponible : $chambre\n";
}

echo "__________________________\n";

// exemple :
$disponibilites = Reservation::TrouverChambresDisponibles($chambres, new DateTime('2023-03-03'), new DateTime('2023-03-05'), 1, 4);

echo "recherche - 1 chambre, pour 4 personnes, du 03/03/2023 au 05/03/2023 :\n";

foreach ($disponibilites as $chambre) {
	echo "Chambre disponible : $chambre\n";
}

echo "__________________________\n";

// exemple :
$disponibilites = Reservation::TrouverChambresDisponibles($chambres, new DateTime('2023-03-03'), new DateTime('2023-03-05'), 2, 3);

echo "recherche - 2 chambre, pour 3 personnes, du 03/03/2023 au 05/03/2023 :\n";

foreach ($disponibilites as $chambre) {
	echo "Chambre disponible : $chambre\n";
}

echo "__________________________\n";

// exemple :
$disponibilites = Reservation::TrouverChambresDisponibles($chambres, new DateTime('2023-03-10'), new DateTime('2023-03-15'), 1, 3);

echo "recherche - 1 chambre, pour 3 personnes, du 10/03/2023 au 15/03/2023 :\n";

foreach ($disponibilites as $chambre) {
	echo "Chambre disponible : $chambre\n";
}

echo "__________________________\n";

// exemple :
$disponibilites = Reservation::TrouverChambresDisponibles($chambres, new DateTime('2023-03-01'), new DateTime('2023-03-02'), 2, 3);

echo "recherche - 2 chambre, pour 3 personnes, du 01/03/2023 au 02/03/2023 :\n";

foreach ($disponibilites as $chambre) {
	echo "Chambre disponible : $chambre\n";
}

echo "__________________________\n";

// exemple :
$disponibilites = Reservation::TrouverChambresDisponibles($chambres, new DateTime('2023-03-06'), new DateTime('2023-03-08'), 2, 3);

echo "recherche - 2 chambre, pour 3 personnes, du 06/03/2023 au 08/03/2023 :\n";

foreach ($disponibilites as $chambre) {
	echo "Chambre disponible : $chambre\n";
}

echo "__________________________\n";

// exemple :
$disponibilites = Reservation::TrouverChambresDisponibles($chambres, new DateTime('2023-03-01'), new DateTime('2023-03-02'), 2, 5);

echo "recherche - 2 chambre, pour 5 personnes, du 01/03/2023 au 02/03/2023 :\n";

foreach ($disponibilites as $chambre) {
	echo "Chambre disponible : $chambre\n";
}

echo "__________________________\n";

// exemple :
$disponibilites = Reservation::TrouverChambresDisponibles($chambres, new DateTime('2023-03-01'), new DateTime('2023-03-02'), 1, 5);

echo "recherche - 1 chambre, pour 5 personnes, du 01/03/2023 au 02/03/2023 :\n";

foreach ($disponibilites as $chambre) {
	echo "Chambre disponible : $chambre\n";
}
