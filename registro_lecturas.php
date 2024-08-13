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

  $tipo_servicio = $_POST['tipo_servicio'];
  $servicio = $_POST['servicio'];

  $sql = "SELECT tipo_lectura.tipo_lec_id, tipo_lectura.tipo_lec_nombre, tipo_servicio.tipo_ser_nombre
    FROM cuestionarios JOIN tipo_servicio 
    ON cuestionarios.cue_tipo_ser_id=tipo_servicio.tipo_ser_id 
    JOIN tipo_lectura
    ON cuestionarios.cue_tipo_lec_id=tipo_lectura.tipo_lec_id
    WHERE cuestionarios.cue_tipo_ser_id=$tipo_servicio";
    
  $stmt = $conexion->prepare($sql);
  $stmt->execute();

  $tipos_lectura = $stmt->fetchAll(PDO::FETCH_ASSOC);

  include("views/registro_lecturas.view.php");
?>