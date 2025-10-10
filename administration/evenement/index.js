"use strict";

// -----------------------------------------------------------------------------------
// Import des fonctions nécessaires
// -----------------------------------------------------------------------------------
import {activerTri } from "/composant/fonction/tableau.js";
import {appelAjax} from "/composant/fonction/ajax.js";

// -----------------------------------------------------------------------------------
// Déclaration des variables globales
// -----------------------------------------------------------------------------------

/* global data */
const lesLignes = document.getElementById('lesLignes');
const menuSupprimer = document.getElementById('menuSupprimer');
const modalConfirmation = new bootstrap.Modal(document.getElementById('modalConfirmation'));
const evenementASupprimer = document.getElementById('evenementASupprimer');
const btnConfirmerSuppression = document.getElementById('btnConfirmerSuppression');

let idEvenementASupprimer = null;

// -----------------------------------------------------------------------------------
// Procédures évènementielles
// -----------------------------------------------------------------------------------

// Gestion du bouton de confirmation de suppression
btnConfirmerSuppression.onclick = () => {
    if (idEvenementASupprimer) {
        supprimerEvenement(idEvenementASupprimer);
        modalConfirmation.hide();
    }
};

// -----------------------------------------------------------------------------------
// Fonctions de traitement
// -----------------------------------------------------------------------------------

function afficher() {
    lesLignes.innerHTML = ''; // Effacer les lignes existantes
    
    // Vider et reconstruire le menu dropdown
    menuSupprimer.innerHTML = `
        <li><h6 class="dropdown-header">Choisir l'événement à supprimer</h6></li>
        <li><hr class="dropdown-divider"></li>
    `;
    
    for (const evenement of data) {
        // Ajouter ligne au tableau
        let tr = lesLignes.insertRow();
        tr.insertCell().innerText = evenement.titre;
        
        // Cellule date avec attribut data pour le tri
        let cellDate = tr.insertCell();
        cellDate.innerText = evenement.dateDebut;
        cellDate.setAttribute('data-sort', evenement.dateDebutTri);
        
        tr.insertCell().innerText = evenement.lieu;
        tr.insertCell().innerText = evenement.type;
        tr.insertCell().innerText = evenement.visible;
        
        // Description tronquée pour l'affichage
        let cellDescription = tr.insertCell();
        cellDescription.className = 'description-cell';
        if (evenement.description.length > 100) {
            cellDescription.innerText = evenement.description.substring(0, 100) + '...';
            cellDescription.title = evenement.description; // Affichage complet au survol
        } else {
            cellDescription.innerText = evenement.description;
        }
        
        // Ajouter item au menu dropdown de suppression
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.className = 'dropdown-item';
        a.href = '#';
        a.textContent = `${evenement.titre} (${evenement.dateDebut})`;
        a.onclick = (e) => {
            e.preventDefault();
            ouvrirModalSuppression(evenement.id, evenement.titre, evenement.dateDebut);
        };
        li.appendChild(a);
        menuSupprimer.appendChild(li);
    }
}

/**
 * Ouvrir la modal de confirmation de suppression
 * @param {string} id - ID de l'événement
 * @param {string} titre - Titre de l'événement
 * @param {string} date - Date de l'événement
 */
function ouvrirModalSuppression(id, titre, date) {
    idEvenementASupprimer = id;
    evenementASupprimer.textContent = `${titre} (${date})`;
    modalConfirmation.show();
}

/**
 * Supprimer un événement
 * @param {string} id - ID de l'événement à supprimer
 */
function supprimerEvenement(id) {
    appelAjax({
        url: '/ajax/supprimer.php',
        data: {
            table: 'evenement',
            id: id
        },
        success: (response) => {
            // Recharger la page pour mettre à jour les données
            window.location.reload();
        },
        error: (error) => {
            alert('Erreur lors de la suppression : ' + error);
        }
    });
}

// -----------------------------------------------------------------------------------
// Programme principal
// -----------------------------------------------------------------------------------
activerTri({
    idTable: "leTableau",
    getData: () => data,
    afficher: afficher,
    triInitial: {
        colonne: "dateDebut",
        sens: "desc"
    }
});

afficher();