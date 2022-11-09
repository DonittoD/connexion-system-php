<?php
include('includes/_header.php');
?>
	<body>

	
	<div class="wrapper">
	<div class="container">
			
		<div >
			<div class="center" >
				<h2>
				<?php
				
				require_once 'connexion.php';
				
				session_start();

				if(!isset($_SESSION['user_login'] ) || time() - $_SESSION['login_time'] > 30 )	//check unauthorize user not access in "welcome.php" page
				{
					header("location: index.php");
                    session_destroy();
				}
				
				$id = $_SESSION['user_login'];
				
				$select_stmt = $db->prepare("SELECT * FROM user WHERE ID=:uid");
				$select_stmt->execute(array(":uid"=>$id));
	
				$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
				
				if(isset($_SESSION['user_login']))
				{
				?>
					Welcome,
				<?php
						echo $row['username'];
				}
				?>
				</h2>
					<a href="deconnexion.php">Logout</a>
			</div>
			
		</div>
		
	</div>	

	<?php 
			include('includes/_footer.php');
	?>