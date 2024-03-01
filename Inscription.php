<?php
session_start();
if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur'] !== null) {
  session_destroy();
  session_start();
}
$erreurUtilisateur = null;
if (isset($_SESSION['erreurUtilisateur']) && $_SESSION['erreurUtilisateur'] !== null) {
  $erreurUtilisateur = $_SESSION['erreurUtilisateur'];
}

if (isset($_POST['valider'])) {


  if (!empty($_POST['email_utilisateur']) and !empty($_POST['email_utilisateur'])) {
    if (!filter_var($_POST['email_utilisateur'], FILTER_VALIDATE_EMAIL)) {
      $erreurUtilisateur = " Email invalide!";
    } else if (!empty($_POST['mdp_utilisateur']) and !empty($_POST['mdp_utilisateur2'])) {

      if ($_POST['mdp_utilisateur'] != $_POST['mdp_utilisateur2']) {
        $erreurUtilisateur = " Veuillez saisir des mots de passe identiques!";
      } else {
        $_SESSION['nom_utilisateur'] = $_POST['nom_utilisateur'];
        $_SESSION['prenom_utilisateur']  = $_POST['prenom_utilisateur'];
        $_SESSION['email_utilisateur']  = $_POST['email_utilisateur'];
        $_SESSION['mdp_utilisateur']  = $_POST['mdp_utilisateur'];
        header("location: Traitement_inscription.php");
      }
    }
  }
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <title>title</title>
  <link rel="stylesheet" type="text/css" media="screen" href="lestyle.css" />
</head>

<body>
  <header>
    <?php
    include("menu.php");
    ?>
  </header>
  <form method="post" action="">
    <div>
      <img src="images\quand.png" alt="" width=300px height=300px />
      <img src="images\ce que.png" alt="" width=300px height=300px />
      <img src="images\ou.png" alt="" width=300px height=300px />
    </div>

    <h3 align="center">Inscrivez-vous</h3>
    <div id="linscription">
      <ul>
        <li>
          <input type="text" id="nom" name="nom_utilisateur" placeholder="Entrez votre nom *" required />
        </li>
        <li>

          <input type="text" id="prenom" name="prenom_utilisateur" placeholder="Entrez votre prénom *" required />

        </li>
        <li>
          <input type="text" id="email" name="email_utilisateur" placeholder="Entrez votre email *" required />
        </li>
        <li>

          <input type="password" id="mdp" name="mdp_utilisateur" placeholder="Entrez votre mot de passe *" required />
        </li>
        <li>

          <input type="password" id="mdp2" name="mdp_utilisateur2" placeholder="Entrez de nouveau votre mot de passe *" required />
        </li>
        <li>        <input type="submit" value="Inscription" name="valider" />
</li>

      </ul>
      <ul>
      <a href="Connexion.php">Connexion</a> 
      </ul>
      <ul> <label for="mdp_utilisateur" name="toto"><?= $erreurUtilisateur ?></label>
      </ul>
    </div>


  </form>
  <footer>&#169; MIZ</footer>
</body>

</html>