<nav>
            <a class="bouton" href='accueil.php'>Accueil</a>
  
            <a class="bouton" href=''>Shoping</a>

            <a class="bouton" href=''>Contact </a>

            


            <?php  
            
                if(isset($_SESSION["user_login"]))	
                {
                    echo"<a class='bouton' href='bienvenue.php'>profils</a>";
                
                    if($_SESSION["role"] == "admin")
                    {
                        echo '<a class="bouton" href="database.php"> admin</a> '; 
                    }else{
                        echo '';
                    }
                }
                else
                {

                    echo '<a class="bouton" href="index.php">connexion</a>';
                }

              
            ?>
</nav>
    