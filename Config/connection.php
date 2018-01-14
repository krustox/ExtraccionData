<?php
$db_name = 'WAREHOUS'; 
$usr_name = 'ITMUser'; 
$password = 'tivolitivoli'; 
$hostname = 'VS2K8-MONBDBC01'; 
$port = 50000; 
$conn_string = "DRIVER={IBM DB2 ODBC DRIVER};DATABASE=$db_name;HOSTNAME=$hostname;PORT=$port;PROTOCOL=TCPIP;UID=$usr_name;PWD=$password;";
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');


?>