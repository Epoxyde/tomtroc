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

### Prérequis

- PHP 8.0 minimum (le projet a été testé avec PHP 8.2.6), avec les extensions `pdo_mysql`, `mbstring` et `fileinfo` activées.
- MySQL ou MariaDB avec prise en charge d'InnoDB et du jeu de caractères `utf8mb4`.
- Apache avec le module `mod_rewrite` activé et la prise en compte du fichier `public/.htaccess`.
- Git pour récupérer le projet.
- Node.js et npm uniquement pour modifier et recompiler les styles SCSS. Le fichier CSS compilé est déjà fourni.

### 1. Cloner le dépôt

```bash
git clone https://github.com/Epoxyde/tomtroc.git
cd tomtroc
```

### 2. Créer la base de données

Créer une base de données vide destinée à TomTroc, par exemple depuis phpMyAdmin :

```sql
CREATE DATABASE tomtroc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Sélectionner cette base, puis importer le fichier `tomtroc.sql`, situé à la racine du projet, avec l'onglet **Importer** de phpMyAdmin. Le fichier contient les tables, leurs relations et les données de démonstration, mais ne crée pas la base elle-même.

Utiliser une base vide : l'export contient des instructions `DROP TABLE` qui suppriment les tables du même nom si elles existent.

### 3. Configurer la connexion à la base de données

Copier le fichier :

```text
config/config.exemple.php
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
        'port' => '3306',
        'dbname' => 'tomtroc',
        'user' => '',
        'password' => '',
        'charset' => 'utf8mb4',
    ],
];
```

Le fichier `config/config.php` contient les identifiants locaux de connexion à la base de données et n'est donc pas versionné.

Adapter `port` au serveur utilisé : l'export fourni provient d'une instance MariaDB sur le port `3307`, tandis que le fichier d'exemple indique `3306`. Renseigner le nom de la base créée et les identifiants de son utilisateur.

### 4. Configurer le serveur web

Configurer le serveur web afin que la racine du site (`DocumentRoot`) pointe vers le dossier :

```text
public/
```

Par exemple, avec Apache sous WampServer (adapter les chemins si nécessaire) :

```apache
<VirtualHost *:80>
    ServerName tomtroc.local
    DocumentRoot "C:/wamp64/www/tomtroc/public"

    <Directory "C:/wamp64/www/tomtroc/public">
        DirectoryIndex index.php
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Ajouter également la ligne suivante au fichier `C:\Windows\System32\drivers\etc\hosts` avec les droits administrateur, si ce nom n'est pas déjà configuré :

```text
127.0.0.1 tomtroc.local
```

Activer `mod_rewrite`, charger la configuration du VirtualHost et redémarrer Apache. Le fichier `public/.htaccess` redirige les routes telles que `/books` et `/account` vers `public/index.php`.

Le site peut ensuite être ouvert à l'adresse configurée dans le VirtualHost, par exemple :

```text
http://tomtroc.local/
```

Utiliser cette adresse à la racine du site : les liens de l'application commencent par `/` et ne sont pas prévus pour une installation dans un sous-dossier d'URL.

### 5. Vérifier l'installation

- Ouvrir l'accueil et `/books`, puis rechercher un titre présent dans le catalogue.
- Se connecter avec un compte de démonstration et ouvrir « Mon compte ».
- Vérifier l'ajout et la modification d'un livre, puis l'envoi et la réception d'un message avec deux comptes.
- Ouvrir une adresse inexistante pour vérifier l'affichage de la page 404.

PHP doit pouvoir écrire dans `public/uploads/books/` et `public/uploads/avatars/`. Pour accepter les photos de livres jusqu'à 20 Mo, configurer `upload_max_filesize` à au moins `20M` et `post_max_size` à une valeur supérieure, par exemple `25M`, dans le `php.ini` utilisé par Apache, puis redémarrer Apache. Les avatars restent limités à 5 Mo par l'application.

## Base de données

Le projet utilise une base de données relationnelle MySQL
composée de trois tables :

- `users` : comptes et profils des utilisateurs ;
- `books` : livres proposés à l'échange ;
- `messages` : messages privés entre utilisateurs,
  avec suivi de leur lecture.

Les tables sont reliées par des clés étrangères.

Le fichier `tomtroc.sql`, situé à la racine du projet,
contient la structure et les données de démonstration.

## Comptes de démonstration

Trois comptes utilisateurs sont disponibles après l'import de la base de données :

| Utilisateur | E-mail | Mot de passe |
| --- | --- | --- |
| alexlecture | alexlecture@example.com | password |
| nathalire | nathalire@example.com | password |
| Sas634 | sas634@example.com | password |

Les mots de passe sont stockés sous forme de hachages
générés avec `password_hash()`.

## Styles

Les styles du projet sont écrits en SCSS dans le dossier :

```text
scss/
```

Ils sont compilés dans :

```text
public/css/main.css
```

Installer les dépendances avec :

```bash
npm install
```

Puis lancer Sass en mode surveillance :

```bash
npm run sass
```

Sass recompilera automatiquement les styles lors de chaque modification des fichiers SCSS.

## Gestion des images

Les photos des livres et les avatars sont stockés respectivement dans
`public/uploads/books/` et `public/uploads/avatars/`.

Pour faciliter l'installation et l'évaluation du projet, ces dossiers
sont actuellement versionnés dans Git, y compris les images de
démonstration et celles ajoutées pendant les tests.

Dans un environnement de production, les fichiers téléversés par les
utilisateurs devraient être conservés dans un stockage persistant,
indépendant du dépôt Git.

Des règles d'exclusion sont prévues à cet effet dans `.gitignore`.

## Versionnement

Le projet est versionné avec Git et hébergé sur GitHub.

Les différentes fonctionnalités sont ajoutées progressivement afin de conserver un historique clair de l'évolution du projet.

## Auteur

Vincent

Projet réalisé dans le cadre de la formation Développeur d'application Full-Stack d'OpenClassrooms.
