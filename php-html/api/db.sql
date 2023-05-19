CREATE TABLE `tui`.`vols` (
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ville_depart CHAR(3) NOT NULL,
    ville_retour CHAR(3) NOT NULL,
    date_depart DATE NOT NULL,
    heure_depart VARCHAR(10) NOT NULL,
    date_retour DATE NOT NULL,
    heure_retour VARCHAR(10) NOT NULL,
    prix FLOAT NOT NULL,
    places_restante INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tui`.`vols` (`ville_depart`, `ville_retour`, `date_depart`, `heure_depart`, `date_retour`, `heure_retour`, `prix`, `places_restante`)
VALUES
('CDG', 'BKK', '2023-05-20', '13:25:00', '2023-05-25', '21:25:00', 300.00, 5),
('CDG', 'BKK', '2023-05-20', '15:25:00', '2023-05-25', '23:25:00', 150.00, 1),
('CDG', 'BKK', '2023-05-20', '20:25:00', '2023-05-26', '08:25:00', 200.00, 15),
('CDG', 'BKK', '2023-05-20', '11:25:00', '2023-05-25', '20:25:00', 350.00, 12),
('MAD', 'CDG', '2023-05-20', '13:25:00', '2023-05-28', '15:25:00', 200.00, 5),
('MAD', 'CDG', '2023-05-20', '11:25:00', '2023-05-28', '13:25:00', 150.00, 15),
('MAD', 'CDG', '2023-05-20', '18:25:00', '2023-05-28', '21:25:00', 300.00, 2),
('MAD', 'CDG', '2023-05-20', '22:25:00', '2023-05-28', '23:50:00', 175.00, 10);

CREATE TABLE `tui`.`reservations` (
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(255) NOT NULL,
    vols_id INTEGER NOT NULL,
    FOREIGN KEY (vols_id) REFERENCES vols (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;