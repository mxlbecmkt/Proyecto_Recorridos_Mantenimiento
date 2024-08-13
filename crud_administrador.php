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

      $sql = "SELECT tipo_lectura.tipo_lec_id, tipo_lectura.tipo_lec_nombre, tipo_servicio.tipo_ser_nombre
      FROM cuestionarios JOIN tipo_servicio 
      ON cuestionarios.cue_tipo_ser_id=tipo_servicio.tipo_ser_id 
      JOIN tipo_lectura
      ON cuestionarios.cue_tipo_lec_id=tipo_lectura.tipo_lec_id
      WHERE cuestionarios.cue_tipo_ser_id=$tipo_servicio_id";
      
      $stmt = $conexion->prepare($sql);
      $stmt->execute();

      $tipos_lectura = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $cont = 0;

      foreach ($tipos_lectura as $tipo_lectura) {
        echo "<label for=$cont>{$tipo_lectura['tipo_lec_nombre']}: </label>";
        echo "<input type='hidden' value='{$tipo_lectura['tipo_lec_id']}' name='id" . $cont . "'>";
        echo "<input type='text' name='$cont' required></br></br>";

        $cont++;
      }

      exit;
    }

  $stmt = $conexion->prepare("SELECT * FROM tipo_servicio");
  $stmt->execute();

  $tipos_servicio = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = $conexion->prepare("SELECT DISTINCT reg_year FROM registros");
  $stmt->execute();

  $years = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = $conexion->prepare("SELECT * FROM tipo_lectura");
  $stmt->execute();

  $tipo_lecturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

  include("views/crud_administrador.view.php");
?>