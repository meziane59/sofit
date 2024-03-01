<?php
session_start();
if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur'] !== null) {

$servername = "localhost";
$username = "root";
$password = "";
try {
  $mysqlClient = new PDO("mysql:host=$servername;dbname=mysofitdb", $username, $password);
  $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}
if (isset($_SESSION['id_SujetMessage']) and $_SESSION['id_SujetMessage'] !== null) {

  $lesmessages = $mysqlClient->prepare('SELECT * from messages WHERE id_sujet=? ORDER BY  id_message DESC');
  $lesmessages->execute(array($_SESSION['id_SujetMessage']));
?>

  <!-- <table class="CSSTableTchat"  align="center">
  <thead>
    <tr>
      <th scope="col">Pseudo</th>
      <th scope="col">Message</th>
    </tr>
  </thead>
        </tbody>
        </table>    -->
  <table class="CSSTableTchat" id="aTchat" align="center">
    <?php
    while ($message = $lesmessages->fetch()) {

      $date1 =  $message['date_message'];
      $cal = IntlCalendar::fromDateTime("$date1 Europe/Paris");

      $ladate = IntlDateFormatter::formatObject($cal, " dd/MM/Y", "fr_FR");
    ?>
      <tr>
        <td> <strong><?= $message['pseudo'] ?> </strong></td>

        <td><?= $message['message']  ?></td>
        <td><?= $ladate ?></td>
        <td><?= $message['heure_message']  ?></td>
      </tr>
  <?php
    }
    //$lesmessages->closeCursor();

  }
}
else{

  header("location: Index.php");

}

  ?>
  </table>

  </tbody>
  </table>