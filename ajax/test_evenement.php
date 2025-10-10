<?php
declare(strict_types=1);

// Désactiver l'affichage des warnings
error_reporting(E_ERROR | E_PARSE);

require $_SERVER['DOCUMENT_ROOT'] . '/include/autoload.php';

header('Content-Type: application/json; charset=utf-8');

// Log des données reçues pour debug
$logData = [
    'POST' => $_POST,
    'timestamp' => date('Y-m-d H:i:s')
];
file_put_contents('debug_evenement.log', json_encode($logData, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);

try {
    // Vérification si 'table' est transmise
    if (!isset($_POST['table']) || $_POST['table'] !== 'evenement') {
        throw new Exception("Table invalide");
    }

    // Test direct de création d'événement
    $evenement = new Evenement();
    
    // Test des données une par une
    $testResults = [];
    
    if (isset($_POST['titre'])) {
        $evenement->columns['titre']->Value = $_POST['titre'];
        $testResults['titre'] = $evenement->columns['titre']->checkValidity();
        if (!$testResults['titre']) {
            $testResults['titre_error'] = $evenement->columns['titre']->validationMessage;
        }
    }
    
    if (isset($_POST['type'])) {
        $evenement->columns['type']->Value = $_POST['type'];
        $testResults['type'] = $evenement->columns['type']->checkValidity();
        if (!$testResults['type']) {
            $testResults['type_error'] = $evenement->columns['type']->validationMessage;
        }
        $testResults['type_value'] = $_POST['type'];
        $testResults['type_options'] = $evenement->columns['type']->Options;
    }
    
    if (isset($_POST['visible'])) {
        $evenement->columns['visible']->Value = $_POST['visible'];
        $testResults['visible'] = $evenement->columns['visible']->checkValidity();
        if (!$testResults['visible']) {
            $testResults['visible_error'] = $evenement->columns['visible']->validationMessage;
        }
        $testResults['visible_value'] = $_POST['visible'];
        $testResults['visible_options'] = $evenement->columns['visible']->Options;
    }
    
    echo json_encode([
        'success' => true,
        'tests' => $testResults,
        'post_data' => $_POST
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        'error' => $e->getMessage(),
        'post_data' => $_POST
    ], JSON_UNESCAPED_UNICODE);
}
?>