use ppe;

-- Ajout de la fonction Événement pour l'administration
insert into fonction (repertoire, nom) values ('evenement', 'Gérer les événements');

-- Attribution des droits pour tous les administrateurs existants
insert into droit (idAdministrateur, repertoire)
select idAdministrateur, 'evenement' from droit where repertoire = 'membre';