"use strict";

// -----------------------------------------------------------------------------------
// Importation des fonctions nécessaires
// -----------------------------------------------------------------------------------

import {appelAjax} from "/composant/fonction/ajax.js";
import {configurerFormulaire, donneesValides, supprimerEspace} from "/composant/fonction/formulaire.js";
import {retournerVers} from "/composant/fonction/afficher.js";

// -----------------------------------------------------------------------------------
// Déclaration des variables globales
// -----------------------------------------------------------------------------------

// récupération des élements sur l'interface
const msg = document.getElementById('msg');
let titre = document.getElementById('titre');
let description = document.getElementById('description');
let dateDebut = document.getElementById('dateDebut');
let lieu = document.getElementById('lieu');
let type = document.getElementById('type');
let visible = document.getElementById('visible');
let btnAjouter = document.getElementById('btnAjouter');

// -----------------------------------------------------------------------------------
// Procédures évènementielles
// -----------------------------------------------------------------------------------

// traitement associé au bouton 'Ajouter'
btnAjouter.onclick = () => {
    // mise en forme des données
    titre.value = supprimerEspace(titre.value);
    description.value = supprimerEspace(description.value);
    if (lieu.value) {
        lieu.value = supprimerEspace(lieu.value);
    }
    
    // contrôle des champs de saisie
    if (donneesValides()) {
        ajouter();
    }
};

// -----------------------------------------------------------------------------------
// Fonctions de traitement
// -----------------------------------------------------------------------------------

/**
 * Contrôle des informations saisies et demande d'ajout côté serveur
 */
function ajouter() {
    msg.innerText = '';
    
    // Préparation des données
    const donnees = {
        table: 'evenement',
        titre: titre.value,
        description: description.value,
        dateDebut: dateDebut.value,
        type: type.value,
        visible: visible.value
    };
    
    // Ajouter le lieu s'il est renseigné
    if (lieu.value) {
        donnees.lieu = lieu.value;
    }
    
    appelAjax({
        url : '/ajax/ajouter.php',
        data : donnees,
        success : (response) => {
            retournerVers("Le nouvel événement a été ajouté", '.');
        }
    });
}

// -----------------------------------------------------------------------------------
// Programme principal
// -----------------------------------------------------------------------------------

// Focus sur le premier champ
titre.focus();

configurerFormulaire();