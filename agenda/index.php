<?php
declare(strict_types=1);

require_once '../include/autoload.php';

// Vérification de l'existence de la classe
if (!class_exists('Evenement')) {
    http_response_code(500);
    exit('Classe Evenement non trouvée');
}

// Page d'agenda des événements
$titre = 'Agenda des Événements';

// Chargement du contenu de la page
ob_start();
include 'index.html';
$contenu = ob_get_clean();

// Inclusion du template principal
include '../include/interface.php';