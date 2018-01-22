<?php include('../Config/connection.php');
include('../Config/mysql.php');
include('../Functions/Archivo.php');

session_start();

if(isset($_SESSION['u'])){
	verify($_SESSION['u'], session_id(), getRealIP(),$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host);
?>
<!DOCTYPE html>
<html lang="en">
		<?php include('../head.php');?>
		<body>
		<div id="bloquea" class="cargando" style="display:none;">
			<img style="margin-left: 5%;margin-top: 15%" alt="Espere..." src="/ExtraccionData/imagenes/loading.gif" />
		</div>
		<div id="wrapper">
			<?php include('../header.php');?>
			<div id="container">
				<h2>Página o Archivo no Encontrados</h2>
        <a href="../index.php">Volver</a>
      </div>

		</div>
		<?php include('../footer.php');?>
	</body>
</html>
<?php
}else{
	header("Location: http://$host/ExtraccionData/index2.php");
}
?>
