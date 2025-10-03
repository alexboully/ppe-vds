<?php
declare(strict_types=1);

require_once '../../include/autoload.php';

header('Content-Type: application/json');

try {
    $annee = (int)($_GET['annee'] ?? date('Y'));
    $mois = (int)($_GET['mois'] ?? date('n'));
    
    // Validation des paramètres
    if ($annee < 2020 || $annee > 2030) {
        throw new InvalidArgumentException('Année invalide');
    }
    
    if ($mois < 1 || $mois > 12) {
        throw new InvalidArgumentException('Mois invalide');
    }
    
    $evenements = Evenement::getEvenementsMois($annee, $mois);
    
    echo json_encode([
        'success' => true,
        'evenements' => $evenements,
        'annee' => $annee,
        'mois' => $mois
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors du chargement du calendrier'
    ]);
}