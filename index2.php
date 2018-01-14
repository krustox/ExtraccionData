<?php
include('/Config/connection.php');
include('/Functions/Function.php');
include('/Functions/Archivo.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<?php include('head.php');?>
	<body>
		<div id="wrapper">
			<?php include('header.php');?>
			<div id="container">
				<?php
				if (isset($_GET['ok'])){
					if($_GET['ok'] == 0){
				?>
				<div class="error">
					<h4>Error al inciar Sesión. Verifique usuario y contraseña </h4>
				</div>
				<?php
					}else if ($_GET['ok'] == 1){
				?>
				<div class="error">
					<h4>Usuario no Autorizado</h4>
				</div>
				<?php	
					}
				}
				?>	
				<div  id="login" class="formularios data">
					<form action="ajax/login.php" method="post">
						<label for="user">Usuario</label>
						<input type="text" id="user" name="user" value ="">
						<label for="password">Contraseña</label>
						<input type="password" id="pass" name="pass" value="" />
						<input type="submit" value="Ingresar" />
					</form>
				</div>
			</div>			
		</div>
		<?php include('footer.php');?>
	</body>
</html>
