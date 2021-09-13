
  <header>
        <img src="../public/images/logo_gbaf.png" alt="logo gbaf" id="logo_header" /> <?php 
            if (isset($_SESSION['id']) AND isset($_SESSION['nom']) AND isset($_SESSION['prenom']))
                {
                    echo '<div class="info_profil">
                            <p><img src="../public/images/avatar.png" alt="logo gbaf" class="avatar" />&nbsp;<a href="profil.php" id="membre">' . $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '</a></p>
                            <a href="logout.php" id="logout">Se déconnecter</a>
                        </div>';
                    
                }
                
            else
                {
                    echo '';
                }
                ?>
    </header>
