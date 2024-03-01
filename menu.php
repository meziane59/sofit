<nav>
    <ul>
    <li><a href="Index.php"><img class="logo" src="images\logo2.ico"></a></li>

       <!-- <li> <a href="Index.php">Accueil</a></li> -->

        <?php if (isset($_SESSION['id_utilisateur']) && $_SESSION['id_utilisateur'] !== null) : ?>
            <li><a href="Planning.php">Planning</a></li>
            <li> <a href="Messagerie.php" name="Messagerie">Messagerie</a></li>
            <li> <a href="AjouterUnSujet.php" name="AjouterUnSujet">Ajout activité</a></li>
            <li> <a href="Contact.php">Contact</a></li>
            <div class="personne">
                <ul>
                <li> <a href="Deconnexion.php" name="Deconnexion">Déconnexion</a></li>

                <li> <a>Bonjour <?= $_SESSION['nom']; ?></a></li>
                </ul>
            </div>
        <?php else : ?>
            
            <li><a href="Inscription.php">Inscription</a>
            <li> <a href="Contact.php">Contact</a></li>
            <div class="personne">
            <li><a href="Connexion.php">Connexion</a></li>
            </div>

        <?php endif; ?>
        </li>
    </ul>
</nav>