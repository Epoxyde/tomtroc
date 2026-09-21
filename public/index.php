<?php

require_once __DIR__ . '/../src/models/Database.php';

try {
    $database = new Database();
    $connection = $database->getConnection();

    echo 'Connexion à la base de données réussie.';
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
}