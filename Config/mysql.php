<?php 
$dbhost ="localhost";
$dbusuario ="root";
$dbpassword ="";
$dbport = 3306;
$db="user_extracciondata";

function verify($user,$sesion,$ip,$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host){
	$user = str_replace("ldap ", "", $user);
	$conecta = new mysqli($dbhost, $dbusuario, $dbpassword,$db,$dbport);
	if($conecta->connect_error){echo $conecta->connect_error;}else{
		$result = $conecta->query("SELECT count(*) FROM usuario WHERE nombre = '$user';");
		$row = $result->fetch_array(MYSQLI_NUM);
		if($row[0]>1){
			if($conecta->query("DELETE FROM usuario WHERE nombre = '$user' ;") == TRUE){
				escribir("login", "Cerró Sesión: (TODAS) ".$_SESSION['u']." ".$_SESSION['nombre']." ". $session . " ldap");
				$_SESSION['u'] = null;
				$_SESSION['nombre'] = null;
				$_SESSION['ip'] = null;
				session_unset();
				session_destroy();
				header("Location: http://$host/ExtraccionData/index2.php");
			}else{
				escribir("mysqlerror",$conecta->error);
			}
		}else if($row[0]<1){
			$_SESSION['u'] = null;
			$_SESSION['nombre'] = null;
			$_SESSION['ip'] = null;
			session_unset();
			session_destroy();
			header("Location: http://$host/ExtraccionData/index2.php");
		}else if($row[0]==1){
			$result = $conecta->query("SELECT sesion_id FROM usuario WHERE nombre = '$user';");
			$row = $result->fetch_array(MYSQLI_NUM);
			if($row[0] != $sesion){
				$_SESSION['u'] = null;
				$_SESSION['nombre'] = null;
				$_SESSION['ip'] = null;
				session_unset();
				session_destroy();
				header("Location: http://$host/ExtraccionData/index2.php");
			}
		}
	}
}

function crearProceso($user,$server,$fecha,$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host){
	$user = explode(str_replace(" ", "","\ "),$_SESSION['nombre'])[1];
	$conecta = new mysqli($dbhost, $dbusuario,$dbpassword,$db,$dbport);
	if($conecta->connect_error){
		escribir("error",$conecta->connect_error);
	}else{
		if($conecta->query("INSERT INTO procesos (usuario,servidores,estado,fechacreacion) VALUES ('$user','$server','C','$fecha')") == TRUE){
			escribir("Procesos", "Proceso Creado:" . $user." ". $server);
		}else{
			escribir("error",$conecta->connect_error);
		}
	}
	$conecta->close();
}
function IniciarProceso($user,$server,$fecha,$fechax,$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host){
	$user = explode(str_replace(" ", "","\ "),$_SESSION['nombre'])[1];
	$conecta = new mysqli($dbhost, $dbusuario, $dbpassword,$db,$dbport);
	if($conecta->connect_error){
		escribir("error",$conecta->connect_error);
	}else{
		if($conecta->query("UPDATE procesos SET estado='I',fechainicio='$fecha' WHERE usuario='$user' AND servidores='$server' AND estado = 'C' AND fechacreacion='$fechax'") == TRUE){
			escribir("Procesos", "Proceso Iniciado:" . $user." ". $server);
		}else{
			escribir("error",$conecta->error);
		}
	}
	escribir("Procesos", "Proceso Iniciado:" . $user." ". $server);
	$conecta->close();
}

function FinProceso($user,$server,$fecha,$inicio,$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host){
	$user = explode(str_replace(" ", "","\ "),$_SESSION['nombre'])[1];
	$conecta = new mysqli($dbhost, $dbusuario, $dbpassword,$db,$dbport);
	if($conecta->connect_error){
		escribir("error",$conecta->connect_error);
	}else{
		if($conecta->query("UPDATE procesos SET estado='F',fechafin='$fecha' WHERE usuario='$user' AND servidores='$server' AND estado = 'I' AND fechacreacion='$inicio'") == TRUE){
			escribir("Procesos", "Proceso Finalizado:" . $user." ". $server);
		}else{
			escribir("error",$conecta->connect_error);
		}
	}
	$conecta->close();
}

?>