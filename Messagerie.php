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


if ($_SESSION['id_utilisateur'] !== null) {

  $Sujets = $mysqlClient->prepare('SELECT * FROM sujet INNER JOIN utilisateurs ON sujet.id_createur = utilisateurs.id_utilisateur order by id_sujet desc');
  $Sujets->execute();
}


if (isset($_POST['valider'])) {


  if (isset($_SESSION['id_SujetMessage']) && $_SESSION['id_SujetMessage'] !== null) {
    $lemessage = nl2br(htmlspecialchars($_POST['messages']));

    $pseudo = htmlspecialchars($_SESSION['prenom']);
    $requete = $mysqlClient->prepare('INSERT INTO messages(pseudo , message,date_message, heure_message, id_sujet) VALUES (? , ?, ?, ?,?)');
    $requete->execute(
      array(
        $pseudo, $lemessage,  date("Y-m-d"), date("H:i"), $_SESSION['id_SujetMessage']
      )
    );
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

  <script language="JavaScript">
    function display_photo(p_name, p_w, p_h, p_legend) {
      if (self.innerWidth) {
        winwidth = self.innerWidth;
        winheight = self.innerHeight;
      } else if (document.documentElement && document.documentElement.clientWidth) {
        winwidth = document.documentElement.clientWidth;
        winheight = document.documentElement.clientHeight;
      } else if (document.body) {
        winwidth = document.body.clientWidth;
        winheight = document.body.clientHeight;
      }
      if (Number(p_w) < winwidth) winwidth = Number(p_w);
      if (Number(p_h) < winheight) winheight = Number(p_h);
      winwidth += 8;
      winheight += 40;
      pwin = window.open("", "", "toolbar=0,location=0,directories=0,status=0,menubar=0,resizable=1,scrollbars=yes,copyhistory=0,width=" + winwidth + ",height=" + winheight + ",left=10,top=10");
      pwin.document.write("<html><head>");
      pwin.document.write("<title>Zoom</title>");
      pwin.document.write("<style type=text/css>");
      pwin.document.write("body {");
      pwin.document.write("margin:0;");
      pwin.document.write("padding:0;");
      pwin.document.write("color:white;");
      pwin.document.write("background-color:black; }");
      pwin.document.write("</style>");
      pwin.document.write("</head>");
      pwin.document.write("<body>");
      pwin.document.write("<img src=" + p_name + " width=" + p_w + " height=" + p_h + ">");
      pwin.document.write("<table noborder width=100%><tr>");
      pwin.document.write("<form><td align=left>" + p_legend + "</td>");
      pwin.document.write("<td align=right><input type='button' value='Fermer' onClick='window.close()'></td>");
      pwin.document.write("</tr></table></form>");
      pwin.document.write("</body></html>");
    }

    function tchatSujetId(lidsujet) {
      if (lidsujet != null)
        var maVariable = lidsujet;

    }

    setInterval('loadmessage()', 500);

    function loadmessage() {
      $('#messages').load('tchat.php');

    }
  </script>


</head>

<body>
  <header>
    <?php
    include("menu.php");
    ?>
  </header>
  <form method="POST" action="" align="center">
    </br>

    <h2>Sujets </h2>
    <ul>
      <a href='AjouterUnSujet'>Ajouter un sujet</a>

    </ul>

    <table class="CSSTable" align="center">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">id createur</th>
          <th scope="col">titre</th>
          <th scope="col">contexte</th>
          <th scope="col">image</th>
          <th scope="col">V</th>
        </tr>
      </thead>
      </tbody>
    </table>

    <table class="CSSTable" id="a2" align="center">

      <?php
      if ($Sujets !== null) {
        foreach ($Sujets  as $Sujet) {
      ?>
          <tr>
            <td><?= $_SESSION['id_sujet'] = $Sujet['id_sujet']  ?></td>
            <td> <?= $Sujet['id_createur'] ?></td>
            <td> <?= $Sujet['titre'] ?></td>
            <td> <?= $Sujet['contexte'] ?></td>



            <?php if ($Sujet['id_image'] != null) {
              $lesimages = $mysqlClient->prepare('SELECT nom_images, dossier_images from images
     where  images.id_image =?');
              $lesimages->execute(array($Sujet['id_image']));

              foreach ($lesimages as $limage) {
                if ($limage['dossier_images'] != null) {
            ?>

                  <td> <a href="javascript:display_photo('images/<?= $limage['dossier_images'] ?>','1160','828','<?= $limage['dossier_images'] ?>')">
                      <img src='images/<?= $limage['dossier_images'] ?>' width=40 height=40 />
                    </a></td>

              <?php
                }
              }
            } else {
              ?>
              <td></td>
            <?php
            }
            ?>

            <td>
              <a href='SessionSujet?id_SujetMessage=<?= $_SESSION['id_sujet'] ?>'>
                <img src='images/tchat.jpg' width=20px height=20px />
              </a>
            </td>



          </tr>
      <?php
        }
      }

      ?>
    </table>


    <h2>Tchat </h2>

    <section id="messages"></section>
    <br>

    <input type="text" name="messages" id="" cols="100" rows="5" placeholder="Saisir votre texte" align="center" />
    <input type="submit" name="valider" />


  </form>



  <footer>&#169; MIZ</footer>
</body>

</html>