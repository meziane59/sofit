<?php
session_start();
$erreurMdp = null;
if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur'] !== null) {
    session_destroy();
    session_start();
}
$servername = "localhost";
$username = "root";
$password = "";

try {
    $mysqlClient = new PDO("mysql:host=$servername;dbname=mysofitdb", $username, $password);
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


if (isset($_POST['valider'])) {
    if (!empty($_POST['email_utilisateur']) and !empty($_POST['mdp_utilisateur'])) {

        if (!filter_var($_POST['email_utilisateur'], FILTER_VALIDATE_EMAIL)) {
            $erreurMdp = " Email invalide!";
        } else {
            $email = htmlspecialchars($_POST['email_utilisateur']);
            $mdp = sha1($_POST['mdp_utilisateur']);
            $utilisateur = $mysqlClient->prepare('SELECT * from utilisateurs where email_utilisateur =?');
            $utilisateur->execute(array($email));
            $utilisateur = $utilisateur->fetch();

            if (isset($utilisateur['id_utilisateur'])) {
                if (sha1($_POST['mdp_utilisateur']) != $utilisateur['mdp_utilisateur']) {
                    $erreurMdp = " Mot de passe invalide!";
                } else {

                    $_SESSION['id_utilisateur'] = $utilisateur['id_utilisateur'];
                    $_SESSION['nom'] = $utilisateur['nom_utilisateur'];
                    $_SESSION['prenom'] = $utilisateur['prenom_utilisateur'];
                    $_SESSION['email'] = $utilisateur['email_utilisateur'];
                    $_SESSION['profil'] = $utilisateur['profil_utilisateur'];
                    header("location: Planning.php");
                }
            } else {
                $erreurMdp = "Ce profil n'existe pas!";
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
    <form method="post">
        <div>
            <img src="images\quand.png" alt="" width=300px height=300px />
            <img src="images\ce que.png" alt="" width=300px height=300px />
            <img src="images\ou.png" alt="" width=300px height=300px />
        </div>
        <div>
            <h3 align="center">Connectez-vous</h3>
            <ul>
                <input type="text" id="email" name="email_utilisateur" placeholder="Entrez votre email *" required />
                <br />
            </ul>

            <ul>
                <input type="password" id="mdp" name="mdp_utilisateur" placeholder="Entrez votre mot de passe *" required />

            </ul>
            <ul> <input type="submit" value="Valider" name="valider" /> </ul>
            <ul> <a href="Inscription.php">Inscription</a> </ul>
            <br>
            <ul><label for="email" name="toto"><?= $erreurMdp ?></label></ul>
        </div>

    </form>
    <footer>&#169; MIZ</footer>
</body>

</html>