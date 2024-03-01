<?php
session_start();
$_SESSION['id_SujetMessage']=$_GET["id_SujetMessage"];
header("location: Messagerie.php");

?>