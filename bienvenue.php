<body>
	<div class="wrapper">
		<div class="container">
			<div>
						<?php

						require_once 'connexion.php';

						session_start();
						include('includes/_header.php');

						if (!isset($_SESSION['user_login']) || time() - $_SESSION['login_time'] > 300)	//check unauthorize user not access in "welcome.php" page
						{

							session_destroy();

							header("location: index.php");
						}

						$id = $_SESSION['user_login'];

						$select_stmt = $db->prepare("SELECT * FROM users WHERE ID=:uid");
						$select_stmt->execute(array(":uid" => $id));

						$row = $select_stmt->fetch(PDO::FETCH_ASSOC); ?>
			<div class="param">
					<h2>
						<?php

						if (isset($_SESSION['user_login'])) {
						?>
							Bienvenue,
						<?=
							$row['username'];
						}
						?>
					</h2>
				<form method="post" class="form_utilisateur">
					<h4>Information utilisateur :</h4>
					<div class='info_utilisateur'>
						<div>
							<label>Identifiant : </label>
							<?= $row['username'];?>
						</div>
						<div>
							<label>Email :</label>
							<?= $row['email'];?>
						</div>
						<div>
							<label>nom :</label> <?php  //echo $row['nom'];?> 
							<input type="text" name="txt_username_email" class="form-control" placeholder="enter votre identifiant ou email" />
				
						</div>
						<div>
							<label>prenom :</label> <?php // echo $row['prenom'];?> 
							<input type="text" name="txt_username_email" class="form-control" placeholder="enter votre identifiant ou email" />
						</div>
						<div>
							<label>Reset Mot de passe</label>
							<input type="password" name="newpass" class="form-control" placeholder="enter votre identifiant ou email" />
						</div>
						<?php
								if (isset($_POST['newpass']))
								{
									$password = $_POST['newpass'];
									if(strlen($password) > 6){
										$new_password = password_hash($password, PASSWORD_DEFAULT); //encrypt password using password_hash()
										$insert_stmt=$db->prepare("UPDATE users SET password = :new_password WHERE id = :id"); //sql insert query
										// on execute la Requete sql
										$insert_stmt->execute(array('new_password' => $new_password, 'id' => $id));
										 
									

										echo "<strong class='warn'>Modification réussite</strong>";
									}else{
										echo "<strong class='warn'>Mot de passe trop cours</strong>";
									}
								}
							?>
						<input type="submit" class='modif'  name="modif_mps"  value="modifier">
					</div>	
					</form>
					<div class='bouton_deco'>
						<a href="deconnexion.php">deconnexion</a>
					</div>
				</div>
				</div>		
			

			</div>

		</div>

		<?php
		include('includes/_footer.php');
		?>