<?php
  require 'config/functions.php';

  $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
    }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['datos_accion'])) {
    $datos_accion = $_POST['datos_accion'];

    $valores = explode("-", $datos_accion);

    $sql = "SELECT * FROM cuestionarios WHERE cue_tipo_ser_id=$valores[0] AND cue_tipo_lec_id=$valores[1]";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $lecturasCuestionario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(empty($lecturasCuestionario)){
      $sql = "INSERT INTO `cuestionarios`(`cue_tipo_ser_id`, `cue_tipo_lec_id`) VALUES (?,?)";
      $stmt = $conexion->prepare($sql);
      $stmt->execute($valores);
    }

    exit;
  }
?>