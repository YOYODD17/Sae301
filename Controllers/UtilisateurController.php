<?php
class UtilisateurController {
    private $userManager;

    public function __construct($bdd) {
        $this->userManager = new UtilisateurManager($bdd);
    }

    public function formLogin() {
        ?>
        <form method="post" action="index.php?action=valider_login" style="max-width:300px; margin:auto; padding:20px; border:1px solid #ccc;">
            <h3>Connexion</h3>
            <div class="mb-3">
                <label>Email :</label>
                <input type="text" name="email" class="form-control" required placeholder="admin@test.fr">
            </div>
            <div class="mb-3">
                <label>Mot de passe :</label>
                <input type="password" name="password" class="form-control" required placeholder="admin">
            </div>
            <input type="submit" value="Se connecter" class="btn btn-primary">
        </form>
        <?php
    }

    public function validerLogin() {
        $user = $this->userManager->verif_identification($_POST['email'], $_POST['password']);

        if ($user) {
            $_SESSION['user_prenom'] = $user->getPrenom();
            $_SESSION['user_role'] = $user->getIdRole(); // 1 = Admin, 2 = intervenant
            
            // Redirection vers l'accueil
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Erreur de connexion'); window.location.href='index.php?action=login';</script>";
        }
    }

    //Déconnexion
    public function logout() {
        session_destroy(); // On vide la session
        echo "<script>window.location.href='index.php';</script>";
    }
}
?>