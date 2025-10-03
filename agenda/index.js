class AgendaManager {
    constructor() {
        this.init();
    }

    init() {
        this.chargerVueListe();
        this.chargerProchainsEvenements();
    }

    async chargerVueListe() {
        try {
            const response = await fetch('ajax/lister.php');
            const data = await response.json();
            
            if (data.success) {
                this.afficherListeEvenements(data.evenements);
            } else {
                this.afficherErreur('Erreur lors du chargement des événements');
            }
        } catch (error) {
            console.error('Erreur:', error);
            this.afficherErreur('Erreur de connexion');
        }
    }

    async chargerProchainsEvenements() {
        try {
            const response = await fetch('ajax/prochains.php');
            const data = await response.json();
            
            if (data.success) {
                this.afficherProchainsEvenements(data.evenements);
            } else {
                document.getElementById('prochainsEvenements').innerHTML = '<p class="text-muted">Aucun événement à venir</p>';
            }
        } catch (error) {
            console.error('Erreur:', error);
            document.getElementById('prochainsEvenements').innerHTML = '<p class="text-danger">Erreur de chargement</p>';
        }
    }

    afficherListeEvenements(evenements) {
        const container = document.getElementById('listeEvenements');
        
        if (evenements.length === 0) {
            container.innerHTML = '<div class="alert alert-info">Aucun événement à venir</div>';
            return;
        }

        let html = '';
        evenements.forEach(evenement => {
            const typeBadge = evenement.type === 'organise' ? 'bg-primary' : 'bg-success';
            
            html += `
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="card-title">${evenement.titre}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <i class="fas fa-calendar"></i> ${evenement.dateFormatee}
                                    ${evenement.lieu ? `<br><i class="fas fa-map-marker-alt"></i> ${evenement.lieu}` : ''}
                                </h6>
                                <p class="card-text">${evenement.description}</p>
                            </div>
                            <span class="badge ${typeBadge}">${evenement.typeLibelle}</span>
                        </div>
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }

    afficherProchainsEvenements(evenements) {
        const container = document.getElementById('prochainsEvenements');
        
        if (evenements.length === 0) {
            container.innerHTML = '<p class="text-muted small">Aucun événement à venir</p>';
            return;
        }

        let html = '';
        evenements.forEach(evenement => {
            // Gérer le type d'événement (booléen)
            const typeLibelle = evenement.type === 'organise' ? 'Organisé par le club' : 'Participation du club';
            const badgeClass = evenement.type === 'organise' ? 'bg-primary' : 'bg-success';
            
            html += `
                <div class="mb-3 pb-2 border-bottom">
                    <h6 class="mb-1">${evenement.titre}</h6>
                    <small class="text-muted d-block">${evenement.dateFormatee}</small>
                    ${evenement.lieu ? `<small class="text-muted d-block"><i class="fas fa-map-marker-alt"></i> ${evenement.lieu}</small>` : ''}
                    <small class="badge ${badgeClass}">${typeLibelle}</small>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }

    afficherErreur(message) {
        const container = document.getElementById('listeEvenements');
        container.innerHTML = `<div class="alert alert-danger">${message}</div>`;
    }
}

// Initialisation quand le DOM est chargé
document.addEventListener('DOMContentLoaded', () => {
    new AgendaManager();
});