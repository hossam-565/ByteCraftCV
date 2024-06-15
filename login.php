<?php
// Démarrer la session
session_start();

// Vérifier si les données du formulaire ont été soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations du formulaire de connexion (nom d'utilisateur et mot de passe)
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $password = $_POST['password'];

    // Paramètres de connexion à la base de données
    $serveur = "localhost";
    $utilisateur_bd = "root";
    $mot_de_passe_bd = "";
    $nom_bd = "cv_info";

    // Connexion à la base de données
    $connexion_bd = new mysqli($serveur, $utilisateur_bd, $mot_de_passe_bd, $nom_bd);

    // Vérifier la connexion
    if ($connexion_bd->connect_error) {
        die("Échec de la connexion à la base de données : " . $connexion_bd->connect_error);
    }

    // Requête SQL pour vérifier les informations de connexion
    $requete = "SELECT contact_info.id_user, contact_info.nompre, connexion.password 
                FROM contact_info 
                INNER JOIN connexion ON contact_info.id_user = connexion.id_user 
                WHERE contact_info.nompre = ? AND connexion.password = ?";
    $statement = $connexion_bd->prepare($requete);
    $statement->bind_param("ss", $nom_utilisateur, $password);
    $statement->execute();
    $resultat = $statement->get_result();

    // Vérifier si un enregistrement correspondant a été trouvé
    if ($resultat->num_rows === 1) {
        // Authentification réussie, récupérer l'identifiant de l'utilisateur
        $row = $resultat->fetch_assoc();
        $id_utilisateur = $row['id_user'];

        // Définir la variable de session pour indiquer que l'utilisateur est connecté
        $_SESSION['utilisateur_connecte'] = true;
        $_SESSION['utilisateur_id'] = $id_utilisateur;

        // Requête SQL pour récupérer le thème associé à l'utilisateur
        $requete_theme = "SELECT id_user,theme FROM theme WHERE id_user = ?";
        $statement_theme = $connexion_bd->prepare($requete_theme);
        $statement_theme->bind_param("i", $id_utilisateur);
        $statement_theme->execute();
        $resultat_theme = $statement_theme->get_result();

        // Vérifier si un thème correspondant a été trouvé
        if ($resultat_theme->num_rows > 0) {
            // Récupérer le thème associé à l'utilisateur
            $row_theme = $resultat_theme->fetch_assoc();
            $theme_utilisateur = $row_theme['theme'];

           // Redirection en fonction du thème de l'utilisateur
             switch ($theme_utilisateur) {
                case 'Blackstox':
            // Rediriger vers la page CV_BlackStocks.php
                   header("Location: CV_blackstox.php");
                   exit;
                case 'Bluestar':
            // Rediriger vers la page CV_bluestar.php
                   header("Location: CV_bluestar.php");
                   exit;
                default:
            // Rediriger vers une page par défaut si le thème n'est pas reconnu
                    header("Location: page_par_defaut.php");
                    exit;
            }
        }
    } else {
        // Authentification échouée, afficher un message d'erreur
        $message_erreur = "Nom d'utilisateur ou mot de passe incorrect.";
    }

    // Fermer la connexion à la base de données
    $connexion_bd->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="Login.css"/>

</head>

<body>
<div class="animated-text">
    <p class="text" id="text1">Welcome</p>
    <p class="text" id="text2">To</p>
    <p class="text" id="text3">ByteCraftCV</p>
</div>
<img src="images/Logo.png" alt="Logo Picture">

<video autoplay muted loop id="backgroundVideo">
    <source src="formu.mp4" type="video/mp4">
    Votre navigateur ne prend pas en charge la balise vidéo.
</video>

<div class="container">
    <h2 style="text-align: center;">Login</h2>
    <?php if (isset($message_erreur)) { ?>
        <p><?php echo $message_erreur; ?></p>
    <?php } ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="new">Prénom et Nom:</label>
            <input type="text" id="new" name="nom_utilisateur" placeholder="Exm: Yassine Zefri" required>
        </div>
        <div class="form-group">
            <label for="newPassword">Password:</label>
            <input type="password" id="newPassword" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit">Connexion</button>
        </div>
    </form>
    <div class="form-group">
        <a href="theme.php">Do you not have an account? Sign Up</a>
    </div>
</div>

</body>
</html>
