<?php

class EvenementController {
    
    private $eveManager;

    public function __construct($bdd) {
        $this->eveManager = new EvenementManager($bdd);
    }

    public function listeEvenement() {
        // 1. Logique de récupération
        if (isset($_GET['Mget']) && !empty($_GET['Mget'])) {
            // On nettoie l'entrée utilisateur
            $motCle = htmlspecialchars($_GET['Mget']);
            $evenements = $this->eveManager->recherche($motCle);
        } else {
            $evenements = $this->eveManager->getList();
        }

        //get
        echo '<form action="index.php" method="GET" class="mb-3">
                <input type="hidden" name="action" value="liste">
                
                <div class="input-group" style="max-width: 400px;">
                    <input name="Mget" type="text" class="form-control" 
                        value="'. (isset($_GET['Mget']) ? htmlspecialchars($_GET['Mget']) : '') .'"
                        placeholder="Rechercher (Titre, Lieu, Type...)">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>';

        //tb liste
        echo '<table class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Titre</th><th>Description</th><th>Type</th><th>Date</th><th>Lieu</th><th>Capacité</th>
                    </tr>
                </thead>
                <tbody>';
        
        // Vérification si tableau vide
        if (empty($evenements)) {
            echo '<tr><td colspan="6" class="text-center bg-light text-muted p-3">Aucun événement ne correspond à votre recherche.</td></tr>';
        } else {
            foreach($evenements as $eve) {
                echo '<tr>
                        <td>' . $eve->getTitre() . '</td>
                        <td>' . $eve->getDescription() . '</td>
                        <td>' . $eve->getTypeEvenement() . '</td>
                        <td>' . $eve->getDateEvenement() . '</td>
                        <td>' . $eve->getLieu() . '</td>
                        <td>' . $eve->getCapaciteMax() . '</td>
                    </tr>'; 
            }
        }
        echo '</tbody></table>';
    }


    public function choixSuppEvenement() {
        $listeEvenements = $this->eveManager->getList(); 

?>
        <form method="post" action="index.php?action=supprimer" class="well">
            <fieldset>
                <legend>Choix de l'Evenement à supprimer</legend>
                
                <select name="id_evenement" class="form-control form-control-sm">
<?php
                    foreach($listeEvenements as $eve) {
                        echo '<option value="'.$eve->getIdEvenement().'">' . $eve->getTitre() . ' (' . $eve->getDateEvenement() . ')</option>';
                    }
?>
                </select>
                
                <input type="submit" name="valider_supp" value="Valider la suppression" class="btn btn-danger mt-2" />
            </fieldset>
        </form>
<?php
    }

    
    public function suppEvenement() {
		$eve = new Evenement($_POST);
		$ok = $this->eveManager->delete($eve);
		if ($ok) echo "itineraire supprimé" ;
		else echo "probleme lors de la supression";
	}

    public function formAjoutEvenement() {
?>
        <form method="post" action="index.php?action=traiter_ajout" class="well">
            <fieldset class="form-group">
                <legend>Nouvel Événement</legend>

                <div class="form-group row">
                    <label for="titre" class="col-sm-2 col-form-label col-form-label-sm">Titre</label>
                    <div class="col-sm-10">
                        <input type="text" id="titre" class="form-control form-control-sm" name="titre" required placeholder="Titre de l'événement" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label col-form-label-sm">Description</label>
                    <div class="col-sm-10">
                        <textarea id="description" class="form-control form-control-sm" name="description" placeholder="Description de l'événement"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="type_evenement" class="col-sm-2 col-form-label col-form-label-sm">Type</label>
                    <div class="col-sm-10">
                        <input type="text" id="type_evenement" class="form-control form-control-sm" name="type_evenement" required placeholder="Ex: Conférence, Atelier..." />
                    </div>
                </div>      

                <div class="form-group row">
                    <label for="date_evenement" class="col-sm-2 col-form-label col-form-label-sm">Date</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" id="date_evenement" class="form-control form-control-sm" name="date_evenement" required />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lieu" class="col-sm-2 col-form-label col-form-label-sm">Lieu</label>
                    <div class="col-sm-10">
                        <input type="text" id="lieu" class="form-control form-control-sm" name="lieu" required placeholder="Salle ou endroit" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="capacite_max" class="col-sm-2 col-form-label col-form-label-sm">Capacité</label>
                    <div class="col-sm-10">
                        <input type="number" min="0" id="capacite_max" class="form-control form-control-sm" name="capacite_max" required placeholder="Nombre de places maximum"/>
                    </div>
                </div>

                <input type="hidden" id="id_intervenant" name="id_intervenant" value="1"/>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <input type="submit" class="btn btn-primary" name="valider_ajout" value="Valider l'ajout"/>
                    </div>
                </div>

            </fieldset>
        </form>
<?php
    }

    public function ajoutEvenement() {
        $eve = new Evenement($_POST);
        
        $ok = $this->eveManager->add($eve);
        
        if ($ok) {
            echo "<script>alert('Événement ajouté !'); window.location.href='index.php?action=liste';</script>";
        } else {
            echo "Problème lors de l'ajout";
        }
    }
    

    public function choixModifEvenement() {
        $liste = $this->eveManager->getList(); 
        ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="post" action="index.php?action=form_modif" class="card p-4 shadow-sm">
                    <h3 class="mb-3">Modifier un événement</h3>
                    <div class="mb-3">
                        <label class="form-label">Sélectionnez l'événement à modifier :</label>
                        <select name="id_evenement" class="form-select">
                            <?php foreach($liste as $eve): ?>
                                <option value="<?= $eve->getIdEvenement() ?>">
                                    <?= $eve->getTitre() ?> (<?= $eve->getDateEvenement() ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Aller à la modification</button>
                </form>
            </div>
        </div>
        <?php
    }

    public function formModifEvenement() {
        $id = null;
        if (isset($_POST['id_evenement'])) {
            $id = $_POST['id_evenement'];
        } 

        if (!$id) {
            echo "<div class='alert alert-danger'>Erreur : Aucun événement sélectionné.</div>";
            return;
        }

        $eve = $this->eveManager->getEvenementById($id);

        $dateHtml = str_replace(" ", "T", $eve->getDateEvenement());
        ?>
        
        <form method="post" action="index.php?action=traiter_modif" class="well">
            <fieldset class="form-group border p-3 rounded">
                <legend class="w-auto px-2">Modifier : <?= $eve->getTitre() ?></legend>

                <input type="hidden" name="id_evenement" value="<?= $eve->getIdEvenement() ?>">
                <input type="hidden" name="id_intervenant" value="<?= $eve->getIdIntervenant() ?>">

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Titre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="titre" required 
                               value="<?= $eve->getTitre() ?>" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="description"><?= $eve->getDescription() ?></textarea>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="type_evenement" required 
                               value="<?= $eve->getTypeEvenement() ?>" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Date</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" name="date_evenement" required 
                               value="<?= $dateHtml ?>" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Lieu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="lieu" required 
                               value="<?= $eve->getLieu() ?>" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Capacité</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="capacite_max" required 
                               value="<?= $eve->getCapaciteMax() ?>" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-10 offset-sm-2">
                        <input type="submit" class="btn btn-warning" name="valider_modif" value="Enregistrer les modifications"/>
                    </div>
                </div>

            </fieldset>
        </form>
        <?php
    }

    public function traiterModifEvenement() {
        if(isset($_POST['date_evenement'])) {
            $_POST['date_evenement'] = str_replace('T', ' ', $_POST['date_evenement']);
        }

        $eve = new Evenement($_POST);
        
        $ok = $this->eveManager->update($eve);
        
        if ($ok) {
            echo "<script>alert('Événement modifié avec succès !'); window.location.href='index.php?action=liste';</script>";
        } else {
            echo "<div class='alert alert-danger'>Échec de la modification.</div>";
        }
    }

}
?>