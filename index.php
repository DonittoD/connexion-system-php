<?php
// 
require_once 'connexion.php';

// 
session_start();

// 
if(isset($_SESSION["user_login"]))	//check condition user login not direct back to index.php page
{
	header("location: bienvenue.php");
}

// 
if(isset($_REQUEST['btn_login']))	//button name is "btn_login" 
{
	$username	=strip_tags($_REQUEST["txt_username_email"]);	//textbox name "txt_username_username"
	$email		=strip_tags($_REQUEST["txt_username_email"]);	//textbox name "txt_username_email"
	$password	=strip_tags($_REQUEST["txt_password"]);			//textbox name "txt_password"
		
	// 
	if(empty($username) || (empty($password)) || (empty($email))){						
		$errorMsg[]="un champs est vide";	//check si il y a un champs qui est vide
	}

	else
	{
		try
		{
			$select_stmt=$db->prepare("SELECT * FROM users WHERE username=:uname OR email=:uemail"); //sql select query
			$select_stmt->execute(array(':uname'=>$username, ':uemail'=>$email));	//execute query with bind parameter
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
			
			if($select_stmt->rowCount() > 0)	//check condition database record greater zero after continue
			{
				if($username==$row["username"] OR $email==$row["email"]) //check condition user taypable "username or email" are both match from database "username or email" after continue
				{
					if(password_verify($password, $row["password"])) //check condition user taypable "password" are match from database "password" using password_verify() after continue
					{
						$_SESSION["user_login"] = $row["id"];	//session name is "user_login"
                        			$_SESSION['login_time'] = time();
						$_SESSION['role'] = $row['role'] ;
						$loginMsg = "Successfully Login...";		//user login success message
						header("refresh:5; bienvenue.php");			//refresh 2 second after redirect to "welcome.php" page
					
					}else{ $errorMsg[]="wrong password";}
				
				}else{$errorMsg[]="wrong username or email"; }
			
			} else{$errorMsg[]="wrong username or email";}
		}

		catch(PDOException $e)
		{
			$e->getMessage();
		}		
	}
}
//
include('includes/_header.php');
?>
	<body>	
	<div>
	
	<div class="container">	
		<div>
		
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
				<form method="post">	
					<div>
						<label >Identifiant ou Email</label>
					</div>	
					<div>
						<input type="text" name="txt_username_email" class="form-control" placeholder="enter votre identifiant ou email" />
					</div>
			</div>
					
				<div >
					<label >Mot de passe</label>
						<div>
							<input type="password" name="txt_password" class="form-control" placeholder="enter votre mot de passe" />
						</div>
				</div>
				
				<div>
					<div >
						<input type="submit" name="btn_login" class="" value="connexion">
					</div>
				</div>
				
				<div >
					<div >
						Vous n'avez pas de compte ? <a href="register.php"><p class="text-info"> Cliqu?? ici our cr??e un compte</p></a>		
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
