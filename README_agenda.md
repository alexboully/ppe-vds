# 📅 Système d'Agenda pour l'Association VDS

## Description
Ce système permet à l'association de gérer et d'afficher les événements du club de course à pied. Il distingue deux types d'événements :
- **Événements organisés par le club** (sorties, formations, assemblée générale...)
- **Événements auxquels le club participe** (compétitions, événements extérieurs...)

## 🚀 Installation

### 1. Base de données
Exécutez les scripts SQL dans cet ordre :
```sql
-- 1. Créer la table des événements
.sql/evenement/create.sql

-- 2. Insérer des données d'exemple
.sql/evenement/insert.sql

-- 3. Configurer les droits d'administration
.sql/evenement/fonction.sql
```

### 2. Vérification
Exécutez le script de test :
```bash
php test_agenda.php
```

## 📱 Utilisation

### Interface Publique
- **URL** : `/agenda`
- **Vue Liste** : Affichage chronologique des événements à venir
- **Vue Calendrier** : Navigation mensuelle avec positionnement des événements
- **Responsive** : Adaptation automatique mobile/tablette/desktop

### Interface d'Administration
- **URL** : `/administration/evenement/`
- **Listing** : Tous les événements avec tri et recherche
- **Ajout** : Formulaire avec validation (pas d'événement dans le passé)
- **Gestion** : Visibilité, types d'événements, dates multiples

### Page d'Accueil
- Section **"Prochains Événements"** automatiquement mise à jour
- Lien direct vers l'agenda complet

## 🔧 Structure Technique

### Fichiers Principaux
```
agenda/
├── index.php          # Page principale agenda
├── index.html         # Interface utilisateur
├── index.js           # Logique JavaScript/AJAX
└── ajax/
    ├── lister.php     # API liste des événements
    ├── calendrier.php # API calendrier mensuel
    └── prochains.php  # API prochains événements

administration/evenement/
├── index.php          # Liste des événements (admin)
├── ajout.php          # Formulaire d'ajout
├── index.html         # Interface admin
└── ajout.html         # Interface ajout

classemetier/
└── evenement.php      # Classe métier avec méthodes CRUD

.sql/evenement/
├── create.sql         # Structure de la table
├── insert.sql         # Données d'exemple
└── fonction.sql       # Droits d'administration
```

### Base de Données
Table `evenement` :
- `id` : Identifiant unique
- `titre` : Nom de l'événement (100 caractères max)
- `description` : Description détaillée
- `dateDebut` : Date/heure de début (obligatoire)
- `dateFin` : Date/heure de fin (optionnelle)
- `lieu` : Localisation (200 caractères max)
- `type` : 'organise' ou 'participe'
- `visible` : Affichage public ou masqué
- `dateCreation` / `dateModification` : Suivi automatique

## 🎨 Fonctionnalités

### ✅ Côté Public
- [x] Agenda avec vue liste et calendrier
- [x] Navigation mensuelle fluide
- [x] Filtrage automatique (événements futurs uniquement)
- [x] Responsive design avec Bootstrap
- [x] Chargement AJAX sans rechargement
- [x] Intégration page d'accueil

### ✅ Côté Administration
- [x] Gestion complète CRUD
- [x] Validation des dates (pas dans le passé)
- [x] Contrôle d'accès sécurisé
- [x] Interface cohérente avec l'existant
- [x] Support événements multi-jours

### ✅ Technique
- [x] Architecture MVC respectée
- [x] Classe métier avec méthodes optimisées
- [x] Requêtes SQL avec index pour performance
- [x] Gestion d'erreurs robuste
- [x] Code documenté et maintenable

## 🔐 Sécurité
- Contrôle d'accès administrateur obligatoire
- Validation côté client ET serveur
- Protection contre injections SQL (PDO préparées)
- Échappement automatique des données affichées

## 📈 Évolutions Possibles
- [ ] Notifications par email des nouveaux événements
- [ ] Système d'inscription aux événements
- [ ] Export calendrier (iCal/Google Calendar)
- [ ] Gestion des photos d'événements
- [ ] Statistiques de participation

---
*Développé pour l'Association VDS - 2024*