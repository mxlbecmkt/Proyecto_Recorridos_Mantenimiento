<?php
  require 'config/functions.php';

  session_start();

  $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
    }

  date_default_timezone_set('America/Mexico_City');

  for($i=0;$i<29;$i++){
    $sql1 = "INSERT INTO `registros`(`reg_ser_id`, `reg_num_empleado`, `reg_fecha_hora`, `reg_hora`, `reg_mes`, `reg_year`) 
    VALUES (?,?,?,?,?,?)";
    $stmt = $conexion->prepare($sql1);
    $stmt->execute([5,88889,'2024-07-'. $i . ' ' . date('H:i:s'),date('H:i:s'),date('m'),date('Y')]);
    $num_registro = $conexion->lastInsertId();

    $sql2 = "INSERT INTO `lecturas`(`lec_reg_num`, `lec_tipo_lec_id`, `lec_dato`) VALUES (?,?,?)";
    $stmt = $conexion->prepare($sql2);
    $stmt->execute([$num_registro,12,rand(19,31)]);

    $sql3 = "INSERT INTO `lecturas`(`lec_reg_num`, `lec_tipo_lec_id`, `lec_dato`) VALUES (?,?,?)";
    $stmt = $conexion->prepare($sql3);
    $stmt->execute([$num_registro,13,rand(20,24)]);
  }
?>