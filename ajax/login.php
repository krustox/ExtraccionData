<?php
include('../Config/connection.php');
include('../Config/mysql.php');
include('../Functions/Archivo.php');
include('../Functions/Function.php');
include('../Functions/ldap.php');

session_start();
$user = $_POST['user'];
$contra = $_POST['pass'];
if($contra == ""){
	$contra = "xxx   xxx";
}
if(substr($user, 0,5) != "banco" )
{
	$user = "banco\\".$user;
	//echo $user;
}

if($user == "banco\jfiguero" || $user == "banco\montivoli" || $user == "banco\cumana1" || $user == "banco\\rmejias" || $user == "banco\\rfadul" || $user == "banco\pgoffard" || $user == "banco\dpozo" || $user == "banco\maraya90" || $user == "banco\mvalle1" || $user == "banco\flisboa" || $user == "banco\scoyopae" || $user == "banco\\rjimen92"){

if(login($user, $contra)){
	$ip = getRealIP();
	$session = session_id();
	$conecta = new mysqli($dbhost, $dbusuario, $dbpassword,$db,$dbport);
	if($conecta->connect_error){
		escribir("mysqlerror", $conecta->connect_error);
	}else{
		$result = $conecta->query("SELECT count(*) FROM usuario WHERE nombre = '$user'");
		$row = $result->fetch_array(MYSQLI_NUM);
		if($row[0]>0){
			if($conecta->query("UPDATE usuario SET sesion_id = '$session',ip='$ip' WHERE nombre = '$user';") == TRUE)
			{
				escribir("login", "Inicio Sesión: (Cierra Sesion preexistente) " . $user." ". $session . " ldap");
			}else{
				 escribir("mysqlerror",$conecta->error);
			}	
		}else{
			if($conecta->query("INSERT INTO usuario (nombre,sesion_id,ip) VALUES ('$user','$session','$ip')") == TRUE)
				{
					escribir("login", "Inicio Sesión: (Sesion Nueva) " . $user." ". $session . " ldap");
				}else{
					escribir("mysqlerror",$conecta->error);
				}		
		}
	}
	$_SESSION['u'] = 'ldap '.$user;
	$_SESSION['nombre'] = $user;
	$_SESSION['ip'] = $ip;	
	header("Location: http://$host/ExtraccionData/index.php");
}else{
	//echo "Hay un error en la informacion del usuario";
	escribir("login_err", $user . " No pudo ingresar");
	header("Location: http://$host/ExtraccionData/index2.php?ok=0");
}
}else{
	//echo "Usuario no autorizado";
	escribir("login_err", $user . " Usuario no Autorizado");
	header("Location: http://$host/ExtraccionData/index2.php?ok=1");
}
?>