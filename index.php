<?php
session_start();
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
            <ul>
                <?php
                if (!isset($_SESSION['id_utilisateur']) || $_SESSION['id_utilisateur'] == null) {
                ?>
                    <a href="Connexion.php">Connexion</a>
                    <a href="Inscription.php">Inscription</a>
            </ul>
        <?php
                }
        ?>

        <video controls src="videos/salle.mp4">Le texte à afficher si la vidéo ne se charge pas</video>

        </div>
        <div>    <MARQUEE width="800"><h3>Bienvenue sur notre site! So'Fit est ouvert tous les jours de 8h à 22h.</h3></MARQUEE></div>

   </form>
    <footer>&#169; MIZ</footer>
</body>

</html>