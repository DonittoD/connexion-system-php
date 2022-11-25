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
						<?php
							echo $row['username'];
						}
						?>
					</h2>
				<form method="post" class="form_utilisateur">
					<h4>Information utilisateur :</h4>
					<div class='info_utilisateur'>
						<div>
							<label>Identifiant : </label>
							<?php  echo $row['username'];?>
						</div>
						<div>
							<label>Email :</label>
							<?php  echo $row['email'];?>
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
							<input type="text" name="txt_username_email" class="form-control" placeholder="enter votre identifiant ou email" />
				
						</div>
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