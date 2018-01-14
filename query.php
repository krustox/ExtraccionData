<?php 

session_start();
verify($_SESSION['u'], session_id(), getRealIP(),$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host);
if(isset($_SESSION['u'])){
	
$cpu="";$memoria="";$disco="";$ecol="";$concu="";$servidor="";$trescinco="";$pordia="";$fechai="";$fechaf="";$linux="";
$estdb="";$estserv="";$estsql="";$errlog="";$seswas="";$estwas="";$estapache="";
$estbroker="";$conbroker="";$estmq="";$profcolas="";$heap="";$jvm="";$discoio="";
$fecha="";$ping="";$fechax="";
if(isset($_POST['fecha'])){$fecha = $_POST['fecha'];}
if(isset($_POST['cpu'])){$cpu = $_POST['cpu'];}
if(isset($_POST['memoria'])){$memoria = $_POST['memoria'];}
if(isset($_POST['disco'])){$disco = $_POST['disco'];}
if(isset($_POST['ecol'])){$ecol = $_POST['ecol'];}
if(isset($_POST['concu'])){$concu = $_POST['concu'];}
if(isset($_POST['servidor'])){$servidor = $_POST['servidor'];}
if(isset($_POST['linux'])){$linux = $_POST['linux'];}
if(isset($_POST['trescinco'])){$trescinco = $_POST['trescinco'];}
if(isset($_POST['pordia'])){$pordia = $_POST['pordia'];}
if(isset($_POST['fechai'])){$fechai = $_POST['fechai'];}
if(isset($_POST['fechaf'])){$fechaf = $_POST['fechaf'];}
if(isset($_POST['bdserv'])){$estserv = $_POST['bdserv'];}
if(isset($_POST['bdstatus'])){$estdb = $_POST['bdstatus'];}
if(isset($_POST['bdsql'])){$estsql = $_POST['bdsql'];}
if(isset($_POST['bderror'])){$errlog = $_POST['bderror'];}
if(isset($_POST['wassesiones'])){$seswas = $_POST['wassesiones'];}
if(isset($_POST['wasstatus'])){$estwas = $_POST['wasstatus'];}
if(isset($_POST['apachestatus'])){$estapache = $_POST['apachestatus'];}
if(isset($_POST['brokerstatus'])){$estbroker = $_POST['brokerstatus'];}
if(isset($_POST['brokermq'])){$conbroker = $_POST['brokermq'];}
if(isset($_POST['mqstatus'])){$estmq = $_POST['mqstatus'];}
if(isset($_POST['mqcolas'])){$profcolas = $_POST['mqcolas'];}
if(isset($_POST['heapusado'])){$heap = $_POST['heapusado'];}
if(isset($_POST['wasjvm'])){$jvm = $_POST['wasjvm'];}
if(isset($_POST['discoio'])){$discoio = $_POST['discoio'];}
if(isset($_POST['ping'])){$ping = $_POST['ping'];}
if(isset($_POST['fechax'])){$fechax = $_POST['fechax'];}

$now = date("Y-m-d H:i:s");
IniciarProceso($_SESSION['u'],$servidor."]".$linux ."]".$trescinco."]".$fechai."]".$fechaf,$now,$fechax,$dbhost,$dbusuario,$dbpassword,$db,$dbport,$host);

$directorio = opendir("./Data"); //ruta actual
while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
	if (strpos($archivo,".xlsx") != false)//verificamos si es o no un directorio
    {
    	//echo "La última modificación de $archivo fue: " . date ("F d Y H:i:s.", filemtime("Data/".$archivo));
    	$filelastmodified = filemtime("Data/".$archivo);
		 if ( ((time() - $filelastmodified ) > 7*24*3600) || (str_replace(".xlsx", "", explode("_",$archivo)[2]))== "" ){
         	unlink("Data/".$archivo);
         }
	}
}

$query_cpu = "";
$query_memoria = "";
$query_disco = "";
$query_cpulz = "";
$query_memorialz = "";
$query_discolz = "";

$query_ecol = "";
$query_concu = "";

$query_estserv = "";
$query_estdb = "";
$query_estsql = "";
$query_errlog = "";
$query_seswas = "";
$query_estwas = "";
$query_estapache = "";
$query_estbroker = "";
$query_conbroker = "";
$query_estmq = "";
$query_profcolas = "";
$query_heap = "";
$query_jvm = "";
$query_discoio = "";

$query_ping = "";

$time = "";
$servidores = "";//Primary::NT y estado servicio
$servidores_q="";//Q7
$servidores_bd="";//sin nada windows
$servidores_linux = ""; //Linux LZ
$servidores_wasjvmheap="";//sin nada Linux
$servidores_brokermq = "";//banco.bestado.cl Linux
if($linux != ""){
	$serl = explode(",", $linux);
	$serl_len = sizeof($serl);
	while ($serl_len > 0){
		$serl_len = $serl_len - 1;
		$serl[$serl_len] = str_replace(":LZ", "", $serl[$serl_len]);
		$serl[$serl_len] = $serl[$serl_len].trim();
		$up = strtoupper($serl[$serl_len]);
		$low = strtolower($serl[$serl_len]);
		$servidores_linux = $servidores_linux . "'$up:LZ','$low:LZ',";
		$servidores_wasjvmheap = $servidores_wasjvmheap . "'$up','$low',";
		$servidores_brokermq = $servidores_brokermq . "'$up.banco.bestado.cl','$low.banco.bestado.cl',";
	}
	$servidores_linux = substr($servidores_linux,0,-1);
	$servidores_brokermq = substr($servidores_brokermq, 0,-1);
	$servidores_wasjvmheap = substr($servidores_wasjvmheap, 0,-1);
}
if($servidor != ""){
	$servidor = strtoupper($servidor);
	$ser = explode(",", $servidor);
	$ser_len = sizeof($ser);
	while ($ser_len > 0){
		$ser_len = $ser_len - 1;
		$ser[$ser_len] = str_replace(":NT", "", $ser[$ser_len]);
		$ser[$ser_len] = str_replace("Primary:", "", $ser[$ser_len]);
		$ser[$ser_len] = str_replace(":Q7", "", $ser[$ser_len]);
		$ser[$ser_len] = trim($ser[$ser_len]);
		$servidores = $servidores . "'Primary:$ser[$ser_len]:NT',";
		$servidores_q = $servidores_q . "'$ser[$ser_len]:Q7',";
		$servidores_bd = $servidores_bd . "'$ser[$ser_len]',";
	}
	$servidores = substr($servidores,0,-1);
	$servidores_q = substr($servidores_q, 0,-1);
	$servidores_bd = substr($servidores_bd, 0,-1);
}

if ($trescinco != ""){
	$time = "> current timestamp -35 days ";
}else{
	if($fechai != ""){
		$time = "BETWEEN '$fechai' AND '$fechaf' ";
	}else{
		$time = "= '$fechaf' ";
	}
}

if($pordia != ""){
	if($linux != ""){
		if($disco != ""){
			$query_discolz = "select \"System_Name\", \"Mount_Point\",DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\")) AS DIA , AVG(\"Disk_Used_Percent\") AS  AVG_Disk_Used_Percent  
			FROM ITMUSER.\"KLZ_Disk\" where \"System_Name\" in 
			($servidores_linux)
				and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time  GROUP BY \"System_Name\", \"Mount_Point\",DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\"));";
		}
		if($memoria != ""){
			$query_memorialz = " select \"System_Name\", DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\")) AS DIA , AVG(\"Total_Memory_Free_Pct\") as AVG_Total_Memory_Free_Pct   
			from ITMUSER.\"KLZ_VM_Stats\" where \"System_Name\" in 
			($servidores_linux) 
			and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time GROUP BY \"System_Name\", DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\"));";
		}
		if($cpu != ""){
			$query_cpulz = "select \"System_Name\", DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\")) AS DIA , AVG(\"Busy_CPU\")  as  AVG_Busy_CPU 
			from ITMUSER.\"KLZ_CPU\" where \"System_Name\" in 
			($servidores_linux)
			and \"CPU_ID\" = -1 and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time GROUP BY \"System_Name\", DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\"));";
		}
	}
	if($servidor != ""){
		if($disco != ""){
			$query_disco = "SELECT \"Server_Name\",\"Disk_Name\",DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\")) AS DIA , AVG(\"%_Used\") as AVG_Pct_Used  
			FROM ITMUSER.\"NT_Logical_Disk\" Where \"Server_Name\" in 
			($servidores) 
			and \"Disk_Name\" != '_Total' and \"Disk_Name\" not like '%Hard%'  and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time GROUP BY  \"Server_Name\",\"Disk_Name\",DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\"));";
		}
		if($memoria != ""){
			$query_memoria = "SELECT \"Server_Name\", DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\")) AS DIA , AVG(\"Available_Usage_Percentage\") as AVG_Available_Usage_Percentage 
			FROM ITMUSER.\"NT_Memory_64\" Where \"Server_Name\" in 
			($servidores) 
			and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time GROUP BY \"Server_Name\",DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\"));";
		}
		if($cpu != ""){
			$query_cpu = "SELECT \"Server_Name\", DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\")) AS DIA ,  AVG(\"%_Processor_Time\") AS AVG_PCT_PROCESSOR_TIME  
			FROM ITMUSER.\"NT_Processor\"  WHERE \"Server_Name\" IN 
			($servidores)
			AND ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time  GROUP BY \"Server_Name\",DATE(ITMUSER.ITMTIMESTAMP(\"Timestamp\"));";
		}
	}
}else{
	if($linux != ""){
	//LINUX
		if($disco != ""){
			$query_discolz = "select \"System_Name\", \"Mount_Point\",ITMUSER.ITMTIMESTAMP(\"Timestamp\") as \"Fecha\", (\"Disk_Used_Percent\")  
			FROM ITMUSER.\"KLZ_Disk\" where \"System_Name\" in 
			($servidores_linux)
 			and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time ;";
		}
		if($memoria != ""){
			$query_memorialz = "select \"System_Name\", ITMUSER.ITMTIMESTAMP(\"Timestamp\") as \"Fecha\", (\"Memory_Used_Pct\"), \"Memory_Free_Pct\" ,\"Net_Memory_Used\" ,\"Total_Memory_Free\"   
			from ITMUSER.\"KLZ_VM_Stats\" where \"System_Name\" in 
			($servidores_linux) 
			and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time ;";
		}
		if($cpu != ""){
			$query_cpulz = "select \"System_Name\", ITMUSER.ITMTIMESTAMP(\"Timestamp\") as \"Fecha\", (\"Busy_CPU\") 
			from ITMUSER.\"KLZ_CPU\" where \"System_Name\" in 
			($servidores_linux)
			and \"CPU_ID\" = -1 and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time ;";
		}
		if($estwas != ""){
			$query_estwas = "SELECT ITMUSER.ITMTIMESTAMP(\"Timestamp\") AS Fecha,\"Node_Name\",\"Server_Name\"  
			,\"Cluster_Name\",\"WAS_Node_Name\",\"WAS_Cell_Name\", case \"Status\" when 1 then 'Connected' when 0 then 'Disconnected' when 2 then 'TimedOut' when 100 then 'Unconfigured' else to_char(\"Status\") end as Status
			FROM ITMUSER.\"Application_Server_Status\" 
			WHERE  \"Node_Name\" in ($servidores_wasjvmheap)
			and   ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time ORDER BY ITMUSER.ITMTIMESTAMP(\"Timestamp\");";
		}
		if($seswas != ""){
			$query_seswas = "SELECT \"Origin_Node\",\"Server_Name\", \"AVG_LIVSES\", \"Enterprise_Application_Name\", ITMUSER.ITMTIMESTAMP(\"Timestamp\")  as Fecha  FROM \"ITMUSER\".\"Servlet_Sessions\"
			where \"Node_Name\"  in ($servidores_wasjvmheap) 
			and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time
			ORDER BY ITMUSER.ITMTIMESTAMP(\"Timestamp\");";
		}
		if($estapache != ""){
			$query_estapache = "SELECT ITMUSER.ITMTIMESTAMP(\"Timestamp\") as Fecha,\"Node_Name\",\"Web_Server_Name\", case \"Status\" when 0 then 'Stopped' when 1 then
			'Running' when 2 then 'Error' else to_char(\"Status\") end as Status FROM \"ITMUSER\".\"Apache_Web_Server\" where \"Node_Name\" 
			in ($servidores_wasjvmheap) and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time ORDER BY ITMUSER.ITMTIMESTAMP(\"Timestamp\");";
		}
		if($heap != ""){
			$query_heap = "SELECT  \"Node_Name\", \"Server_Name\",\"Heap_Used_Percent\",  ITMUSER.ITMTIMESTAMP(\"Sample_Date_and_Time\") AS FECHA
			FROM ITMUSER.\"Garbage_Collection_Analysis\"
			WHERE \"Node_Name\" IN ($servidores_wasjvmheap) and
			ITMUSER.ITMTIMESTAMP(\"Sample_Date_and_Time\") $time
			ORDER BY ITMUSER.ITMTIMESTAMP(\"Sample_Date_and_Time\") ;";
		}
		if($jvm != ""){
			$query_jvm = "SELECT ITMUSER.ITMTIMESTAMP(\"Timestamp\") as \"Fecha\", \"Node_Name\", \"Server_Name\", \"JVM_Memory_Used\", \"JVM_Memory_Total\",\"WAS_Node_Name\"  FROM \"ITMUSER\".\"Application_Server\"
			where \"Node_Name\" in ($servidores_wasjvmheap)
			and  ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time ;";
		}
		if($discoio != ""){
			$query_discoio = "SELECT ITMUSER.ITMTIMESTAMP(\"Timestamp\") as \"Fecha\",  \"System_Name\",  \"Blk_Rds_per_sec\", \"Blk_wrtn_per_sec\"  from \"KLZ_Disk_IO\" 
			where \"System_Name\" in ($servidores_linux)
			and  ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time ;";
		}
		if($estbroker != ""){
			$query_estbroker = "SELECT ITMUSER.ITMTIMESTAMP(\"Start_Date_and_Time\") as \"Fecha\", \"System_Name\", \"Origin_Node\", \"Broker\", decode( \"Broker_Status\" 
			, 1 , 'Started' ,2,'Stopped',3,'Running_in_Active',4,'Running_in_Standby',to_char(\"Broker_Status\")) as \"Broker_Status\"
			, \"Queue_Manager\", 
			case \"BRKR_QMSTA\" when 1 then 'Connected'  when 2 then 'Not Connected' when  3 then 'Standby' else to_char(\"BRKR_QMSTA\") end as Qmgr_Connected_Status FROM \"ITMUSER\".\"Broker_Information\"
			where \"System_Name\" in ($servidores_brokermq) 
			and ITMUSER.ITMTIMESTAMP(\"Start_Date_and_Time\")  $time;";
		}
		if($conbroker != ""){
			$query_conbroker = "SELECT  ITMUSER.ITMTIMESTAMP(\"WRITETIME\") as \"Fecha\",  \"Host_Name\",\"Origin_Node\", \"MQ_Manager_Name\", decode( \"MQ_Manager_Status\",1,'Starting',2,'Running',3,'Quiescing',4,'Stopping',5,'Standby',0,'Stopped',to_char(\"MQ_Manager_Status\")) as \"MQ_Manager_Status\"  
			FROM \"ITMUSER\".\"Current_Queue_Manager_Status\" 
			where \"Host_Name\" in ($servidores_brokermq) and 
			ITMUSER.ITMTIMESTAMP(\"WRITETIME\") $time ;";
		}
		if($estmq != ""){
			$query_estmq = "SELECT ITMUSER.ITMTIMESTAMP(\"WRITETIME\") AS \"Fecha\", \"Origin_Node\", \"MQ_Manager_Name\", \"Host_Name\"
			, \"Queue_Name\", \"Current_Depth\" FROM \"ITMUSER\".\"Queue_Status\"  
			where \"Host_Name\" in ($servidores_brokermq)
			and \"Queue_Name\" not like  '%SYSTEM%' and ITMUSER.ITMTIMESTAMP(\"WRITETIME\")  $time;";
		}
		if($profcolas != ""){
			$query_profcolas = "SELECT  ITMTIMESTAMP(\"WRITETIME\") as \"Fecha\", \"MQ_Manager_Name\", \"Queue_Name\", \"Host_Name\", \"Current_Depth\" FROM \"ITMUSER\".\"Queue_Data\" 
			where \"Host_Name\" in ($servidores_brokermq) and 
			ITMUSER.ITMTIMESTAMP(\"WRITETIME\") $time ;";
		}
		if($ping != ""){
			$query_ping = "SELECT  \"Host\" AS \"IP_Address\",\"ServiceLevelString\" as \"Ping\", ITMUSER.ITMTIMESTAMP(\"Timestamp\") as \"Fecha\", \"Profile\"                              
			FROM ITMUSER.KIS_ICMP
			WHERE ITMUSER.ITMTIMESTAMP(\"WRITETIME\") $time 
			AND  \"TMZDIFF\" = '10800' AND \"Node\" = 'lnxp-hubtems:IS'
			AND UPPER(\"Description\") IN ($servidores_wasjvmheap);";
		}
	}
	if($servidor != ""){
	//WINDOWS
		if($disco != ""){
			$query_disco = "Select \"Server_Name\", \"Disk_Name\",  ITMUSER.ITMTIMESTAMP(\"Timestamp\") AS FECHA , \"%_Used\" AS \"%_Disk_Used\"
			FROM ITMUSER.\"NT_Logical_Disk\" Where \"Server_Name\" in 
			($servidores) 
			and \"Disk_Name\" <> '_Total' and \"Disk_Name\" not like '%Hard%'  and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time ORDER BY ITMUSER.ITMTIMESTAMP(\"Timestamp\") ASC;";
		}
		if($memoria != ""){
			$query_memoria = "Select \"Server_Name\", \"Available_kBytes\",\"Memory_Usage_Percentage\", \"Total_Working_Set_kBytes\",\"Total_Memory_kBytes\",\"Available_Usage_Percentage\" AS \"Available_Usage_Percentage\",  \"Cache_Usage_Percentage\" AS \"%_Cache_Usage\", ITMUSER.ITMTIMESTAMP(\"Timestamp\") AS FECHA
			FROM ITMUSER.\"NT_Memory_64\" Where \"Server_Name\" in 
			($servidores) 
			and ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time ORDER BY ITMUSER.ITMTIMESTAMP(\"Timestamp\") ASC;";
		}
		if($cpu != ""){
			$query_cpu = "Select \"Server_Name\", \"%_Privileged_Time\" AS \"%_Priv_Time\", \"%_Processor_Time\" AS \"%_Proc_Time\",  \"%_User_Time\" AS \"%_Usr_Time\", \"Processor\", ITMUSER.ITMTIMESTAMP(\"Timestamp\") AS FECHA  
			FROM ITMUSER.\"NT_Processor\"  WHERE \"Processor\" = '_Total' and \"Server_Name\" IN 
			($servidores)
			AND ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time  ORDER BY ITMUSER.ITMTIMESTAMP(\"Timestamp\") ASC;";
		}
		if($ecol != ""){
			$query_ecol = "SELECT \"Node\", \"Requests_Queued\", ITMUSER.ITMTIMESTAMP(\"Timestamp\")
  			FROM ITMUSER.KQ7_ACTIVE_SERVER_PAGES
  			WHERE ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time
    		AND \"Node\" IN ($servidores_q)
  			ORDER BY ITMUSER.ITMTIMESTAMP(\"Timestamp\") ASC;";
		}
		if($concu != ""){
			$query_concu = "SELECT \"Node\", \"Current_Connections\", \"Name\", ITMUSER.ITMTIMESTAMP(\"Timestamp\")
  			FROM ITMUSER.KQ7_WEB_SERVICE
  			WHERE \"Name\" = '_Total'
    		AND \"Node\" IN ($servidores_q)
    		AND ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time ORDER BY ITMUSER.ITMTIMESTAMP(\"Timestamp\") ASC;";
		}
		if($estserv != ""){
			$query_estserv = "Select \"Server_Name\", \"Service_Name\", \"Current_State\", ITMUSER.ITMTIMESTAMP(\"Timestamp\") as \"Fecha\" from 
			ITMUSER.\"NT_Services\" WHERE  \"Server_Name\" IN 
			( $servidores )
			AND  ITMUSER.ITMTIMESTAMP(\"Timestamp\") $time    
			and \"Service_Name\" in ('SQLSERVERAGENT','MSSQLSERVER')
			ORDER BY ITMUSER.ITMTIMESTAMP(\"Timestamp\") ASC;";
		}
		if($estdb != ""){
			$query_estdb = "Select  \"Server\", \"Database_Name\", \"Database_Status\",ITMUSER.ITMTIMESTAMP(\"Hub_Timestamp\") as \"Fecha\" from  ITMUSER.\"MS_SQL_Database_Detail\" 
			WHERE  \"Server\" in ($servidores_bd) 
			AND ITMUSER.ITMTIMESTAMP(\"Hub_Timestamp\") $time ;";
		}
		if($estsql != ""){
			$query_estsql = "Select \"Originnode\",\"Host_Name\",ITMUSER.ITMTIMESTAMP(\"Hub_Timestamp\") AS FECHA, \"Server_Status\" 
			FROM ITMUSER.\"MS_SQL_Server_Summary\" 
			WHERE \"Host_Name\" in  ($servidores_bd) AND 
			ITMUSER.ITMTIMESTAMP(\"Hub_Timestamp\") $time  order by ITMUSER.ITMTIMESTAMP(\"Hub_Timestamp\") asc;";
		}
		if($errlog != ""){
			$query_errlog = "Select \"Originnode\", \"Host_Name\", \"Error_ID\", \"Severity_Level\", \"Message_Text\",ITMUSER.ITMTIMESTAMP(\"Hub_Timestamp\") AS FECHA
			from  ITMUSER.\"MS_SQL_Problem_Detail\" where	
			\"Host_Name\" in ($servidores_bd) AND 
			ITMUSER.ITMTIMESTAMP(\"Hub_Timestamp\") $time 
			order by ITMUSER.ITMTIMESTAMP(\"Hub_Timestamp\")	ASC;";
		}
		if($ping != ""){
			$query_ping = "SELECT  \"Host\" AS \"IP_Address\",\"ServiceLevelString\" as \"Ping\", ITMUSER.ITMTIMESTAMP(\"Timestamp\") as \"Fecha\", \"Profile\"                              
			FROM ITMUSER.KIS_ICMP
			WHERE ITMUSER.ITMTIMESTAMP(\"WRITETIME\") $time 
			AND  \"TMZDIFF\" = '10800' AND \"Node\" = 'lnxp-hubtems:IS'
			AND UPPER(\"Description\") IN ($servidores_bd);";
		}
	}
}

}else{
	include('Config/connection.php');
	header("Location: http://$host/ExtraccionData/index2.php");
}
?>