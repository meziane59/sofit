<?php
session_start();
//echo  "..............." .$_SESSION['activite']; 
//if($_SESSION['activite'] == null )
//$_SESSION['activite']=null ;
$utilisateur = null;
$mesActivites = null;
if (isset($_SESSION['date_activites']) && $_SESSION['date_activites'] !== null)


  if (isset($_SESSION['date_activites']) && $_SESSION['date_activites'] !== null)
    $ladate = htmlspecialchars($_SESSION['date_activites']);
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
      <br>
      <input type="date" id="ladate" name="ladate" <?php if (isset($_POST['valider'])) { ?> value=<?= htmlspecialchars($_POST['ladate'])  ?> 
      <?php } else if (isset($_SESSION['date_activites']) && $_SESSION['date_activites'] !== null) { ?> value=<?= htmlspecialchars($_SESSION['date_activites']) ?> <?php }
                                                                                                                                                        ?> />
      <input type="submit" value="Valider" name="valider" />



      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";

      try {
        $mysqlClient = new PDO("mysql:host=$servername;dbname=mysofitdb", $username, $password);
        $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
      }
      ?>


      <?php

      if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur'] !== null)
      {

      if (isset($_POST['valider'])  &&  !empty($_POST['ladate'])) {

        $ladate = htmlspecialchars($_POST['ladate']);
        $_SESSION['date_activites'] = $ladate;
      }

      if ((isset($_POST['valider'])  &&  !empty($_POST['ladate'])) || (isset($_SESSION['date_activites']) && $_SESSION['date_activites'] !== null) || $_SESSION['id_utilisateur'] !== null) {

        if ((isset($_POST['valider'])  &&  !empty($_POST['ladate'])) || (isset($_SESSION['date_activites']) && $_SESSION['date_activites'] !== null)) {

          $utilisateur = $mysqlClient->prepare('SELECT * from activites where date_activites =? order by activite_id desc');
          $utilisateur->execute(array($ladate));
        }

        if ($_SESSION['id_utilisateur'] !== null) {

          $mesActivites = $mysqlClient->prepare('SELECT activites.activite_id, activites.discipline, activites.programme, activites.duree, 
        activites.date_activites, activites.heure from activites INNER JOIN activites_utilisateurs on activites.activite_id = activites_utilisateurs.activite_id
         INNER JOIN utilisateurs on activites_utilisateurs.id_utilisateur = utilisateurs.id_utilisateur 
         where  activites_utilisateurs.id_utilisateur =? order by  activites.date_activites desc,activites.heure desc');
          $mesActivites->execute(array($_SESSION['id_utilisateur']));
        }
      }
      }
      else{

        header("location: Index.php");

      }
      ?>


      <h1>Planning des activités </h1>
      <div id="divConteneur">

        <table class="CSSTablePlanning" align="center">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Discipline</th>
              <th scope="col">Programme</th>
              <th scope="col">Durée</th>
              <th scope="col">Date</th>
              <th scope="col">Heure</th>
              <th scope="col">V</th>

            </tr>
          </thead>
          </tbody>
        </table>
        <table class="CSSTablePlanning" id="a4" align="center">
          <?php
          if ($utilisateur !== null) {
            foreach ($utilisateur  as $resultat) {
          ?>
              <tr>
                <td><?= $_SESSION['activite_id'] = $resultat['activite_id']  ?></td>
                <td> <?= $resultat['discipline'] ?></td>
                <td> <?= $resultat['programme'] ?></td>
                <td> <?= $resultat['duree'] ?></td>
                <td> <?= $_SESSION['date_activites'] = $resultat['date_activites'] ?></td>
                <td> <?= $resultat['heure'] ?></td>


                <td>
                  <a href='AjoutActivite?activite_id=<?= $resultat['activite_id'] ?>&id_utilisateur=<?= $_SESSION['id_utilisateur'] ?>'>
                    <img src='images/ajouter.jpg' width=20px height=20px />
                  </a>
                </td>

              </tr>
          <?php
            }
          }


          ?>

        </table>
      </div>

      <h1>Votre parcours </h1>

      <table class="CSSTablePlanning" align="center">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Discipline</th>
            <th scope="col">Programme</th>
            <th scope="col">Durée</th>
            <th scope="col">Date</th>
            <th scope="col">Heure</th>
            <th scope="col">V</th>

          </tr>
        </thead>
        </tbody>

      </table>
      <table class="CSSTablePlanning" id="a4" align="center">

        <?php
        if ($mesActivites !== null) {
          foreach ($mesActivites  as $resultat) {
        ?>
            <tr>
              <td><?= $_SESSION['activite_id'] = $resultat['activite_id']  ?></td>
              <td> <?= $resultat['discipline'] ?></td>
              <td> <?= $resultat['programme'] ?></td>
              <td> <?= $resultat['duree'] ?></td>
              <td> <?= $_SESSION['date_mesactivites'] = $resultat['date_activites'] ?></td>
              <td> <?= $resultat['heure'] ?></td>
              <td class="v">
                <a href='SupprimerActivite?activite_id=<?= $resultat['activite_id'] ?>&id_utilisateur=<?= $_SESSION['id_utilisateur'] ?>'>
                  <img src='images/supprimer.jpg' width=20px height=20px />
                </a>
              </td>
            </tr>
        <?php
          }
        }


        ?>

      </table>
    </div>
  </form>
  <footer>&#169; MIZ</footer>
</body>

</html>