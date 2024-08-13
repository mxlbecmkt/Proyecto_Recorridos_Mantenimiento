<?php
  require 'config/functions.php';

  $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
    }

  $conexion2 = conexion2($bd_config);
    if(!$conexion2){
        echo 'Fatal Error!';
    }

  function consultaEmpleado($numEmpleado, $conexion){
    $sql = "SELECT * FROM usuario WHERE num_empleado=$numEmpleado";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $empleado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(empty($empleado)){
      return FALSE;
    }

    return TRUE;
  }

  $num_registro = array_shift($_POST);
  $num_empleado = array_shift($_POST);

  $empleado_existe = consultaEmpleado($num_empleado,$conexion2);
  
  if($empleado_existe){
    $sql = "UPDATE registros SET reg_num_empleado=$num_empleado WHERE reg_num=$num_registro";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
  }

  $numero_post = count($_POST);

  for($i=0;$i<$numero_post/2;$i++){
    $sql = "UPDATE lecturas SET lec_dato={$_POST[$i]} WHERE lec_id={$_POST['id' . $i]}";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
  }

  echo "<script>window.location='crud_administrador.php';</script>";
?>