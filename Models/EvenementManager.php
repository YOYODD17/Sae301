<?php
class EvenementManager {
    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    } 

    public function getList() {
        $eves = array();
        $req = 'SELECT id_evenement, titre, description, type_evenement, date_evenement, lieu, capacite_max, id_intervenant 
                FROM Evenement';
        $stmt = $this->_db->prepare($req);
        $stmt->execute();
        
        while ($donnees = $stmt->fetch()) {
            $eves[] = new Evenement($donnees);
        }
        return $eves;
    }

    public function getEvenementById($id) {
        $req = "SELECT * FROM Evenement WHERE id_evenement = :id";
        $stmt = $this->_db->prepare($req);
        $stmt->execute([':id' => $id]);
        
        $donnees = $stmt->fetch();
        
        if (!$donnees) return null;
        
        return new Evenement($donnees);
    }

    public function update(Evenement $eve) : bool {
        $sql = "UPDATE Evenement 
                SET titre = :titre, 
                    description = :description, 
                    type_evenement = :type_evenement, 
                    date_evenement = :date_evenement, 
                    lieu = :lieu, 
                    capacite_max = :capacite_max 
                WHERE id_evenement = :id_evenement";

        $stmt = $this->_db->prepare($sql);
        return $stmt->execute([
            ":titre"          => $eve->getTitre(),
            ":description"    => $eve->getDescription(),
            ":type_evenement" => $eve->getTypeEvenement(),
            ":date_evenement" => $eve->getDateEvenement(),
            ":lieu"           => $eve->getLieu(),
            ":capacite_max"   => $eve->getCapaciteMax(),
            ":id_evenement"   => $eve->getIdEvenement()
        ]);
    }

    public function delete(Evenement $eve) : bool {
        $req = "DELETE FROM Evenement WHERE id_evenement = ?";
        $stmt = $this->_db->prepare($req);
        return $stmt->execute(array($eve->getIdEvenement()));
    }

    public function add(Evenement $eve): bool {
        $stmt = $this->_db->prepare("SELECT max(id_evenement) AS maximum FROM Evenement");
        $stmt->execute();
        $nouvelId = $stmt->fetchColumn() + 1;
        $eve->setIdEvenement($nouvelId);
        
        $req = "INSERT INTO Evenement (id_evenement, titre, description, type_evenement, date_evenement, lieu, capacite_max, id_intervenant) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->_db->prepare($req);
        
        return $stmt->execute(array(
            $eve->getIdEvenement(),
            $eve->getTitre(),
            $eve->getDescription(),
            $eve->getTypeEvenement(),
            $eve->getDateEvenement(),
            $eve->getLieu(),
            $eve->getCapaciteMax(),
            $eve->getIdIntervenant()
        ));       
    }

    public function recherche($mot) : array {
        $eves = array();
        $recherche = "%" . $mot . "%"; 
    
        $req = "SELECT id_evenement, titre, description, type_evenement, date_evenement, lieu, capacite_max, id_intervenant 
                FROM Evenement 
                WHERE titre LIKE :m 
                OR description LIKE :m 
                OR lieu LIKE :m
                OR type_evenement LIKE :m";
    
        $stmt = $this->_db->prepare($req);
        $stmt->execute([':m' => $recherche]);
    
        while ($donnees = $stmt->fetch()) {
            $eves[] = new Evenement($donnees);
        }
        return $eves;
    }
}
?>