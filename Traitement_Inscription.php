<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";

try {
    $mysqlClient = new PDO("mysql:host=$servername;dbname=mysofitdb", $username, $password);
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (!empty($_SESSION['nom_utilisateur']) && !empty($_SESSION['prenom_utilisateur']) && !empty($_SESSION['email_utilisateur']) && !empty($_SESSION['mdp_utilisateur'])) {

    $nom = $_SESSION['nom_utilisateur'];
    $prenom = $_SESSION['prenom_utilisateur'];
    $email = $_SESSION['email_utilisateur'];
    $mdp = $_SESSION['mdp_utilisateur'];
    if ($nom != null and $prenom != null and $email != null and $mdp != null) {

        $utilisateur = $mysqlClient->prepare('SELECT * from utilisateurs where email_utilisateur =?');
        $utilisateur->execute(array($email));
        $utilisateur = $utilisateur->fetch();

        if (isset($utilisateur['id_utilisateur'])) {
            $_SESSION['erreurUtilisateur'] = " L'utilisateur existe déjà!";
            header("location: Inscription.php");
        } else {

            $requete = $mysqlClient->prepare("INSERT INTO utilisateurs VALUES (0, :nom_utilisateur, :prenom_utilisateur, :email_utilisateur, sha1(:mdp_utilisateur), :profil_utilisateur)");
            $requete->execute(
                array(
                    "nom_utilisateur" => $nom,
                    "prenom_utilisateur" => $prenom,
                    "email_utilisateur" => $email,
                    "mdp_utilisateur" => $mdp,
                    "profil_utilisateur" => ""
                )
            );
            //  mysqlClient-> closeCursor();
            header("location: Connexion.php");
        }
    }
}
else{

    header("location: Index.php");
  
  }
?>  