<?php
include('../Config/connection.php');
include('../Functions/Archivo.php');
include('../Functions/Function.php');
include('../Config/mysql.php');

session_start();
$ip = getRealIP();
$session = session_id();
$user = str_replace("ldap ", "", $_SESSION['u']);
$conecta = new mysqli($dbhost, $dbusuario, $dbpassword,$db,$dbport);
if($conecta->connect_error)
{
	echo $conecta->connect_error;
}else{
	if($conecta->query("DELETE FROM usuario WHERE nombre = '".$user."' and ip = '$ip' and sesion_id = '$session' ;") == TRUE){
		escribir("login", "Cerró Sesión: ".$_SESSION['u']." ".$_SESSION['nombre']." ". $session . " ldap");
	}else{
		escribir("login", "No pudo Sesión: (No existe esta sesión) ".$_SESSION['u']." ".$_SESSION['nombre']." ". $session . " ldap");
	}	
}
	
//escribir("login", "Cerró Sessión ".$_SESSION['u']." ".$_SESSION['nombre']);
$_SESSION['u'] = null;
$_SESSION['nombre'] = null;
$_SESSION['ip'] = null;

session_unset();
session_destroy();
echo "http://$host/ExtraccionData/index2.php";
?>