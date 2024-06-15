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

// Définir l'ID utilisateur à partir de la session
$utilisateur_id = $_SESSION['utilisateur_id'];

// Initialiser les tableaux pour stocker les données
$contact_info = array();
$images = array();
$formation = array();
$competence = array();
$langue = array();
$autoformation = array();

// Récupérer les informations de contact
$query_contact_info = "SELECT * FROM contact_info WHERE id_user = ?";
$stmt_contact_info = $mysqli->prepare($query_contact_info);
$stmt_contact_info->bind_param("i", $utilisateur_id);
$stmt_contact_info->execute();
$result_contact_info = $stmt_contact_info->get_result();
$contact_info = $result_contact_info->fetch_assoc();

// Récupérer les données de l'image depuis la base de données
$query = "SELECT bin, type FROM images WHERE id_user = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $utilisateur_id);
$stmt->execute();
$stmt->bind_result($imageData, $imageType);
$stmt->fetch();
$stmt->close();

// Créer une URL de données à partir des données binaires de l'image
$imageDataURL = 'data:' . $imageType . ';base64,' . base64_encode($imageData);



// Récupérer les informations de formation
$query_formation = "SELECT * FROM formation WHERE id_user = ?";
$stmt_formation = $mysqli->prepare($query_formation);
$stmt_formation->bind_param("i", $utilisateur_id);
$stmt_formation->execute();
$result_formation = $stmt_formation->get_result();
while ($row = $result_formation->fetch_assoc()) {
    $formation[] = $row;
}

// Récupérer les compétences
$query_competence = "SELECT * FROM competence WHERE id_user = ?";
$stmt_competence = $mysqli->prepare($query_competence);
$stmt_competence->bind_param("i", $utilisateur_id);
$stmt_competence->execute();
$result_competence = $stmt_competence->get_result();
while ($row = $result_competence->fetch_assoc()) {
    $competence[] = $row;
}

// Récupérer les langues
$query_langue = "SELECT * FROM langue WHERE id_user = ?";
$stmt_langue = $mysqli->prepare($query_langue);
$stmt_langue->bind_param("i", $utilisateur_id);
$stmt_langue->execute();
$result_langue = $stmt_langue->get_result();
while ($row = $result_langue->fetch_assoc()) {
    $langue[] = $row;
}

// Récupérer les auto-formations
$query_autoformation = "SELECT * FROM autoformation WHERE id_user = ?";
$stmt_autoformation = $mysqli->prepare($query_autoformation);
$stmt_autoformation->bind_param("i", $utilisateur_id);
$stmt_autoformation->execute();
$result_autoformation = $stmt_autoformation->get_result();
while ($row = $result_autoformation->fetch_assoc()) {
    $autoformation[] = $row;
}

// Fermer les requêtes préparées
$stmt_contact_info->close();
// $stmt->close();
$stmt_formation->close();
$stmt_competence->close();
$stmt_langue->close();
$stmt_autoformation->close();

// Fermer la connexion à la base de données
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title> CV</title>
 <link rel="stylesheet" href="Cv_blackstox.css"/>
</head>
<body>
<!-- <video autoplay muted loop id="backgroundVideo">
    <source src="bluecvv.mp4" type="video/mp4">
    Votre navigateur ne prend pas en charge la balise vidéo.
</video> -->


 <div  class="container">
  <!-- Profile -->
  
  <h1 class="nom"> <?php echo $contact_info['nompre']; ?></h1>
  <h3 class="fil"><?php echo $contact_info['specia']; ?></h3>
  <p class="about">About me</p>
  <p class="me"><?php echo $contact_info['aboutmee']; ?></p>



  <!-- ---------------------------------------------------------------------------? -->

  <h2 class="formation"> FORMATION </h2>
  <div class="forma">

 <ul class="a">
      <?php foreach ($formation as $formation_item): ?>

       <li>
         <dl>
           <dt style="font-family: 'Marker Felt'; font-size: 26px; font-style: oblique;"><?php echo $formation_item['diplome']; ?> </dt>
           <dd ><?php echo $formation_item['ecole']; ?></dd>
         </dl>
      </li>
    <?php endforeach; ?>
</ul>
<br>  
  

  </div>
<!-- ---------------------------------------------------------------------------? -->

 
  <h2 class="auto_formation"> AUTO-FORMATION </h2>

  <div class="auto">
    <ul>  
      <?php foreach ($autoformation as $autoformation_item): ?>
        <li>
          <dl>
            <dt class="ato" ><?php echo $autoformation_item['certificat']; ?></dt> 
            <dd class="pla"  ><?php echo $autoformation_item['plateforme']; ?></dd>
          </dl>
          </li>
      <?php endforeach; ?>
    </ul>
         <br>
   </div>

<div class="inner-rectangle">

  <img  class="profile-picture"  src="<?php echo $imageDataURL; ?>" alt="Image utilisateur">
<!-- ---------------------------------------------------------------------------? -->

    <div class="Contact_info">
        <h2 class="Contact_info">Contact Information</h2>
        <p><?php echo $contact_info['adresse']; ?></p>
        <p class="phone"> <b>Phone:</b> <?php echo $contact_info['numeroTelephone']; ?></p>
        <p class="email"><b>Email:</b> <a href="mailto:<?php echo $contact_info['email']; ?>" ><?php echo $contact_info['email']; ?></a></p>
        <div class="phone-icon">
          <span>&#128222;</span> <!-- Utilisation de l'entité unicode pour l'icône du téléphone portable -->
        </div>
  
        <div class="map-icon">
          <span>&#127968;</span> <!-- Utilisation de l'entité unicode pour l'icône de la position sur la carte -->
        </div>
  
        <div class="email-icon">
          <span>&#9993;</span> <!-- Utilisation de l'entité unicode pour l'icône de l'adresse e-mail -->
        </div>
    </div>

<!-- ---------------------------------------------------------------------------? -->

    <div class="competance">
      <h2 class="competance">COMPÉTENCES</h2>
        <table class="table">
          <tr>
            <th> <p class="p">Programmation</p></th>
            <td>
            <ul>
            <?php foreach ($competence as $competence_item): ?>
                <?php if ($competence_item['categorie'] == 'programmation'): ?>
                    <li>
                        <?php echo $competence_item['competence']; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
            </td>
          </tr>
          <tr>
            <th> <p class="l">Logiciels</p></th>
            <td>
            <ul>
            <?php foreach ($competence as $competence_item): ?>
                <?php if ($competence_item['categorie'] == 'logicielle'): ?>
                    <li>
                        <?php echo $competence_item['competence']; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
            </td>
          </tr>
          <tr>
            <th> <p class="b">Bureautique</p> </th>
            <td>
            <ul>
            <?php foreach ($competence as $competence_item): ?>
                <?php if ($competence_item['categorie'] == 'bureautique'): ?>
                    <li>
                        <?php echo $competence_item['competence']; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
            </ul>
          </td>
          </tr>
        </table>
    </div>
<!-- ---------------------------------------------------------------------------? -->
  <div class="langue">
    <h2 class="langue">Language</h2>
    <ul>
      <?php foreach($langue as $langue_item) :?>
        <li> 
            <dt class="lang"><?php echo $langue_item['langue']; ?></dt> <br>   
            <dd class="translate"><?php echo $langue_item['niveau']; ?></dd><br>
      </li>
        <?php endforeach ?>
    </ul>
  <div>
  </div>
  </div>
  </div>
 </div>


</body>
</html>
