<?php
// je demande de ce connecter a la bdd avec le require
require_once 'connexion.php';

// je lance la session dans cette page
session_start();

// on verifie si l'utilisateur est deja connecter
if(isset($_SESSION["user_login"]))	
{
	header("location: bienvenue.php");
}

// la condition est de voir si en cliquant sur le tout est que les champ Identifant, Mail, et Mot de passe sont remplis
if(isset($_REQUEST['btn_login']))	//le nom du button est "btn_login" 
{
	$username	=strip_tags($_REQUEST["txt_username_email"]);	
	$email		=strip_tags($_REQUEST["txt_username_email"]);	
	$password	=strip_tags($_REQUEST["txt_password"]);			

		
	// la condition est de voir si le champs d'Identifant est t'il vide si oui message d'erreure
	if(empty($username)){						
		$errorMsg[]="please enter username or email";
	}

	// la condition est de voir si le champs email est t'il vide si oui message d'erreure
	else if(empty($email)){
		$errorMsg[]="please enter username or email";
	}

	// la condition est de voir si le champs mot de passe est t'il vide si oui message d'erreure
	else if(empty($password)){
		$errorMsg[]="please enter password";	
	}
	else
	{

		// apres les 3 condition  de verification des champs il y a la tentative a la connexion a la base de donné
		try
		{
			//  on prepare la requete sql pour se connecter 
			$select_stmt=$db->prepare("SELECT * FROM user WHERE username=:uname OR email=:uemail"); 

			// je sais pas si cette ligne de code $select_stmt->execute permet toujours de proteger la base donné des
			//  injection SQL mais si non il faut que je fasse un bindValue ou un bindParam

			$select_stmt->execute(array(':uname'=>$username, ':uemail'=>$email));	//execute query with bind parameter
			
			// on recupere les informations avec un fetch assoc
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
			
			// la contion est que la requete sois suppérieur a 1 pout continuer 
			if($select_stmt->rowCount() > 0)	
			{
				// la condition demande si l'utilisateur a mis on Identifiant ou sont Email et que les deux sont dans la base de données 
				if($username==$row["username"] OR $email==$row["email"]) 
				{
					// on verifie le mot de passe entre celui de la base de données et celui qui est sur la base de données en utilisant la fonction password verify 
					if(password_verify($password, $row["password"])) 
					{
						// apres toutes le verification on attribue les information recuperer  de la base de donnée pour 
						// La session 
						$_SESSION["user_login"] = $row["ID"];	 //le nom de la session est : "user_login"
                        			$_SESSION['login_time'] = time();		//on note la date de la session
						$loginMsg = "Successfully Login...";   //on envoye un message que la connexion est un succes pour l'utilisateur
						header("refresh:2; bienvenue.php"); // refresh 2 second after redirect to "welcome.php" page
						// on peut meme mettre une animation en java script mais pour plus tard
					
					}

					// ici c'est quand l'utilisateur a réussie a mettre sont Identifiant mais un mauvais mot de passe
					else
					{
						$errorMsg[]="mauvais Identifant ou mauvais mot de passe";
					}
				}

				// ici c'est quand ma base de données n'a pas réussie a trouvée un identifiant
				else
				{
					$errorMsg[]="mauvais Identifant ou mauvais mot de passe";
				}
			}
			
			// ici c'est quand ma base de données n'a pas réussie a trouvée un identifiant
			else
			{
				$errorMsg[]="mauvais Identifant ou mauvais mot de passe";
				// j'ai mis les trois errorMsg avec le meme texte pour évité les tentative a la force brut
			}
		}
		// c'est en cas ou si on arrive pas a se connecter a la base de données
		catch(PDOException $e)
		{
			$e->getMessage();
		}		
	}
}


// ce qui est visible par l'utilisateur
include('includes/_header.php');
?>
	<body>	
	<div>
	
	<div class="container">	
		<div class="col-lg-12">
		
		<?php
		if(isset($errorMsg))
		{
			foreach($errorMsg as $error)
			{
			?>
				<div class="alert alert-danger">
					<strong><?php echo $error; ?></strong>
				</div>
            <?php
			}
		}
		if(isset($loginMsg))
		{
		?>
			<div class="alert alert-success">
				<strong><?php echo $loginMsg; ?></strong>
			</div>
        <?php
		}
		?>   
			<div class ="page_de_connexion"><h2>Connexion</h2>
			<form method="post" class="form-horizontal">
					
				<div class="form-group">
				<label class="col-sm-3 control-label">Identifiant ou Email</label>
				<div class="col-sm-6">
				<input type="text" name="txt_username_email" class="form-control" placeholder="enter votre identifiant ou email" />
				</div>
				</div>
					
				<div class="form-group">
				<label class="col-sm-3 control-label">Mot de passe</label>
				<div class="col-sm-6">
				<input type="password" name="txt_password" class="form-control" placeholder="enter votre mot de passe" />
				</div>
				</div>
				
				<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9 m-t-15">
				<input type="submit" name="btn_login" class="" value="connexion">
				</div>
				</div>
				
				<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9 m-t-15">
				Vous n'avez pas de compte ? <a href="register.php"><p class="text-info"> Cliqué ici our crée un compte</p></a>		
				</div>
				</div>
				</div>	
			</form>
			
		</div>
		
	</div>
			
	</div>
	
	<?php 
			include('includes/_footer.php');
	?>
										
	</body>
</html>
