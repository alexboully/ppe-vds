<?php
declare(strict_types=1);

/**
 * Classe InputDateTime : contrôle une date et heure au format aaaa-mm-jj hh:mm:ss
 * @Author : Assistant
 * @Version : 1.0
 * @Date : 19/09/2025
 */

class InputDateTime extends Input
{
    // date et heure la plus petite acceptée
    public string $Min;

    // date et heure la plus grande acceptée
    public string $Max;

    /**
     * Redéfinition de la méthode checkValidity
     * @return bool
     */
    public function checkValidity(): bool
    {
        if (!parent::checkValidity()) {
            return false;
        }
        
        if ($this->Value !== null && $this->Value !== "") {
            // Accepter le format datetime-local: YYYY-MM-DDTHH:MM
            $correct = preg_match('`^([0-9]{4})-([0-9]{2})-([0-9]{2})T([0-9]{2}):([0-9]{2})$`', (string)$this->Value, $matches);
            
            if ($correct) {
                $annee = (int)$matches[1];
                $mois = (int)$matches[2];
                $jour = (int)$matches[3];
                $heure = (int)$matches[4];
                $minute = (int)$matches[5];
                
                // Vérifier la validité de la date
                $correct = checkdate($mois, $jour, $annee) && $annee > 1900;
                // Vérifier la validité de l'heure
                $correct = $correct && $heure >= 0 && $heure <= 23 && $minute >= 0 && $minute <= 59;
            }
            
            if (!$correct) {
                $this->validationMessage = "Format de date/heure invalide (attendu: YYYY-MM-DDTHH:MM)";
                return false;
            }
            
            // Convertir en format MySQL DATETIME pour la comparaison et le stockage
            $mysqlFormat = str_replace('T', ' ', $this->Value) . ':00';
            $this->Value = $mysqlFormat;
            
            if (isset($this->Min)) {
                $minMySQL = str_replace('T', ' ', $this->Min) . ':00';
                if ($this->Value < $minMySQL) {
                    $this->validationMessage = "La date/heure doit être égale ou postérieure à " . str_replace('T', ' à ', $this->Min);
                    return false;
                }
            }
            
            if (isset($this->Max)) {
                $maxMySQL = str_replace('T', ' ', $this->Max) . ':00';
                if ($this->Value > $maxMySQL) {
                    $this->validationMessage = "La date/heure doit être égale ou antérieure à " . str_replace('T', ' à ', $this->Max);
                    return false;
                }
            }
        }
        
        return true;
    }

    /**
     * Décode une date au format YYYY-MM-DDTHH:MM en français
     * @param string $date
     * @return string
     */
    public static function decoderDateTime(string $date): string
    {
        if (preg_match('`^([0-9]{4})-([0-9]{2})-([0-9]{2})T([0-9]{2}):([0-9]{2})$`', $date, $matches)) {
            return $matches[3] . '/' . $matches[2] . '/' . $matches[1] . ' à ' . $matches[4] . ':' . $matches[5];
        }
        return $date;
    }
}