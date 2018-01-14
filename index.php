<?php include('Config/connection.php');
include('Config/mysql.php');
include('Functions/Archivo.php');

session_start();

if(isset($_SESSION['u'])){
	verify($_SESSION['u'], session_id(), getRealIP(),$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host);
?>
<!DOCTYPE html>
<html lang="en">
	<?php include('head.php');?>
	<body>
		<div id="bloquea" class="cargando" style="display:none;">
			<img style="margin-left: 5%;margin-top: 15%" alt="Espere..." src="imagenes/loading.gif" />
		</div>
		<div id="wrapper">
			<?php include('header.php');?>
			<div id="container">
				<h2>Datos de Consulta</h2>
				<div class="formularios">
				<form action="javascript:void(0);" method="post">
					<h4>Linea Base</h4>
					<table width="100%">
						<thead>
							<td>
								<label for="cpu"> CPU </label>
							</td>
							<td>
								<label for="memoria"> Memoria </label>
							</td>
							<td>
								<label for="disco"> Disco </label>		
							</td>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" name="cpu" id="cpu" /></td>
								<td><input type="checkbox" name="memoria" id="memoria" /></td>
								<td><input type="checkbox" name="disco" id="disco" /></td>
							</tr>
						</tbody>
					</table>
					<h4>IIS</h4>
					<table width="100%">
						<thead>
							<td>
								<label for="ecol"> Encolados </label>
							</td>
							<td>
								<label for="concu"> Concurrentes </label>
							</td>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" name="ecol" id="ecol" /></td>
								<td><input type="checkbox" name="concu" id="concu" /></td>
							</tr>
						</tbody>
					</table>
					<h4>Base de datos</h4>
					<table width="100%">
						<thead>
							<td>
								<label for="bdserv"> Estado de Servicios </label>
							</td>
							<td>
								<label for="bdstatus"> Estado base de datos </label>
							</td>
							<td>
								<label for="bdsql"> Estado del server SQL </label>
							</td>
							<td>
								<label for="bderror"> Errores Log SQL </label>
							</td>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" name="bdserv" id="bdserv" /></td>
								<td><input type="checkbox" name="bdstatus" id="bdstatus" /></td>
								<td><input type="checkbox" name="bdsql" id="bdsql" /></td>
								<td><input type="checkbox" name="bderror" id="bderror" /></td>
							</tr>
						</tbody>
					</table>
					<h4>Was y Apache</h4>
					<table width="100%">
						<thead>
							<td>
								<label for="wassesiones"> Sesiones Abiertas </label>
							</td>
							<td>
								<label for="wasstatus"> Estado de WAS </label>
							</td>
							<td>
								<label for="wasjvm"> Memoria Usada JVM WAS </label>
							</td>
							<td>
								<label for="apachestatus"> Estado Apache </label>		
							</td>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" name="wassesiones" id="wassesiones" /></td>
								<td><input type="checkbox" name="wasstatus" id="wasstatus" /></td>
								<td><input type="checkbox" name="wasjvm" id="wasjvm" /></td>
								<td><input type="checkbox" name="apachestatus" id="apachestatus" /></td>
							</tr>
						</tbody>
					</table>
					<h4>Broker y MQ</h4>
					<table width="100%">
						<thead>
							<td>
								<label for="brokerstatus"> Estado de Broker </label>
							</td>
							<td>
								<label for="brokermq"> Estado de Conexion Broker MQ </label>
							</td>
							<td>
								<label for="mqstatus"> Estado del MQ </label>
							</td>
							<td>
								<label for="mqcolas"> Profundidad de Colas </label>
							</td>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" name="brokerstatus" id="brokerstatus" /></td>
								<td><input type="checkbox" name="brokermq" id="brokermq" /></td>
								<td><input type="checkbox" name="mqstatus" id="mqstatus" /></td>
								<td><input type="checkbox" name="mqcolas" id="mqcolas" /></td>
							</tr>
						</tbody>
					</table>
					<h4>Otros</h4>
					<table width="100%">
						<thead>
							<td><label for="heapusado">Porcentaje usado del Heap</label></td>
							<td><label for="discoio">Disco IO</label></td>
							<td><label for="ping">Ping</label></td>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" name="heapusado" id="heapusado" /></td>
								<td><input type="checkbox" name="discoio" id="discoio" /></td>
								<td><input type="checkbox" name="ping" id="ping" /></td>
							</tr>
						</tbody>
					</table>
					<h4>Servidores</h4>
					<table width="100%">
						<thead>
							<td width="100%"><label for="servidor">Servidores Windows</label></td>
						</thead>
					<tbody>
						<tr>
							<td><input type="text" name="servidor" id="servidor"/></td>
						</tr>
					</tbody>
					</table>
					<table width="100%">
						<thead>
							<td width="100%"><label for="linux">Servidores Linux</label></td>
						</thead>
					<tbody>
						<tr>
							<td><input type="text" name="linux" id="linux"/></td>
						</tr>
					</tbody>
					</table>
					<h4>Fechas</h4>
					<table width="100%">
						<thead>
							<td>
								<label for="trescinco"> 35 días </label>			
							</td>
							<td>
								<label for="pordia"> Sumarizado por día </label>
							</td>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="checkbox" name="trescinco" id="trescinco" />
								</td>
								<td>
									<input type="checkbox" name="pordia" id="pordia" />
								</td>
							</tr>
						</tbody>
					</table>
					<table width="100%">
						<thead>
							<td>
								<label for="fechai">Fecha Inicio</label>			
							</td>
							<td>
								<label for="fechai">Fecha Fin</label>
							</td>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="text" name="fechai" id="datetimepicker1"/>
								</td>
								<td>
									<input type="text" name="fechaf" id="datetimepicker2"/>
								</td>
							</tr>
						</tbody>
					</table>	
					<input type="submit" value="Consulta" onclick="bloquea('<?php echo explode(str_replace(" ", "","\ "),$_SESSION['nombre'])[1]; ?>');"/>
				</form>
				<a href="Data/Anteriores.php">Consultas Anteriores</a>
				</div>
			</div>
		</div>
		<?php include('footer.php');?>
	</body>
</html>
<?php
}else{
	header("Location: http://$host/ExtraccionData/index2.php");
}
?>