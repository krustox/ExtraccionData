<?php
function LeerDatosDB($conn_string,$query){
	$conn_resource = db2_connect($conn_string, '', '');
	if ($conn_resource) {

		$resp = db2_prepare($conn_resource, $query);
		if($resp){
			$result = db2_exec($conn_resource, $query);
			if ($result) {
				$data = array();
				 $i=0;
				while ($row = db2_fetch_array($result)) {
					$length = sizeof($row);
					$j=0;
					$data[$i] = array();
					while ( $length > 0){
						$length = $length - 1;
					 	$data[$i][$j]= $row[$j];
						$j = $j+1;
					}
					$i=$i+1;
				}
			}else{
				echo db2_stmt_errormsg();
			}
			db2_close($conn_resource);
		return $data;
		}
	}
}

?>
