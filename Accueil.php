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
        <ul>
            <li><img src="images\quand.png" alt="" width=400px height=400px /></li>
            <li><img src="images\ce que.png" alt="" width=400px height=400px /></li>
            <li><img src="images\ou.png" alt="" width=400px height=400px /></li>
        </ul>
        <ul>
            <li>
                <br /> <br /> <br />
                <label for="email">Email : </label>
                <input type="text" id="email" name="email_utilisateur" placeholder="Entrez votre email" required />
                <label>*</label>
                <br />

                <label for="mdp">Mdp : </label>
                <input type="password" id="mdp" name="mdp_utilisateur" placeholder="Entrez votre mot de passe" required />
                <label>*</label>
                <br />
                <input type="submit" value="Valider" name="valider" />
            </li>
        </ul>

    </form>
    <footer>&#169; MIZ</footer>
</body>

</html>