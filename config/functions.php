<?php

$bd_config= array(
	'basedatos' =>'pad',
	'usuario' => 'padrol',
	'pass' => 'vapro450',
	);

function conexion($bd_config){
	try {
		//$conexion = new PDO('mysql:host=localhost;dbname='.$bd_config['basedatos'], $bd_config['usuario'], $bd_config['pass']);
		$conexion = new PDO('mysql:host=localhost;dbname='."registro_servicios", "root");
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conexion;
	} catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>";
        die();
		//return false;
    }
}

function conexion2($bd_config){
	try {
		//$conexion = new PDO('mysql:host=localhost;dbname='.$bd_config['basedatos'], $bd_config['usuario'], $bd_config['pass']);
		$conexion = new PDO('mysql:host=localhost;dbname='."bd_usuarios", "root");
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conexion;
	} catch (PDOException $e) {
			echo "Error!: " . $e->getMessage() . "<br/>";
			die();
	//return false;
}
}

function limpiarDatos($datos){
    $datos = trim($datos);
    $datos = stripcslashes($datos);
    $datos = htmlspecialchars($datos);
    $datos = filter_var($datos, FILTER_SANITIZE_STRING);
    return $datos;
}

?>