# Projet 1 - PHP

**Installation du projet**

Prérequis :
- avoir Docker installer
- se positioner dans le dossier du projet : `php`

**Docker**

Lancer les commandes suivantes :
```bash
docker build -t tui-php .
docker run --name tui_php -it -dp 3000:3000 tui-php
docker exec tui_php php index.php
```

**Tester**

Lancer la commande suivante :
```bash
docker exec tui-php php index.php
```

Liste des chambres :
- Chambre 101, 2 personnes, disponible du 01/03/2023 au 05/03/2023
- Chambre 101, 2 personnes, disponible du 07/03/2023 au 10/03/2023
- Chambre 102, 2 personnes, disponible du 01/03/2023 au 10/03/2023
- Chambre 103, 3 personnes, disponible du 03/03/2023 au 08/03/2023
- Chambre 103, 3 personnes, disponible du 10/03/2023 au 15/03/2023
- Chambre 104, 4 personnes, disponible du 01/03/2023 au 15/03/2023

# Projet 2 - PHP/HTML

**Installation du projet**

Prérequis :
- avoir Docker installer et pouvoir utiliser la commande `docker-compose`
- se positioner dans le dossier du projet : `php-html`

**Docker**

Lancer les commandes suivantes :
```bash
docker-compose -f ./docker-compose.yml up -d --force-recreate --build
```

**Base de données**

Accéder au docker db :
```bash
docker exec -ti php-html_db_1 mysql -uroot -proot
```
Une fois dans le docker il faut lancer la requête de création de la base de données :
```bash
CREATE DATABASE `tui`;
```

Il faut insérer les données de tests :
```bash
docker exec -i php-html_db_1 mysql -uroot -proot tui < api/db.sql 
```

**API**

Accéder au docker de l'api :
```bash
docker exec -i php-html_api_1 bash
```

On lance composer :
```bash
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer | composer install
```

**Site**

Accéder au docker du site :
```bash
docker exec -i php-html_web_1 bash
```

On lance composer :
```bash
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer | composer install
```

**Tester**

Le lien pour accéder au projet : http://0.0.0.0:88/

La liste des vols disponibles :
- CDG vers BKK du 20/05/2023 au 25/05/2023
- CDG vers BKK du 20/05/2023 au 26/05/2023
- MAD vers CDG du 20/05/2023 au 28/05/2023
