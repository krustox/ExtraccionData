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
	$inicio = $_GET['fecha'];
	$now = date("Y-m-d H:i:s");
	//echo $now;
	FinProceso($_SESSION['u'], $server,$now,$inicio,$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host);
}



?>