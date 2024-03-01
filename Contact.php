<?php
session_start();

$message = null;
$erreurContact = null;
if (isset($_POST['valider'])) {

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $erreurContact = " Email invalide!";
    } else {


        if (!empty($_POST['message']) && $_POST['message'] !== null) {
            $email = "testmiz59@hotmail.com";
            $sujet = "sujet";
            $message = $_POST['message'];
            $header = "MIME-Version:1.0\n";
            $header .= "FROM:testmiz59@hotmail.com" . "\r\n" . "Reply-to:" . $_POST['email'];

            mail($email, $sujet, $message, $header);
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
    <form method="post" align="center">
        <br>
        <h1>Contactez-nous</h1>

        <ul>
            <input type="text" name="nomexp" placeholder="Saisir votre nom *" required />
        </ul>

        <ul>
            <input type="email" name="email" placeholder="Saisir votre email *" required />
        </ul>
        <ul>
            <textarea name="message" placeholder="Saisir votre contenu *" required></textarea>
        </ul>
        <ul>
            <input type="submit" name="valider">
        </ul>
        <br>
        <ul><label name="toto"><?= $erreurContact ?></label></ul>
    </form>
    <footer>&#169; MIZ</footer>
</body>

</html>