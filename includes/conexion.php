<?php
	function conectarBD(){
	
		$usuario = "root";
		$password = "";
		$dsn = "mysql:host=localhost;dbname=portfolio";

		try {
    	  	$conexion = new PDO($dsn, $usuario, $password);
		   return $conexion;  			
		} catch (PDOException $e) {
			echo 'Error de conexión con la base de datos: ' . $e->getMessage();
		}	
	}

?>