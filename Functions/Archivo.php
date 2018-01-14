<?php
	function escribir($nivel,$texto){
		$file = fopen($nivel.".txt", "a");
		fwrite($file, date("l jS \of F Y h:i:s A")." ".getRealIP(). ": ");
		fwrite($file, $texto . PHP_EOL);
		fclose($file);
	}
		function getRealIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return $_SERVER['REMOTE_ADDR'];
}
?>