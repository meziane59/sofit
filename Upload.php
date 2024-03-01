<?php

session_start();
//if($_SERVER["REQUEST_METHOD"]== "POST"){
//    if(empty($_FILES["image_file"]["tmp_name"])){
    if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur'] !== null) {

if (isset($_POST['valider'])) {
    $imageChemin;;
    if (!empty($_FILES["image_file"]["tmp_name"])) {
        $img = $_FILES['image_file'];

        $file_basename = pathinfo($_FILES["image_file"]["name"], PATHINFO_FILENAME);
        $file_extension = pathinfo($_FILES["image_file"]["name"], PATHINFO_EXTENSION);
        $new_image_name = $file_basename . '_' . date("Ymd_His") . '.' . $file_extension;
        $_SESSION['imageUpload'] = $new_image_name;

        //         if(!empty($_POST['imageUpload']) && $_SESSION['imageUpload'] !== null)

        header("location: AjouterUnSujet.php");



        move_uploaded_file($img['tmp_name'], "images/" . $new_image_name);
        $imageChemin = "images/" . $new_image_name;
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
        <div>
            <br>
            <input type="file" name="image_file" id="images" accept="image/png, image/jpeg" multiple required>
            </label>


            <?php
            ?>
            <button type="submit" id="submitBtn" name="valider">Importez l'image</button>
        </div>
    </form>

    <footer>&#169; MIZ</footer>
</body>

</html>