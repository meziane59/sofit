<?php
session_start();
if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur'] !== null) {

if (isset($_POST['valider'])) {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $nom_images = null;
    $dossier_images = null;
    $id_images = null;

    try {
        $mysqlClient = new PDO("mysql:host=$servername;dbname=mysofitdb", $username, $password);
        $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    if (isset($_SESSION['imageUpload'])  && $_SESSION['imageUpload'] !== null) {

        $dossier_images =   $_SESSION['imageUpload'];
        $nom_images = substr($_SESSION['imageUpload'], 0, strpos($_SESSION['imageUpload'], '.'));


        $requete = $mysqlClient->prepare("INSERT INTO images VALUES (0,:nom_images , :dossier_images)");
        $requete->execute(
            array(
                "nom_images" => $nom_images,
                "dossier_images" => $dossier_images
            )
        );
    }

    if ($_SESSION['id_utilisateur'] !== null) {

        $id_createur = $_SESSION['id_utilisateur'];
    }
    $titre = null;
    $contexte = null;


    if (!empty($_POST['titre']))
        $titre = htmlspecialchars($_POST['titre']);


    if (!empty($_POST['description']))
        $contexte =  htmlspecialchars($_POST['description']);

    if (isset($_SESSION['imageUpload'])  && $_SESSION['imageUpload'] !== null) {

        $images = $mysqlClient->prepare('SELECT id_image from images where nom_images = :nom_images');
        $images->execute(array("nom_images" => $nom_images));

        if ($images !== null) {
            foreach ($images  as $image) {
                $id_images = $image['id_image'];
?>
                </br>
<?php
            }
        }
    }



    $requete2 = $mysqlClient->prepare("INSERT INTO sujet VALUES (0,:id_createur , :titre, :contexte, :id_images)");
    $requete2->execute(
        array(
            "id_createur" => $id_createur,
            "titre" => $titre,
            "contexte" => $contexte,
            "id_images" => $id_images
        )
    );
    $_SESSION['imageUpload'] = null;
}

}
else{

  header("location: Index.php");

}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>title</title>
    <link rel="stylesheet" type="text/css" media="screen" href="lestyle.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <header>
        <?php
        include("menu.php");
        ?>
    </header>
    <form method="POST" action="" align="center" enctype="multipart/form-data">


        </br>

        </br>
        <h4>Titre</h4><input type="text" name="titre" placeholder="Saisir le titre" <?php
                                                                                    if (isset($_SESSION['titre'])  && $_SESSION['titre'] !== null) {
                                                                                    ?> value=<?= $_SESSION['titre'];
                                                                                            }
                                                                                                ?> />


        </br>
        <h4>Description</h4><textarea name="description" id="" cols="30" rows="10" placeholder="Saisir le contenu"></textarea>
        <?php
        $_SESSION['description'] = "description";
        ?>
        </br>
        <section id="messages"></section>


        <!--  <input type="submit"  value="Valider" name="valider" />   -->

        </br>
        <ul> <a href='Upload'>Ajouter une image</a> </ul>
        </br>
        <h4>Image</h4>

        <?php

        if (isset($_SESSION['imageUpload'])  && $_SESSION['imageUpload'] !== null) {
            echo   $_SESSION['imageUpload'];
        }
        ?>
        </br>
        </br>
        <input type="submit" name="valider" />

        <section id="messages"></section>

    </form>
    <footer>&#169; MIZ</footer>
</body>

</html>