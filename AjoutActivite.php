<?php
session_start();

if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur'] !== null)
{
$servername = "localhost";
$username = "root";
$password = "";

try {
    $mysqlClient = new PDO("mysql:host=$servername;dbname=mysofitdb", $username, $password);
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}



$activite_id = $_GET["activite_id"];
$id_utilisateur = $_GET["id_utilisateur"];

$requete = $mysqlClient->prepare("INSERT INTO activites_utilisateurs VALUES (:activite_id , :id_utilisateur)");
$requete->execute(
    array(
        "activite_id" => $activite_id,
        "id_utilisateur" => $id_utilisateur
    )
);
header("location: Planning.php");

}
else{

  header("location: Index.php");

}
?>