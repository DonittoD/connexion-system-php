<?php
// je demande de ce connecter a la bdd avec le require
require_once "connexion.php";

// la condition est de voir si en cliquant sur le tout est que les champ Identifant, Mail, et Mot de passe sont remplis
if(isset($_REQUEST['btn_register'])) //button name "btn_register"
{
	// on prend les trois valeur des champs html
	$username	= strip_tags($_REQUEST['txt_username']);	//textbox name "txt_email"
	$email		= strip_tags($_REQUEST['txt_email']);		//textbox name "txt_email"
	$password	= strip_tags($_REQUEST['txt_password']);	//textbox name "txt_password"
		
	// condition si l'identifiant est remplis
	if(empty($username)){
		$errorMsg[]="Please enter username";	//check username textbox not empty 
	}

	// la condition si le mail est remplis
	else if(empty($email)){
		$errorMsg[]="entrez votre email";	//check email textbox not empty 
	}

	// la condition qui permet de voir si la valeur que l'utilisateur a mis est bien un Email
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errorMsg[]="entrez un vrai email";	//check proper email format 
	}
	
	//la condition qui permet de voir si le champ de mot de passe est vide 
	else if(empty($password)){
		$errorMsg[]="entrez votre mot de passe";	//check passowrd textbox not empty
	}

	// condition que le mot de passe doit etre strictement supérieur a 6 caracteère 
	else if(strlen($password) < 6){
		$errorMsg[] = "Votre mot de passe doit etre supérieur a 6 caractere" ;	//check passowrd must be 6 characters
	}
	else
	{	
		try
		{
			//la preparation de la requete SQL  
			$select_stmt=$db->prepare("SELECT username, email FROM users 
										WHERE username=:uname OR email=:uemail"); // sql select query
			
			//la protection de la requete et execution de la requete SQL 
			$select_stmt->execute(array(':uname'=>$username, ':uemail'=>$email)); //execute query 
			
			// on prend le resiltat de la requete sql avec la methode fecth
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);	
			
			// si il y a un resultat de l'Identifian est existant on lui envoye un message d'erreure 
			error_reporting(E_ERROR | E_PARSE);
			if($row["username"]==$username){
				$errorMsg[]="Désolé mais votre Identifant est deja existant";	//check condition username already exists 
			}

			// si il y a un resultat de le mot de passe est existant
			// error_reporting(E_ERROR | E_PARSE);
			if($row["email"]==$email){
				$errorMsg[]="Désolé mais votre Email est deja existant";	//check condition email already exists 
			}

			// condition si on a pas d'erreur
			else if(!isset($errorMsg)) //check no "$errorMsg" show then continue
			{
				// on hash le mot de passe qui vien d'etre entrer
				$new_password = password_hash($password, PASSWORD_DEFAULT); //encrypt password using password_hash()
				
				// on definit de base que l'utilisateur est un utilisateur par defaut
				$role = 'utilisateur' ;
				// on prepare la requet SQL pour ajouter l'utilisateur dans la base de données
				$insert_stmt=$db->prepare("INSERT INTO users	(username,email,password,role) VALUES
																(:uname,:uemail,:upassword,:role)"); 		//sql insert query					
				// on execute la Requete sql 
				if($insert_stmt->execute(array(	':uname'	=>$username, 
												':uemail'	=>$email, 
												':upassword'=>$new_password,
												':role' =>$role ))){
					// c'est pour montrer au que creation de la session a bien ete saisie par la base de données  
					$registerMsg="Register Successfully..... Please Click On Login Account Link"; //execute query success message
					header("refresh:2; bienvenue.php");
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
include('includes/_header.php');
?>
	<body>	
	<div class="wrapper">
	
	<div class="container">
			
		<div class="col-lg-12">
		
		<?php
		if(isset($errorMsg))
		{
			foreach($errorMsg as $error)
			{
			?>
				<div class="alert alert-danger">
					<strong>WRONG ! <?php echo $error; ?></strong>
				</div>
            <?php
			}
		}
		if(isset($registerMsg))
		{
		?>
			<div class="alert alert-success">
				<strong><?php echo $registerMsg; ?></strong>
			</div>
        <?php
		}
		?>   
			<div class ='page_de_connexion'>
			<h2>Inscription</h2>
			<form method="post" class="form-horizontal">
					
				
				<div class="form-group">
				<label class="col-sm-3 control-label">Identifiant</label>
				<div class="col-sm-6">
				<input type="text" name="txt_username" class="form-control" placeholder="enter votre Identifiant" />
				</div>
				</div>
				
				<div class="form-group">
				<label class="col-sm-3 control-label">Email</label>
				<div class="col-sm-6">
				<input type="email" name="txt_email" class="form-control" placeholder="enter votre email" />
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
				<input type="submit"  name="btn_register" class="btn btn-primary " value="inscription">
				</div>
				</div>
				
				<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9 m-t-15">
				Es ce que vous avez deja un compte ? <a href="index.php"><p class="text-info">Connexion</p></a>		
				</div>
				</div>
				</div>
					
			</form>
			
		</div>

		<?php 
			include('includes/_footer.php');
		?>
