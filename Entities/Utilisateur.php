<?php
class Utilisateur {
    private $_id_utilisateur;
    private $_prenom;
    private $_id_role;

    public function __construct($donnees) {
        $this->_id_utilisateur = $donnees['id_utilisateur'];
        $this->_prenom = $donnees['prenom'];
        $this->_id_role = $donnees['id_role'];
    }

    public function getId() { return $this->_id_utilisateur; }
    public function getPrenom() { return $this->_prenom; }
    public function getIdRole() { return $this->_id_role; }
}
?>