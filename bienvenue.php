<?php
include('includes/_header.php');
?>
	<body>

	
	<div class="wrapper">
	<div class="container">
			
		<div >
			<div class="param" >
				<h2>
				<?php
				
				require_once 'connexion.php';
				
				session_start();

				if(!isset($_SESSION['user_login'] ) || time() - $_SESSION['login_time'] > 300 )	//check unauthorize user not access in "welcome.php" page
				{
                 
					session_destroy();

					header("location: index.php");
				}
				
				$id = $_SESSION['user_login'];
				
				$select_stmt = $db->prepare("SELECT * FROM user WHERE ID=:uid");
				$select_stmt->execute(array(":uid"=>$id));
	
				$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
				
				if(isset($_SESSION['user_login']))
				{
				?>
					Bienvenue,
				<?php
						echo $row['username'];
				}
				?>
				</h2>
				<!-- <div class='table_info'>
					<div class='champ'>
						<div>nom</div>
						<div>prenom</div>
						<div>date de naissance</div>
						<div>email</div>
						<div>mdp</div>
						<div>phrase secret</div>
					</div>
					<div class='champ_a_remplir'>
						<div></div>
						<div></div>
						<div></div>
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div> -->
				<div class='bouton_deco'>
					<a href="deconnexion.php">deconnexion</a>
				</div>


					
			</div>
			
		</div>
		
	</div>	

	<?php 
			include('includes/_footer.php');
	?>