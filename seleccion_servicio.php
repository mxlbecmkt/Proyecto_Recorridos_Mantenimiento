<?php
  require 'config/functions.php';

  $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
    }

  /*$conexion2 = conexion2($bd_config);
  if(!$conexion2){
      echo 'Fatal Error!';
  }*/

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo_ser_id'])) {
    $tipo_servicio_id = $_POST['tipo_ser_id'];

    $sql = "SELECT * FROM servicios INNER JOIN tipo_servicio ON servicios.ser_tipo_ser_id=tipo_servicio.tipo_ser_id WHERE servicios.ser_tipo_ser_id=$tipo_servicio_id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($servicios as $servicio) {
        echo "<option value=\"{$servicio['ser_id']}\">{$servicio['ser_medidor']}</option>";
    }
    
    exit;
  }

  $stmt = $conexion->prepare("SELECT * FROM tipo_servicio");
  $stmt->execute();

  $tipos_servicio = $stmt->fetchAll(PDO::FETCH_ASSOC);

  include("views/seleccion_servicio.view.php");
?>