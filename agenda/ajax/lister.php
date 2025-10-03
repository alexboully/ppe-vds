<?php
declare(strict_types=1);

require_once '../../include/autoload.php';

header('Content-Type: application/json');

try {
    $evenements = Evenement::getEvenementsPublics();
    
    echo json_encode([
        'success' => true,
        'evenements' => $evenements
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors du chargement des événements'
    ]);
}