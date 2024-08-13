<?php
  require 'config/functions.php';

  $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
    }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['datos_accion'])) {
    $datos_accion = $_POST['datos_accion'];

    $valores = explode("-", $datos_accion);

    if($valores[0] == 1){
      $sql = "SELECT registros.reg_num_empleado, tipo_lectura.tipo_lec_id, tipo_lectura.tipo_lec_nombre, lecturas.lec_id, lecturas.lec_dato
      FROM registros JOIN lecturas
      ON registros.reg_num=lecturas.lec_reg_num
      JOIN tipo_lectura
      ON lecturas.lec_tipo_lec_id=tipo_lectura.tipo_lec_id
      WHERE registros.reg_num=$valores[1]";
      $stmt = $conexion->prepare($sql);
      $stmt->execute();

      $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $primero = TRUE;
      $cont = 0;

      foreach($registros as $registro){
        if($primero){
          echo "<input type='hidden' value='{$valores['1']}' name='num_reg'>
            <label>Número de empleado: </label>
            <input type='text' name='num_empleado' value='{$registro['reg_num_empleado']}'></br></br>";
          $primero = FALSE;
        }
        echo "<label>{$registro['tipo_lec_nombre']}: </label>
            <input type='hidden' name='id{$cont}' value='{$registro['lec_id']}'>
            <input type='text' name='$cont' value='{$registro['lec_dato']}'></br></br>";

        $cont++;
      }

      echo "<input type='submit' value='Confirmar'></br></br>
            <input type='reset' value='Reestablecer'>";
    } else{
      $sql = "DELETE FROM lecturas WHERE lec_reg_num=$valores[1]";
      $stmt = $conexion->prepare($sql);
      $stmt->execute();

      $sql = "DELETE FROM registros WHERE reg_num=$valores[1]";
      $stmt = $conexion->prepare($sql);
      $stmt->execute();
    }

    exit;
  }

  //echo "<script>window.location='crud_administrador.php';</script>";
?>