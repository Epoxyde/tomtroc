# TomTroc

TomTroc est une plateforme de mise en relation entre particuliers permettant de partager et d'échanger des livres.

Ce projet est réalisé dans le cadre de la formation **Développeur d'application Full-Stack** d'OpenClassrooms.

## Objectif du projet

L'objectif est de développer une première version fonctionnelle de la plateforme TomTroc en respectant une architecture **MVC (Modèle-Vue-Contrôleur)** et les principes de la **programmation orientée objet** en PHP.

La plateforme permettra notamment aux utilisateurs de :

- créer un compte et se connecter ;
- gérer leur profil ;
- ajouter et gérer les livres de leur bibliothèque ;
- consulter les livres proposés par les autres utilisateurs ;
- rechercher un livre ;
- consulter le profil d'un autre utilisateur ;
- envoyer et recevoir des messages.

## Technologies utilisées

- PHP
- MySQL
- HTML5
- SCSS / CSS
- Git
- GitHub

Le projet est développé sans framework PHP ni librairie PHP tierce.

## Architecture

Le projet utilise une architecture MVC (Modèle-Vue-Contrôleur) et la programmation orientée objet.

Les principales parties du projet sont organisées dans les dossiers suivants :

- `src/controllers/` : contrôleurs de l'application ;
- `src/models/` : entités et gestion de l'accès aux données ;
- `src/views/` : vues de l'application ;
- `public/` : racine publique de l'application et ressources accessibles depuis le navigateur ;
- `scss/` : fichiers sources des styles ;
- `config/` : configuration de l'application.

Le fichier `public/index.php` constitue le point d'entrée de l'application. Le serveur web doit donc être configuré pour utiliser le dossier `public/` comme racine du site.

## Installation

### 1. Cloner le dépôt

```bash
git clone git@github.com:Epoxyde/tomtroc.git
cd tomtroc
```

### 2. Créer la base de données

Créer une base de données MySQL destinée à TomTroc.

Importer ensuite le fichier `tomtroc.sql`, situé à la racine du projet, afin de créer les tables et les données nécessaires au fonctionnement de l'application.

### 3. Configurer la connexion à la base de données

Copier le fichier :

```text
config/config.example.php
```

et le renommer :

```text
config/config.php
```

Renseigner ensuite dans ce fichier les paramètres correspondant à votre environnement local :

```php
<?php

return [
    'db' => [
        'host' => 'localhost',
        'dbname' => '',
        'user' => '',
        'password' => '',
        'charset' => 'utf8mb4',
    ],
];
```

Le fichier `config/config.php` contient les identifiants locaux de connexion à la base de données et n'est donc pas versionné.

### 4. Configurer le serveur web

Configurer le serveur web afin que la racine du site (`DocumentRoot`) pointe vers le dossier :

```text
public/
```

Par exemple, avec Apache :

```apache
<VirtualHost *:80>
    ServerName tomtroc.local
    DocumentRoot "/chemin/vers/tomtroc/public"

    <Directory "/chemin/vers/tomtroc/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Le site peut ensuite être ouvert à l'adresse configurée dans le VirtualHost, par exemple :

```text
http://tomtroc.local/
```

## Base de données

Le projet utilise une base de données relationnelle MySQL.

La structure de la base de données sera documentée ici au fur et à mesure du développement.

## Styles

Les styles du projet sont écrits en SCSS dans le dossier :

```text
scss/
```

Ils sont compilés dans :

```text
public/css/main.css
```

Les instructions de compilation seront précisées lorsque l'environnement Sass du projet sera mis en place.

## Versionnement

Le projet est versionné avec Git et hébergé sur GitHub.

Les différentes fonctionnalités sont ajoutées progressivement afin de conserver un historique clair de l'évolution du projet.

## Auteur

Vincent

Projet réalisé dans le cadre de la formation Développeur d'application Full-Stack d'OpenClassrooms.