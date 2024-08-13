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
      echo "<p>No existe algún empleado con ese número</p>";
      exit;
    }
  }

    #$num_empleado = 2032;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['datos_consulta'])) {
      $datos_consulta = $_POST['datos_consulta'];

      $valores = explode("-", $datos_consulta);
      $lista_datos_filtros = ["reg_mes","reg_year","reg_fecha_hora","reg_ser_id"];
      $primero = TRUE;

      $sql1 = "SELECT tipo_lectura.tipo_lec_id, tipo_lectura.tipo_lec_nombre, tipo_servicio.tipo_ser_nombre
          FROM tipo_servicio JOIN cuestionarios
          ON tipo_servicio.tipo_ser_id=cuestionarios.cue_tipo_ser_id
          JOIN tipo_lectura
          ON cuestionarios.cue_tipo_lec_id=tipo_lectura.tipo_lec_id
          WHERE tipo_servicio.tipo_ser_id=$valores[3]";

      $stmt = $conexion->prepare($sql1);
      $stmt->execute();
  
      $tipo_lecturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($tipo_lecturas as $tipo_lectura) {
        if($primero){
          echo 
          "<p>{$tipo_lectura['tipo_ser_nombre']}</p>
          <table  border='1'>
          <tr>
            <td>Número de registro</td>
            <td>Fecha</td>
            <td>Hora</td>
            <td>Servicio</td>
            <td>Número de Empleado</td>";

          $primero = FALSE;
        }

        echo "<td>{$tipo_lectura['tipo_lec_nombre']}</td>";
      }

      echo "  <td>Imagen de Lectura</td>
            </tr>";

      if($valores[4] == ""){
        $sql2 = "SELECT *
          FROM tipo_servicio JOIN servicios
          ON tipo_servicio.tipo_ser_id=servicios.ser_tipo_ser_id
          JOIN registros
          ON servicios.ser_id=registros.reg_ser_id
          WHERE tipo_servicio.tipo_ser_id=$valores[3]";
      } else{
        consultaEmpleado($valores[4],$conexion2);

        $sql2 = "SELECT *
          FROM tipo_servicio JOIN servicios
          ON tipo_servicio.tipo_ser_id=servicios.ser_tipo_ser_id
          JOIN registros
          ON servicios.ser_id=registros.reg_ser_id
          WHERE tipo_servicio.tipo_ser_id=$valores[3]
          AND registros.reg_num_empleado=$valores[4]";
      }

      for($i=0;$i<2;$i++){
        if($valores[$i] != 0)
          $sql2 .= " AND $lista_datos_filtros[$i]=$valores[$i]";
      }

      if($valores[2] == 2)
        $sql2 .= " ORDER BY $lista_datos_filtros[2]";
      elseif($valores[2] == 1)
        $sql2 .= " ORDER BY $lista_datos_filtros[2] DESC";

      $stmt = $conexion->prepare($sql2);
      $stmt->execute();

      $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($registros as $registro) {
        echo 
          "<tr>
            <td>{$registro['reg_num']}</td>
            <td>{$registro['reg_fecha_hora']}</td>
            <td>{$registro['reg_hora']}</td>
            <td>{$registro['ser_medidor']}</td>
            <td>{$registro['reg_num_empleado']}</td>";
        
        $sql3 = "SELECT * FROM lecturas WHERE lec_reg_num={$registro['reg_num']}";

        $stmt = $conexion->prepare($sql3);
        $stmt->execute();

        $lecturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($lecturas as $lectura) {
          echo "<td>{$lectura['lec_dato']}</td>";
        }

        echo
          " <td><a href='{$registro['reg_img']}' target='_blank'>Evidencia</a></td>
            <td><button id='btnU{$registro['reg_num']}' onclick='accionRegistro(1,{$registro['reg_num']})'>Editar</button></td>
            <td><button id='btnD{$registro['reg_num']}' onclick='accionRegistro(2,{$registro['reg_num']})'>Eliminar</button></td>
          </tr>";
      }

      echo "</table>";
      
      exit;
    }

  $stmt = $conexion->prepare("SELECT * FROM tipo_servicio");
  $stmt->execute();

  $tipos_servicio = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = $conexion->prepare("SELECT DISTINCT reg_year FROM registros");
  $stmt->execute();

  $years = $stmt->fetchAll(PDO::FETCH_ASSOC);

  include("views/mostrar_registros_usuario.view.php");
?>