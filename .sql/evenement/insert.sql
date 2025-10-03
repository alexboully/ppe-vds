use ppe;

-- Insertion de quelques événements d'exemple

insert into evenement (titre, description, dateDebut, dateFin, lieu, type, visible) values
('Championnat Régional VTT', 'Participation du club au championnat régional de VTT cross-country. Plusieurs membres du club sont inscrits dans différentes catégories.', '2024-10-15 09:00:00', '2024-10-15 18:00:00', 'Forêt de Compiègne', 'participe', true),

('Sortie VTT Découverte', 'Sortie organisée par le club pour découvrir les sentiers de la vallée de l''Oise. Niveau débutant/intermédiaire. Prêt de matériel possible.', '2024-10-22 14:00:00', '2024-10-22 17:00:00', 'Départ parking de la Mairie', 'organise', true),

('Assemblée Générale 2024', 'Assemblée générale annuelle du club. Présentation du bilan de l''année, élection du bureau, projets pour l''année suivante.', '2024-11-05 19:00:00', '2024-11-05 21:00:00', 'Salle des fêtes municipale', 'organise', true),

('Formation Mécanique VTT', 'Atelier de formation aux réparations de base du VTT : changement de chambre à air, réglage des freins, entretien de la chaîne.', '2024-11-12 10:00:00', '2024-11-12 16:00:00', 'Local du club', 'organise', true),

('Rando VTT Hivernale', 'Randonnée VTT adaptée à la saison hivernale. Parcours de 25km en forêt avec pause restauration chaude.', '2024-12-01 13:30:00', '2024-12-01 17:00:00', 'Base de loisirs', 'organise', true),

('Téléthon 2024', 'Participation du club à l''événement Téléthon de la ville avec organisation d''une randonnée solidaire. Reversement des inscriptions au Téléthon.', '2024-12-07 14:00:00', '2024-12-07 17:30:00', 'Centre-ville', 'participe', true);