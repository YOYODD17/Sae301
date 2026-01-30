<?php
/**
 * définition de la classe Evenement
 */
class Evenement {
    // Propriétés
    private int $id_evenement;   
    private string $titre;
    private string $description;
    private string $type_evenement;
    private string $date_evenement;
    private string $lieu;
    private int $capacite_max;
    private int $id_intervenant;

    public function __construct(array $donnees) {
        if (isset($donnees['id_evenement']))   { $this->id_evenement = $donnees['id_evenement']; }
        if (isset($donnees['titre']))          { $this->titre = $donnees['titre']; }
        if (isset($donnees['description']))    { $this->description = $donnees['description']; }
        if (isset($donnees['type_evenement'])) { $this->type_evenement = $donnees['type_evenement']; }
        if (isset($donnees['date_evenement'])) { $this->date_evenement = $donnees['date_evenement']; }
        if (isset($donnees['lieu']))           { $this->lieu = $donnees['lieu']; }        
        if (isset($donnees['capacite_max']))   { $this->capacite_max = $donnees['capacite_max']; }
        if (isset($donnees['id_intervenant'])) { $this->id_intervenant = $donnees['id_intervenant']; }
    }           

    // --- GETTERS ---

    public function getIdEvenement(): int { return $this->id_evenement; }
    public function getTitre(): string { return $this->titre; }
    public function getDescription(): string { return $this->description; }
    public function getTypeEvenement(): string { return $this->type_evenement; }
    public function getDateEvenement(): string { return $this->date_evenement; }
    public function getLieu(): string { return $this->lieu; }
    public function getCapaciteMax(): int { return $this->capacite_max; }
    public function getIdIntervenant(): int { return $this->id_intervenant; }

    // --- SETTERS ---

    public function setIdEvenement(int $id_evenement): void { $this->id_evenement = $id_evenement; }
    public function setTitre(string $titre): void { $this->titre = $titre; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setTypeEvenement(string $type_evenement): void { $this->type_evenement = $type_evenement; }
    public function setDateEvenement(string $date_evenement): void { $this->date_evenement = $date_evenement; }
    public function setLieu(string $lieu): void { $this->lieu = $lieu; }
    public function setCapaciteMax(int $capacite_max): void { $this->capacite_max = $capacite_max; }
    public function setIdIntervenant(int $id_intervenant): void { $this->id_intervenant = $id_intervenant; }
}
?>