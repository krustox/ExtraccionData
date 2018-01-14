<?php
include('../Config/connection.php');
include('../Config/mysql.php');
include('../Functions/Archivo.php');
include('../Functions/Function.php');
include('../Functions/ldap.php');

session_start();
verify($_SESSION['u'], session_id(), getRealIP(),$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host);
if(isset($_SESSION['u'])){
	$server = $_GET['server'];
	$now = $_GET['fecha'];
	//echo $now;
	crearProceso($_SESSION['u'], $server,$now,$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host);
}



?>