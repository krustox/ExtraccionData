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
				<h2>Data Anterior</h2>
				<div class="data">
					<table width="100%">
						<thead>
							<tr>
								<th width ="25%">Fecha</th>
								<th width ="50%">Archivo</th>
								<th width ="50%">Usuario</th>
								<th width ="25%">Accion</th>
							</tr>
						</thead>
						<tbody>
								<?php
								$hostname = gethostname();
								$directorio = opendir("."); //ruta actual
								while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
								{
    								if (strpos($archivo,".xlsx") != false)//verificamos si es o no un directorio
    								{
        								echo "<tr>";
        								echo "<td>". explode("_",$archivo)[1] . "</td>";
        								echo "<td>". $archivo . "</td>";
										echo "<td>". str_replace(".xlsx", "", explode("_",$archivo)[2]) . "</td>";
										echo "<td><a href=\"http://$hostname/ExtraccionData/Data/$archivo \"> Descargar</a></td>";
										echo "</tr>";
    								}
								}?>
						</tbody>
					</table>
					<a href="../index.php">Regresar</a>
				</div>
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