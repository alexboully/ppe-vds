<?php
declare(strict_types=1);

// définition de la table evenement : id, titre, description, dateDebut, dateFin, lieu, type, visible, dateCreation, dateModification

class Evenement extends Table
{

    public function __construct()
    {
        parent::__construct('evenement');

        // seules les colonnes pouvant être modifiées par l'administrateur sont définies

        // titre
        $input = new inputText();
        $input->Require = true;
        $input->SupprimerEspaceSuperflu = true;
        $input->MaxLength = 100;
        $this->columns['titre'] = $input;

        // description
        $input = new inputTextarea();
        $input->Require = true;
        $input->SupprimerEspaceSuperflu = true;
        $this->columns['description'] = $input;

        // date de l'événement (obligatoire)
        $input = new InputDate();
        $input->Require = true;
        $input->Min = date("Y-m-d");
        $this->columns['dateDebut'] = $input;

        // lieu
        $input = new inputText();
        $input->Require = false;
        $input->SupprimerEspaceSuperflu = true;
        $input->MaxLength = 200;
        $this->columns['lieu'] = $input;

        // type d'événement
        $input = new inputList();
        $input->Require = true;
        $input->Options = [
            'organise' => 'Organisé par le club',
            'participe' => 'Participation du club'
        ];
        $this->columns['type'] = $input;

        // visibilité
        $input = new inputList();
        $input->Require = true;
        $input->Options = [
            '1' => 'Visible',
            '0' => 'Masqué'
        ];
        $this->columns['visible'] = $input;
    }

    // ------------------------------------------------------------------------------------------------
    // Méthodes statiques relatives aux opérations de consultation
    // ------------------------------------------------------------------------------------------------

    /**
     * Récupère tous les événements pour l'administration
     * @return array
     */
    public static function getAll(): array
    {
        $sql = <<<SQL
            SELECT id, titre, description, 
                   DATE_FORMAT(dateDebut, '%d/%m/%Y') as dateDebut,
                   dateDebut as dateDebutTri,
                   IFNULL(lieu, 'Non précisé') as lieu,
                   CASE type
                       WHEN 'organise' THEN 'Organisé par le club'
                       WHEN 'participe' THEN 'Participation du club'
                   END as type,
                   CASE visible
                       WHEN 1 THEN 'Visible'
                       WHEN 0 THEN 'Masqué'
                   END as visible
            FROM evenement
            ORDER BY dateDebut DESC;
SQL;
        $select = new Select();
        return $select->getRows($sql);
    }

    /**
     * Récupère les événements visibles pour affichage public
     * @param int $limite Nombre d'événements à récupérer (0 = tous)
     * @return array
     */
    public static function getEvenementsPublics(int $limite = 0): array
    {
        $limitSql = $limite > 0 ? "LIMIT $limite" : "";
        
        $sql = <<<SQL
            SELECT id, titre, description, 
                   dateDebut, lieu, type,
                   DATE_FORMAT(dateDebut, '%d/%m/%Y') as dateFormatee,
                   CASE type
                       WHEN 'organise' THEN 'Organisé par le club'
                       WHEN 'participe' THEN 'Participation du club'
                   END as typeLibelle
            FROM evenement
            WHERE visible = 1 AND dateDebut >= CURDATE()
            ORDER BY dateDebut ASC
            $limitSql;
SQL;
        $select = new Select();
        return $select->getRows($sql);
    }

    /**
     * Récupère les événements pour un mois donné (pour vue calendrier)
     * @param int $annee
     * @param int $mois
     * @return array
     */
    public static function getEvenementsMois(int $annee, int $mois): array
    {
        $sql = <<<SQL
            SELECT id, titre, description, 
                   dateDebut, dateFin, lieu, type,
                   DAY(dateDebut) as jour,
                   DATE_FORMAT(dateDebut, '%H:%i') as heureDebut,
                   CASE type
                       WHEN 'organise' THEN 'Organisé par le club'
                       WHEN 'participe' THEN 'Participation du club'
                   END as typeLibelle
            FROM evenement
            WHERE visible = 1 
              AND YEAR(dateDebut) = :annee 
              AND MONTH(dateDebut) = :mois
            ORDER BY dateDebut ASC;
SQL;
        $select = new Select();
        return $select->getRows($sql, ['annee' => $annee, 'mois' => $mois]);
    }

    /**
     * Récupère les prochains événements (pour affichage en page d'accueil)
     * @param int $nombre Nombre d'événements à récupérer
     * @return array
     */
    public static function getProchainsEvenements(int $nombre = 3): array
    {
        $sql = <<<SQL
            SELECT titre, 
                   DATE_FORMAT(dateDebut, '%d/%m/%Y') as dateFormatee,
                   lieu,
                   type
            FROM evenement
            WHERE visible = 1 AND dateDebut >= CURDATE()
            ORDER BY dateDebut ASC
            LIMIT :nombre;
SQL;
        $select = new Select();
        return $select->getRows($sql, ['nombre' => $nombre]);
    }

    /**
     * Récupère le dernier événement passé
     * @return array|false
     */
    public static function getDernierEvenement(): array|false
    {
        $sql = <<<SQL
            SELECT titre, 
                   DATE_FORMAT(dateDebut, '%d/%m/%Y') as dateFormatee,
                   lieu,
                   type
            FROM evenement
            WHERE visible = 1 AND dateDebut < CURDATE()
            ORDER BY dateDebut DESC
            LIMIT 1;
SQL;
        $select = new Select();
        return $select->getRow($sql);
    }

    /**
     * Récupère un événement par son ID
     * @param int $id
     * @return array|false
     */
    public static function getById(int $id): array|false
    {
        $sql = <<<SQL
            SELECT id, titre, description, dateDebut, dateFin, lieu, type, visible
            FROM evenement
            WHERE id = :id;
SQL;
        $select = new Select();
        return $select->getRow($sql, ['id' => $id]);
    }

    /**
     * Compte le nombre d'événements visibles à venir
     * @return int
     */
    public static function compterEvenementsAVenir(): int
    {
        $sql = "SELECT COUNT(*) as nb FROM evenement WHERE visible = 1 AND dateDebut >= CURDATE()";
        $select = new Select();
        $result = $select->getRow($sql);
        return $result ? (int)$result['nb'] : 0;
    }
}