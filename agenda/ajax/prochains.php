<?php
// Ça sert à forcer PHP à être beaucoup plus strict sur les types de données que vous passez à une fonction, ce qui aide à éviter des erreurs inattendues.
declare(strict_types=1);

require_once '../../include/autoload.php';

header('Content-Type: application/json');

try {
    $nombre = (int)($_GET['nombre'] ?? 5);
    
    // Limiter le nombre d'événements
    if ($nombre < 1 || $nombre > 10) {
        $nombre = 5;
    }
    
    $evenements = Evenement::getProchainsEvenements($nombre);
    
    echo json_encode([
        'success' => true,
        'evenements' => $evenements
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors du chargement des prochains événements'
    ]);
}