<?php
declare(strict_types=1);

require_once '../../include/autoload.php';

// Contrôle de l'accès : il faut être connecté et être un administrateur
if (!isset($_SESSION['membre']) || !Administrateur::estUnAdministrateur($_SESSION['membre']['id'])) {
    Erreur::afficherReponse("Vous devez être administrateur pour accéder à cette page", 'global');
}

// Vérification des droits spécifiques pour la gestion des événements
if (!Administrateur::peutAdministrer($_SESSION['membre']['id'], 'evenement')) {
    Erreur::afficherReponse("Vous n'avez pas les droits pour gérer les événements", 'global');
}

// Récupération des données
$lesEvenements = Evenement::getAll();

// Préparation des variables pour la vue
$titre = 'Gestion des événements';

// Variable JavaScript pour les données
$dataJson = json_encode($lesEvenements, JSON_UNESCAPED_UNICODE);
$head = <<<HTML
<script>
    const data = $dataJson;
</script>
HTML;

// Inclusion du template d'administration
include '../../include/interface.php';