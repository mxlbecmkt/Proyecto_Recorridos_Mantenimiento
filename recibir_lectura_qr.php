<?php
  require 'config/functions.php';

  $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
    }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['info_servicio'])) {
    $info_servicio = $_POST['info_servicio'];
    $valores = explode("-",$info_servicio);

    $sql = "SELECT * FROM servicios JOIN tipo_servicio 
      ON servicios.ser_tipo_ser_id=tipo_servicio.tipo_ser_id
      WHERE ser_id=$valores[1]";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>Confirmar Lectura QR</h1>
    <form action='../registro_lecturas.php' method='post'>
      <input type='hidden' value='$valores[0]' name='tipo_servicio'>
      <label>Tipo de Servicio: {$servicios[0]['tipo_ser_nombre']}</label></br></br>
      <input type='hidden' value='$valores[1]' name='servicio'>
      <label>Servicio: {$servicios[0]['ser_ubicacion']}</label></br></br>
      <input type='submit' value='Confirmar selección'></br></br>
    </form>";

    exit;
  }
?>