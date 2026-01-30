<?php
class UtilisateurManager {
    private $_db; 

    public function __construct($db) {
        $this->_db = $db;
    } 

    public function verif_identification($email, $password) {
        $req = "SELECT id_membre as id_utilisateur, nom, prenom, email, mot_de_passe, id_grade as id_role 
        FROM Membre 
        WHERE email = :email AND mot_de_passe = :mdp";
        
        $stmt = $this->_db->prepare($req);
        $stmt->execute(array(
            ':email' => $email,
            ':mdp' => $password
        ));

        if ($data = $stmt->fetch()) { 
            return new Utilisateur($data);
        } else {
            return false;
        }
    }
}
?>