<?php
include('Plugin/PHPExcel/Classes/PHPExcel.php');
include('Config/connection.php');
include('Config/mysql.php');
include('Functions/Function.php');
include('Functions/Archivo.php');
include('/query.php');
 /*
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');
ini_set('memory_limit',-1);
ignore_user_abort(TRUE);
set_time_limit(0);

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

$i=0;
$j=0;
$querys = [];
$nquerys = [];
$cquerys =[];

//Armar Encabezados Excel y nombres de solapa
if($query_disco != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_disco);$nquerys[$j]="Disco NT";
	$cquerys[$j] = ["Server Name","Disk Name","Fecha", "% Used"];
	$j = $j+1;
}
if($query_memoria != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_memoria);$nquerys[$j]="Memoria NT";
	if($pordia != ""){
		$cquerys[$j] = ["Server Name","Fecha","Available_Usage_Percentage"];
	}else{
		$cquerys[$j] = ["Server Name","Available kBytes","Memory Usage Percentage", "Total Working Set kBytes","Total Memory kBytes","Available Usage Percentage","% Cache Usage","Fecha"];
	}
	$j = $j+1;
}
if($query_cpu != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_cpu);$nquerys[$j]="CPU NT";
	if($pordia != ""){
		$cquerys[$j] = ["Server Name","DIA","AVG PCT PROCESSOR TIME"];
	}else{
		$cquerys[$j] = ["Server Name","% Privileged Time","% Processor Time","% User Time","Processor", "Fecha"];
	}
	$j = $j+1;
}
if($query_discolz != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_discolz);$nquerys[$j]="Disco LZ";
	$cquerys[$j] = ["System Name","Mount Point","Fecha", "Disk Used Percent"];
	$j = $j+1;
}
if($query_memorialz != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_memorialz);$nquerys[$j]="Memoria LZ";
	if($pordia != ""){
		$cquerys[$j] = ["System Name","Fecha","Total Memory Free Pct"];
	}else{
		$cquerys[$j] = ["System Name","Fecha","Memory Used Pct", "Memory Free Pct", "Total Memory Free"];
	}
	$j = $j+1;
}
if($query_cpulz != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_cpulz);$nquerys[$j]="CPU LZ";
	$cquerys[$j] = ["System Name","Fecha","Busy CPU"];
	$j = $j+1;
}
if($query_ecol != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_ecol);$nquerys[$j]="Encolados NT";
	$cquerys[$j] = ["Node","Requests Queued", "Fecha"];
	$j = $j+1;
}
if($query_concu != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_concu);$nquerys[$j]="Concurrentes NT";
	$cquerys[$j] = ["Node","Conexiones Concurrentes","Name", "Fecha"];
	$j = $j+1;
}
if($query_estserv != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_estserv);$nquerys[$j]="Estado Servicios";
	$cquerys[$j] = ["Server Name","Service Name","Current State","Fecha"];
	$j = $j+1;
}
if($query_estdb != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_estdb);$nquerys[$j]="Estado Bd";
	$cquerys[$j] = ["Server Name","Database Name","Database Status","Fecha"];
	$j = $j+1;
}
if($query_estsql != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_estsql);$nquerys[$j]="Estado SQLServer";
	$cquerys[$j] = ["Origin Node","Hostname","Fecha","Server Status"];
	$j = $j+1;
}
if($query_errlog != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_errlog);$nquerys[$j]="Error Log";
	$cquerys[$j] = ["Origin Node","Hostname","Error ID","Severity Level", "Message Text","Fecha"];
	$j = $j+1;
}
if($query_seswas != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_seswas);$nquerys[$j]="Sesiones Abiertas";
	$cquerys[$j] = ["Origin Node","Server Name","AVG Livses","Enterprise Application Name", "Fecha"];
	$j = $j+1;
}
if($query_estwas != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_estwas);$nquerys[$j]="Estado Was";
	$cquerys[$j] = ["Fecha","Node Name","Server Name","Cluster Name","Was Node Name","Was Cell Name","Status"];
	$j = $j+1;
}
if($query_estapache != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_estapache);$nquerys[$j]="Estado Apache";
	$cquerys[$j] = ["Fecha","Node Name","Web Server Name","Status"];
	$j = $j+1;
}
if($query_estbroker != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_estbroker);$nquerys[$j]="Estado Broker";
	$cquerys[$j] = ["Fecha","System Name","Origin Node","Broker","Broker Status","Queue Manager","Qmgr Connected Status"];
	$j = $j+1;
}
if($query_conbroker != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_conbroker);$nquerys[$j]="BrokerMQ";
	$cquerys[$j] = ["Fecha","Hostname","Origin Node","MQ Manager Name","MQ Manager Status"];
	$j = $j+1;
}
if($query_estmq != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_estmq);$nquerys[$j]="Estado MQ";
	$cquerys[$j] = ["Fecha","Origin Node","MQ Manager Name","Hostame","Queue Name","Current Depth"];
	$j = $j+1;
}
if($query_profcolas != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_profcolas);$nquerys[$j]="Profundidad Colas";
	$cquerys[$j] = ["Fecha","MQ Manager Name","Queue Name","Hostname","Current Depth"];
	$j = $j+1;
}
if($query_heap != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_heap);$nquerys[$j]="Heap";
	$cquerys[$j] = ["Node Name","Server Name","Heap Used Percent","Fecha"];
	$j = $j+1;
}
if($query_jvm != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_jvm);$nquerys[$j]="JVM";
	$cquerys[$j] = ["Fecha","Node Name","Server Name","JVM Memory Used","JVM Memory Total","Was Node Name"];
	$j = $j+1;
}
if($query_discoio != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_discoio);$nquerys[$j]="IO Disco";
	$cquerys[$j] = ["Fecha","System Name","Blk Rds per sec","Blk wrtn per sec"];
	$j = $j+1;
}
if($query_ping != ""){
	$querys[$j]=LeerDatosDB($conn_string, $query_ping);$nquerys[$j]="PING";
	$cquerys[$j] = ["IP","PING","Fecha","Profile"];
	$j = $j+1;
}

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("WiseVisionCorp"); 
//Creacion Archivo excel
while($i<$j){
	//Hoja
	$objPHPExcel->createSheet($i);
	$objPHPExcel->setActiveSheetIndex($i);
	$sheet = $objPHPExcel->getActiveSheet();
	$sheet->setTitle("$nquerys[$i]");
	$data = $querys[$i];
	$colname = $cquerys[$i];
	$coln = 0;
	$colname_len =sizeof($colname);
	//Colocacion de encabezado
	while ($coln < $colname_len) {
		$sheet->setCellValueByColumnAndRow($coln,1,$colname[$coln]);
		$coln = $coln +1;
	}
	$row=0;
	$row_len = sizeof($data);
	//Colocacion Data
	while ($row < $row_len){
		$column=0;
		$column_len = sizeof($data[$row]);
		while ($column < $column_len){
			$sheet->setCellValueByColumnAndRow($column,$row+2,$data[$row][$column]);
			$column = $column + 1;
		}
		$row = $row + 1;
	}
	$i=$i+1;
}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->removeSheetByIndex($j);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
$objWriter->save('Data/data_'. $fecha . '_'. explode(str_replace(" ", "","\ "),$_SESSION['nombre'])[1] . '.xlsx');
exit;
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                