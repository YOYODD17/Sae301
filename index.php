<?php
    session_start(); 

    include "connect.php"; 

    require_once "Entities/Evenement.php";
    require_once "Models/EvenementManager.php";
    require_once "Controllers/EvenementController.php";

    require_once "Entities/Utilisateur.php";
    require_once "Models/UtilisateurManager.php";
    require_once "Controllers/UtilisateurController.php";

$userController = new UtilisateurController($bdd);

    if (!isset($bdd)) {
        die("Erreur critique : La variable \$bdd n'existe pas.");
    }

    $controller = new EvenementController($bdd);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon du livre</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        .main-container { 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            margin-top: 30px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Salon du livre</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="index.php?action=liste">Liste des événements</a>
        </li>

        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) { ?>
            
            <li class="nav-item ms-lg-3">
                <a class="nav-link text-warning" href="index.php?action=form_ajout">Ajouter</a>
            </li>
            
            <li class="nav-item ms-lg-3">
                <a class="nav-link text-warning" href="index.php?action=choix_modif">Modifier</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-warning" href="index.php?action=afficher_suppression">Supprimer</a>                    
            </li>

        <?php } ?>

        <?php if (isset($_SESSION['user_prenom'])) { ?>
            <li class="nav-item ms-3 d-flex align-items-center">
                <span class="text-white me-2">Bonjour <?php echo $_SESSION['user_prenom']; ?></span>
                <a href="index.php?action=logout" class="btn btn-danger btn-sm">Déconnexion</a>
            </li>

        <?php } else { ?>
            <li class="nav-item ms-3">
                <a href="index.php?action=login" class="btn btn-light btn-sm">Connexion</a>
            </li>
        <?php } ?>

    </ul>
</div>
        </div>
    </nav>

    <div class="container">
        <div class="main-container">
            <?php
            $action = isset($_GET['action']) ? $_GET['action'] : 'liste';

            switch ($action) {
                case 'liste':
                    $controller->listeEvenement();
                    break;

                case 'form_ajout':
                    $controller->formAjoutEvenement();
                    break;

                case 'traiter_ajout':
                    $controller->ajoutEvenement();
                    break;

                case 'afficher_suppression':
                    $controller->choixSuppEvenement();
                    break;

                case 'supprimer':
                    $controller->suppEvenement();
                    break;
                
                case 'choix_modif':
                    $controller->choixModifEvenement();
                    break;

                case 'form_modif':
                    $controller->formModifEvenement();
                    break;

                case 'traiter_modif':
                    $controller->traiterModifEvenement();
                    break;

                case 'login':
                    $userController->formLogin();
                    break;

                case 'valider_login':
                    $userController->validerLogin();
                    break;

                case 'logout':
                    $userController->logout();
                    break;

                default:
                    echo "<div class='alert alert-danger'>Erreur 404 : Action inconnue</div>";
                    break;
            }
            ?>
        </div>
    </div>

    <footer class="text-center py-4 text-muted">
        <small>&copy; <?php echo date('Y'); ?> - Gestion des Événements</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>