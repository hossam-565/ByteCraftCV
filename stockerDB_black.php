<?php
// Démarrez la session
session_start();

// Paramètres de connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "cv_info";

// Connexion à la base de données
$mysqli = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("Échec de la connexion à la base de données : " . $mysqli->connect_error);
}

// echo "Connexion à la base de données réussie !";

// Traitement des données du premier formulaire
if (isset($_POST['nompre'], $_POST['specia'], $_POST['aboutmee'], $_POST['numeroTelephone'], $_POST['email'], $_POST['adresse'])) {
    $nompre = $_POST['nompre'];
    $specia = $_POST['specia'];
    $aboutme = $_POST['aboutmee'];
    $telephone = $_POST['numeroTelephone'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];

    // Préparer la requête d'insertion
    $query = "INSERT INTO contact_info (nompre, specia, aboutmee, numeroTelephone, adresse, email) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssss", $nompre, $specia, $aboutme, $telephone, $adresse, $email);

    // Exécuter la requête
    if (!$stmt->execute()) {
        die("Erreur lors de l'insertion des informations du CV : " . $mysqli->error);
    }

    // Récupérer l'ID de l'utilisateur inséré
    $utilisateur_id = $mysqli->insert_id;
    $_SESSION['utilisateur_id'] = $utilisateur_id;

    $stmt->close();
}



$selectedTheme = 'Blackstox';
$utilisateur_id = $_SESSION['utilisateur_id'];

// Enregistrez le thème choisi dans la base de données
$query = "INSERT INTO theme (id_user, theme) VALUES (?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("is", $utilisateur_id, $selectedTheme);

if (!$stmt->execute()) {
die("Erreur lors de l'enregistrement du thème choisi : " . $mysqli->error);
}

$stmt->close();

// Traitement des données du deuxième formulaire (téléversement de l'image)
if(isset($_POST["valider"])) {
    try {
        // Préparation de la requête SQL pour l'insertion des données d'image
        $sql = "INSERT INTO images (id_user, nom, taille, type, bin) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        
        // Liaison des paramètres
        $stmt->bind_param("isiss", $_SESSION['utilisateur_id'], $nom, $taille, $type, $bin);
        
        // Récupération des données de l'image
        $nom = $_FILES["image"]["name"];
        $taille = $_FILES["image"]["size"];
        $type = $_FILES["image"]["type"];
        $bin = file_get_contents($_FILES["image"]["tmp_name"]);

        // Exécution de la requête
        if ($stmt->execute() === TRUE) {
            // echo "L'image a été téléversée avec succès.";
        } else {
            echo "Erreur lors de l'insertion de l'image : " . $mysqli->error;
        }

        // Fermer la requête
        $stmt->close();
    } catch(Exception $e) {
        echo "Erreur lors de l'insertion de l'image : " . $e->getMessage();
    }
}

// Traitement des données de la deuxième partie du formulaire
if (isset($_POST['formation'], $_POST['ecole'])) {
    $formations = $_POST['formation'];
    $ecoles = $_POST['ecole'];
    $utilisateur_id = $_SESSION['utilisateur_id'];
    // Préparer la requête d'insertion
    $query = "INSERT INTO formation (id_user,diplome, ecole) VALUES (?,?, ?)";
    $stmt = $mysqli->prepare($query);

    // Boucle à travers les données et les insérer dans la base de données
    for ($i = 0; $i < count($formations); $i++) {
        $formation = $formations[$i];
        $ecole = $ecoles[$i];

        $stmt->bind_param("iss",$utilisateur_id, $formation, $ecole);
        // Exécuter la requête
        $stmt->execute();
    }
    $stmt->close();
}

// Traitement des données de la troisième partie du formulaire
if (isset($_POST['categorie'], $_POST['competences'])) {
    $categories = $_POST['categorie'];
    $competences = $_POST['competences'];
    $utilisateur_id = $_SESSION['utilisateur_id'];
    // Préparer la requête d'insertion
    $query = "INSERT INTO competence (id_user,categorie, competence) VALUES (?,?, ?)";
    $stmt = $mysqli->prepare($query);

    // Boucle à travers les données et les insérer dans la base de données
    for ($i = 0; $i < count($categories); $i++) {
        $categorie = $categories[$i];
        $competence = $competences[$i];

        $stmt->bind_param("iss",$utilisateur_id, $categorie, $competence);
        // Exécuter la requête
        $stmt->execute();
    }
    $stmt->close();
}

// Traitement des données de la quatrième partie du formulaire
if (isset($_POST['nomlang1'], $_POST['niveau1'])) {
    $langues = array();
    $utilisateur_id = $_SESSION['utilisateur_id'];

    // Boucle à travers les données de langue et les insérer dans un tableau
    for ($i = 1; $i <= 3; $i++) {
        if (isset($_POST['nomlang'.$i], $_POST['niveau'.$i])) {
            $nomlang = $_POST['nomlang'.$i];
            $niveau = $_POST['niveau'.$i];
            $langues[] = array('nomlang' => $nomlang, 'niveau' => $niveau);
        }
    }

    // Préparer la requête d'insertion
    $query = "INSERT INTO langue (id_user,langue, niveau) VALUES (?,?, ?)";
    $stmt = $mysqli->prepare($query);

    // Insérer les données de langue dans la base de données
    foreach ($langues as $langue) {
        $nomlang = $langue['nomlang'];
        $niveau = $langue['niveau'];

        $stmt->bind_param("iss",$utilisateur_id, $nomlang, $niveau);
        // Exécuter la requête
        $stmt->execute();
    }
    $stmt->close();
}

// Traitement des données de la cinquième partie du formulaire (auto-formation)
if (isset($_POST['certificat'], $_POST['plate'])) {
    $certificats = $_POST['certificat'];
    $plates = $_POST['plate'];

    // Préparer la requête d'insertion
    $query = "INSERT INTO autoformation (id_user,certificat, plateforme) VALUES (?,?, ?)";
    $stmt = $mysqli->prepare($query);

    // Boucle à travers les données et les insérer dans la base de données
    for ($i = 0; $i < count($certificats); $i++) {
        $certificat = $certificats[$i];
        $plate = $plates[$i];

        $stmt->bind_param("iss",$utilisateur_id, $certificat, $plate);
        // Exécuter la requête
        $stmt->execute();
    }
    $stmt->close();
}


// Traitement des données de la password
if (isset($_POST['password'])) {
    $pass = $_POST['password'];
   
    $utilisateur_id = $_SESSION['utilisateur_id'];
    // Préparer la requête d'insertion
    $query = "INSERT INTO connexion (id_user, password) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("is",$utilisateur_id, $pass);
        // Exécuter la requête
    $stmt->execute();
    $stmt->close();
}

// Fermer la connexion à la base de données
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Confirmation Page</title>
 <link rel="stylesheet" href="Getcv.css"/>
</head>

<body>
<video autoplay muted loop id="backgroundVideo">
    <source src="blackcv.mp4" type="video/mp4">
    Votre navigateur ne prend pas en charge la balise vidéo.
</video>
<div class="container">
    <h2>Votre CV a bien été ajouté !</h2>
    <form id="cvForm" action="" method="post">
        <input type="password" id="newPassword" name="password" placeholder="Veuillez entrez votre mot de passe" required oninput="activerEnregistrer();">
        <div class="form-group">
            <button type="submit" id="saveButton" disabled onclick="event.preventDefault(); enregistrerCV();">Enregistrer</button>
        </div>
    </form>

    <button type="button" id="getcv" name="Envoyer" disabled onclick="soumettreFormulaire();">Obtenir CV</button>
</div>

<script>
    // Fonction pour activer le bouton "Enregistrer" si la case de mot de passe est remplie
    function activerEnregistrer() {
        var passwordInput = document.getElementById('newPassword');
        var enregistrerButton = document.getElementById('saveButton');

        if (passwordInput.value !== '') {
            enregistrerButton.disabled = false;
        } else {
            enregistrerButton.disabled = true;
        }
    }

    // Fonction appelée lors du clic sur le bouton "Enregistrer"
    function enregistrerCV() {
        var obtenirCVButton = document.getElementById('getcv');
        obtenirCVButton.disabled = false;
    }

    // Fonction appelée lors du clic sur le bouton "Obtenir CV"
    function soumettreFormulaire() {
        document.getElementById('cvForm').submit();
        window.open("CV_blackstox.php");
    }

</script>
</body>
</html>

