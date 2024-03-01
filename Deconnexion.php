<?php
session_start();
if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur'] !== null) {
  session_destroy();
  session_start();
  header("location: Index.php");
}
