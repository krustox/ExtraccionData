<header>
	<h1>Extracción de Data</h1>
	<?php
		if(isset($_SESSION['u'])){
	?>
	<p><?php echo $_SESSION['nombre']; ?></p><a onclick="logout()">Cerrar Sesion</a>
	<?php
		}
	?>
</header>