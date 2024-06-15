<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>formulaire CV</title>
 <link rel="stylesheet" href="black_formulaire.css"/>
</head>
<body>

<video autoplay muted loop id="backgroundVideo">
    <source src="blackcv.mp4" type="video/mp4">
    Votre navigateur ne prend pas en charge la balise vidéo.
</video>
<div class="container">
      <header>Remplir Vos Informations </header>
      <div class="progress-bar">
        <div class="step">
          <p>Profile</p>
          <div class="bullet">
            <span>1</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Informations personnelles</p>
          <div class="bullet">
            <span>2</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Formation(s)</p>
          <div class="bullet">
            <span>3</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Compétances</p>
          <div class="bullet">
            <span>4</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Language</p>
          <div class="bullet">
            <span>5</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Auto-formation</p>
          <div class="bullet">
            <span>6</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
      </div>
      <!-- Formulaires -->
      <div class="form-outer">
      "Veuillez remplir les champs obligatoires marqués d'un astérisque (*) avant de valider le formulaire."    
      <form  action="stockerDB_black.php" method="post" enctype="multipart/form-data">
<!-- ------------------------------------------------------- -->

          <div class="page slide-page">
            <div class="title"><h5>Sélectionnez une photo: (*)</h5></div>
            <div class="profil">
              <input  type="file" name="image" id="profil-pic" accept="image/*" required >
            </div>
            
            <div class="field">
              <button class="firstNext next">Suivant</button>
            </div>
          </div>
<!-- ------------------------------------------------------- -->

          <div class="page">
            <div class="title"><h5>Contact Info:</h5></div>
            <div class="field">
              <div class="label"><h4>Prenom et Nom:(*)</h4></div><br>
              <input type="text" name="nompre" id="nom"  placeholder="prenom et nom" required >
            </div>
            <div class="field">
              <div class="label"><h4>Spécialisation:</h4></div>
              <input type="text" name="specia" id="sp"   >
            </div>
            <div class="field">
              <div class="label"><h4>About you :</h4></div>
              <textarea name="aboutmee" id="ab" rows="10" cols="80"></textarea>
            </div>
            <div class="field">
              <div class="label"><h4>Téléphone:(*)</h4></div>
              <input type="tel" name="numeroTelephone"   placeholder="060000000" id="numeroTelephone" required >
            </div>
            <div class="field">
              <div class="label"><h4>Email:(*)</h4></div>
              <input type="email" name="email" id="email" placeholder="email@gmail.com"  required  >
            </div>
            <div class="field">
              <div class="label"><h4>Adresse:</h4></div>
              <input type="text" name="adresse"   id="adr" >
            </div>
            <div class="field btns">
              <button class="prev-1 prev">Précédent</button>
              <button class="next-1 next">Suivant</button>
            </div>
          </div>
<!-- ------------------------------------------------------- -->
          <div class="page">
            
            <div class="formationField">
              <div class="label">Diplôme obtenu (ou en cour):(*)</div>
              <input name="formation[]" required ><br><br>
              <div class="label">École ou université :(*)</div>
              <input type="text"   name="ecole[]" required ><br><br>
              <button class="ajouter"><i class="gg-add"></i></button>

            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

             <script>
          $(document).ready(function() {
            var maxChamps = 4; // Maximum de champs autorisés
            var champsAjoutes = 1; // Initialisation du compteur

            // Ajoute un événement pour gérer l'ajout de champs dynamiquement
            $(document).on('click', '.ajouter', function() {
                if (champsAjoutes < maxChamps) {
                    ajouter($(this).closest('.formationField'));
                    champsAjoutes++;
                } else {
                    alert("Vous avez atteint le nombre maximal de champs.");
                }
            });

            // Fonction pour ajouter un nouveau champ de formation et d'école
            function ajouter(container) {
                var nouveauChamp = $('<div class="formationField">' +
                                        '<div class="label">Diplôme obtenu (ou en cours):(*)</div>' +
                                        '<input type="text" name="formation[]" required ><br><br>' +
                                        '<div class="label">École ou université :(*)</div>' +
                                        '<input type="text" name="ecole[]" required ><br><br>' +
                                        '<button class="supprimerChamp">Supprimer</button>' +
                                    '</div>');
                nouveauChamp.find('.supprimerChamp').click(function() {
                    $(this).parent().remove();
                    champsAjoutes--;
                });
                container.after(nouveauChamp);
            }
        });
             </script>
            <div class="field btns">
              <button class="prev-2 prev">Précédent</button>
              <button class="next-2 next">Suivant</button>
            </div>
          </div>
<!-- ------------------------------------------------------- -->

          <div class="page">
            
          <div class="fieldcomp">
    <label for="categorie">Catégorie :(*)</label>
    <select name="categorie[]" class="categorie" required>
        <option value="">Choisir une catégorie</option>
        <option value="programmation">Programmation</option>
        <option value="logicielle">Logicielle</option>
        <option value="bureautique">Bureautique</option>
    </select>
    <div class="competences-container">
        <!-- Contenu dynamique pour les compétences -->
    </div>
    <button class="ajoutercomp" ><i class="gg-add"></i> Ajouter compétence</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var maxChamps = 18; // Maximum de champs autorisés

        // Ajoute un événement pour gérer l'ajout de champs dynamiquement
        $(document).on('click', '.ajoutercomp', function() {
            if ($('.fieldcomp').length < maxChamps) {
              ajoutercomp($(this).closest('.fieldcomp'));
            } else {
                alert("Vous avez atteint le nombre maximal de champs.");
            }
        });

        // Ajoute un événement pour supprimer un champ de compétence
        $(document).on('click', '.supprimer', function() {
            $(this).closest('.fieldcomp').remove();
        });

        // Fonction pour ajouter un nouveau champ de formation et d'école
        function ajoutercomp(container) {
            var nouveauChamp = $('<div class="fieldcomp">' +
                                    '<label for="categorie">Catégorie :</label>' +
                                    '<select name="categorie[]" class="categorie"  required>' +
                                        '<option value="">Choisir une catégorie</option>'+
                                        '<option value="programmation">Programmation</option>' +
                                        '<option value="logicielle">Logicielle</option>' +
                                        '<option value="bureautique">Bureautique</option>' +
                                    '</select>' +
                                    '<div class="competences-container">' +
                                        '<!-- Contenu dynamique pour les compétences -->' +
                                    '</div>' +
                                    '<button class="ajoutercomp" required><i class="gg-add"></i> ajouter compétence</button>' +
                                    '<button class="supprimer"><i class="gg-trash"></i> Supprimer</button>' +
                                '</div>');
            container.after(nouveauChamp);
        }

        // Ajoute un événement pour mettre à jour les compétences en fonction de la catégorie sélectionnée
        $(document).on('change', '.categorie', function() {
            var categorie = $(this).val();
            var competencesDiv = $(this).closest('.fieldcomp').find('.competences-container');
            competencesDiv.html(""); // Efface le contenu précédent

            if (categorie === 'programmation') {
                competencesDiv.html("<label for='competences_prog'>Compétences en Programmation :(*)</label>" +
                                    "<input type='text' name='competences[]'  required >");
            } else if (categorie === 'logicielle') {
                competencesDiv.html("<label for='competences_log'>Compétences Logicielles :(*)</label>" +
                                    "<input type='text' name='competences[]' required  >");
            } else if (categorie === 'bureautique') {
                competencesDiv.html("<label for='competences_buro'>Compétences Bureautiques :(*)</label>" +
                                    "<input type='text' name='competences[]' required >");
            }
        });
    });
</script>
            <div class="field btns">
              <button class="prev-3 prev">Précédent</button>
              <button class="next-3 next">Suivant</button>
            </div>
          </div>
<!--  ------------------------------------------- -->

 <div class="page"> 

  <div class="fieldlang">
  <div class="langue">
        <label for="nomlang1">Nom du langage :(*)</label>
        <input type="text" name="nomlang1" class="nomlang" placeholder="arabe, français..." required >
        <label for="niv1">Niveau de maîtrise :(*)</label>
        <select name="niveau1" class="niv" required>
            <option value="">Choisir le niveau</option>
            <option value="Débutant">Débutant</option>
            <option value="Niveau professionnel moyen">Niveau professionnel moyen</option>
            <option value="Langue maternelle">Langue maternelle</option>
        </select>
        <br><br>
    </div>
  </div>
  <button class="ajouterLangue"><i class="gg-add"></i> Ajouter langue</button>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var maxLangues = 4; // Maximum de langues autorisées
        var languesAjoutees = 1; // Initialisation du compteur

        // Ajoute un événement pour gérer l'ajout de langues dynamiquement
        $(document).on('click', '.ajouterLangue', function() {
            if (languesAjoutees < maxLangues) {
                ajouterLangue();
                languesAjoutees++;
            } else {
                alert("Vous avez atteint le nombre maximal de langues.");
            }
        });

        // Ajoute un événement pour supprimer une langue
        $(document).on('click', '.supprimerLangue', function() {
            $(this).closest('.langue').remove();
            languesAjoutees--;
        });

        // Fonction pour ajouter une nouvelle langue
        function ajouterLangue() {
            var nouvelleLangue = $('<div class="langue">' +
                                        '<label for="nomlang' + (languesAjoutees + 1) + '">Nom du langage :(*)</label>' +
                                        '<input type="text" name="nomlang' + (languesAjoutees + 1) + '" class="nomlang" placeholder="arabe, français..." required >' +
                                        '<label for="niv' + (languesAjoutees + 1) + '">Niveau de maîtrise :(*)</label>' +
                                        '<select name="niveau' + (languesAjoutees + 1) + '" class="niv" required>' +
                                            ' <option value="">Choisir le niveau</option>'+
                                            '<option value="Débutant">Débutant</option>' +
                                            '<option value="Niveau professionnel moyen">Niveau professionnel moyen</option>' +
                                            '<option value="Langue maternelle">Langue maternelle</option>' +
                                        '</select>' +
                                        '<br><br>' +
                                        '<button class="supprimerLangue">Supprimer langue</button>' +
                                    '</div>');
            $('.fieldlang').append(nouvelleLangue);
        }
    });
</script>
  <div class="field btns">
    <button class="prev-4 prev">Précédent</button>
    <button class="next-4 next">Suivant</button>
  </div>
</div>



<div class="page">
  <div class="title">Si vous avez suivi une autoformation certifiée, veuillez saisir le nom de la formation ainsi que la plateforme ou l'université qui l'offre </b></div>
  <div class="autoformationField">
              <input name="certificat[]" placeholder="Nom de course 'Python for everbody ,CCNA....' (*) " required  ><br><br>
              <input type="text"   name="plate[]" placeholder="Nom d'universite ou plateforme 'coursera, cisco, udemy...'  (*)"  required ><br><br>
              <button class="ajouterChampp"><i class="gg-add"></i></button>

            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

             <script>
          $(document).ready(function() {
            var maxChamps = 6; // Maximum de champs autorisés
            var champsAjoutes = 1; // Initialisation du compteur

            // Ajoute un événement pour gérer l'ajout de champs dynamiquement
            $(document).on('click', '.ajouterChampp', function() {
                if (champsAjoutes < maxChamps) {
                    ajouter($(this).closest('.autoformationField'));
                    champsAjoutes++;
                } else {
                    alert("Vous avez atteint le nombre maximal de champs.");
                }
            });

            // Fonction pour ajouter un nouveau champ de formation et d'école
            function ajouter(container) {
                var nouveauChamp = $('<div class="autoformationField">' +
                                        '<input type="text" name="certificat[]"   placeholder="Nom de course Python for everbody ,CCNA....  (*) " required ><br><br>' +
                                        '<input type="text" name="plate[]" placeholder="Nom universite ou plateforme coursera, cisco, udemy...  (*)"   required ><br><br>' +
                                        '<button class="supprimerChamp">Supprimer</button>' +
                                    '</div>');
                nouveauChamp.find('.supprimerChamp').click(function() {
                    $(this).parent().remove();
                    champsAjoutes--;
                });
                container.after(nouveauChamp);
            }
        });
             </script>
  <div class="field btns">
    <button class="prev-5 prev">Précédent</button>
    <button class="submit"  name="valider">Valider</button>

  </div>
</div> 
        </form>
      </div>
    </div>
    <script src="Bar_progress.js"></script>
 
</body>
</html>