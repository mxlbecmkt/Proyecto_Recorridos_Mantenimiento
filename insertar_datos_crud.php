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

  $numero_post = count($_POST);
  $opcion = array_pop($_POST);

  switch ($opcion){
    case 1:
      $sql = "INSERT INTO `tipo_lectura`(`tipo_lec_nombre`) VALUES (?)";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$_POST['tipo_lectura']]);
      break;
    case 2:
      $sql = "INSERT INTO `tipo_servicio`(`tipo_ser_nombre`) VALUES (?)";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$_POST['tipo_servicio']]);
      break;
    case 3:
      if($_POST['subestacion'] == ""){
        $sql = "INSERT INTO `servicios`(`ser_tipo_ser_id`, `ser_status`, `ser_medidor`, `ser_ubicacion`) 
        VALUES (?,?,?,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$_POST['tipoServicio'],$_POST['estatus'],$_POST['medidor'],$_POST['ubicacion']]);
      } else{
        $sql = "INSERT INTO `servicios`(`ser_tipo_ser_id`, `ser_status`, `ser_medidor`, `ser_ubicacion`, `ser_subestacion`) 
        VALUES (?,?,?,?,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$_POST['tipoServicio'],$_POST['estatus'],$_POST['medidor'],$_POST['ubicacion'],$_POST['subestacion']]);
      }

      $id_servicio = $conexion->lastInsertId();

      $ruta_servidor = "./";
      $carpeta_galeria = $ruta_servidor . 'assets/galeria/' . $id_servicio;

      if (!file_exists($carpeta_galeria)) {
        mkdir($carpeta_galeria, 0666, true);
        /* chown($carpeta_galeria, 'ubuntu');
        chmod($carpeta_galeria, 0666); */
      }
      break;
  }

  echo "<script>window.location='crud_administrador.php';</script>";
?>