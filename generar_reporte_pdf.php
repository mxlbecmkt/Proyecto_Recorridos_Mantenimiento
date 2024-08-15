<?php 
  require 'config/functions.php';
  require_once('libraries/TCPDF-main/examples/tcpdf_include.php');

  $conexion = conexion($bd_config);
  if(!$conexion){
      echo 'Fatal Error!';
	}

  if($_POST['tipoServicio'] == 5){
    $mes = $_POST['FechaMes'];
    $year = $_POST['FechaYear'];
    $tipo_servicio_id = $_POST['tipoServicio'];
    $servicio_id = $_POST['Servicio'];
    
    include('generar_grafica.php');
  } else {
    $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $mes = $meses[$_POST['FechaMes']-1];
    $year = $_POST['FechaYear'];
    $tipo_servicio_id = $_POST['tipoServicio'];
    $servicio_id = $_POST['Servicio'];

    date_default_timezone_set('America/Mexico_City');

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->AddPage();

    $pdf->setCellPaddings(0, 0, 0, 0);

    $pdf->setCellMargins(0, 0, 0, 0);

    $pdf->setFillColor(255, 255, 127);

    $sql = "SELECT * FROM servicios JOIN tipo_servicio
            ON servicios.ser_tipo_ser_id=tipo_servicio.tipo_ser_id 
            WHERE ser_id=$servicio_id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $var_servicio = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdf->setFont('dejavusans', '', 16, '', true);
    //Largo:210
    $pdf->MultiCell(40, 26, '[LOGO]', 1, 'C', 0, 0, 10, 10, true, 0, false, true, 26, 'M');
    $pdf->MultiCell(120, 26, 'Registro Mensual de ' . $var_servicio[0]['tipo_ser_nombre'] . ' De Medidor ' . $var_servicio[0]['ser_medidor'], 1, 'C', 0, 0, 50, 10, true, 0, false, true, 26, 'M');

    $pdf->setFont('dejavusans', '', 12, '', true);
    $pdf->MultiCell(30, 13, '[TEXT2]', 1, 'C', 0, 1, 170, 10, true, 0, false, true, 13, 'M');
    $pdf->MultiCell(30, 13, '[TEXT3]', 1, 'C', 0, 1, 170, 23, true, 0, false, true, 13, 'M');

    $pdf->setFont('dejavusans', '', 8, '', true);
    $pdf->MultiCell(95, 5, 'Mes: ' . $mes, 1, 'C', 0, 0, 10, 36, true, 0, false, true, 5, 'M');
    $pdf->MultiCell(95, 5, 'Año: ' . $year, 1, 'C', 0, 0, 105, 36, true, 0, false, true, 5, 'M');

    $pdf->MultiCell(95, 5, 'Ubicación: ' . $var_servicio[0]['ser_ubicacion'], 1, 'C', 0, 0, 10, 41, true, 0, false, true, 5, 'M');
    $pdf->MultiCell(95, 5, 'Número De Equipo: ' . $var_servicio[0]['ser_num_cuenta'], 1, 'C', 0, 0, 105, 41, true, 0, false, true, 5, 'M');

    $sql = "SELECT tipo_lectura.tipo_lec_id, tipo_lectura.tipo_lec_nombre, tipo_servicio.tipo_ser_nombre
            FROM tipo_servicio JOIN cuestionarios
            ON tipo_servicio.tipo_ser_id=cuestionarios.cue_tipo_ser_id
            JOIN tipo_lectura
            ON cuestionarios.cue_tipo_lec_id=tipo_lectura.tipo_lec_id
            WHERE tipo_servicio.tipo_ser_id=$tipo_servicio_id";
    $stmt =  $conexion->prepare($sql);
    $stmt->execute();
    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $longitud_casilla = 80 / count($servicios);

    $pdf->MultiCell(30, 8, 'Día', 1, 'C', 0, 0, 10, 46, true, 0, false, true, 8, 'M');

    foreach ($servicios as $servicio){
      $pdf->MultiCell($longitud_casilla, 8, $servicio['tipo_lec_nombre'], 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    }
    
    $pdf->MultiCell(50, 8, 'Nombre de Verificador', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(30, 8, 'Hora de Lectura', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');

    $sql = "SELECT * FROM tipo_servicio JOIN servicios
            ON tipo_servicio.tipo_ser_id=servicios.ser_tipo_ser_id
            JOIN registros
            ON servicios.ser_id=registros.reg_ser_id
            WHERE servicios.ser_id=$servicio_id
            AND registros.reg_mes={$_POST['FechaMes']}
            AND registros.reg_year=$year";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $cont = 0;

    foreach ($registros as $registro){
      $pdf->MultiCell(6, 6, $cont + 1, 1, 'C', 0, 0, 10, 54 + ($cont * 6), true, 0, false, true, 6, 'M');

      $fecha_hora = strtotime($registro['reg_fecha_hora']);
      $dia_formado = date('d-m-Y', $fecha_hora);
      $pdf->MultiCell(24, 6, $dia_formado, 1, 'C', 0, 0, 16, 54 + ($cont * 6), true, 0, false, true, 6, 'M');    

      $sql = "SELECT * FROM lecturas WHERE lec_reg_num={$registro['reg_num']}";
      $stmt = $conexion->prepare($sql);
      $stmt->execute();
      $lecturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $cont_lec = 0;
      foreach ($lecturas as $lectura) {
        $pdf->MultiCell($longitud_casilla, 6, $lectura['lec_dato'], 1, 'C', 0, 0, 40 + ($cont_lec * $longitud_casilla), 54 + ($cont * 6), true, 0, false, true, 6, 'M');
        $cont_lec++;
      }

      //Cambiar por consulta del nombre
      $sql = "SELECT * FROM empleado WHERE num_empleado={$registro['reg_num_empleado']}";
      //$stmt = $conexion2->prepare($sql);
      //$stmt->execute();
      //$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      $pdf->MultiCell(50, 6, $registro['reg_num_empleado'], 1, 'C', 0, 0, 120, 54 + ($cont * 6), true, 0, false, true, 6, 'M');
      $pdf->MultiCell(30, 6, $registro['reg_hora'], 1, 'C', 0, 0, 170, 54 + ($cont * 6), true, 0, false, true, 6, 'M');   

      $cont++;
    }

    $servicio_medidor = $var_servicio[0]['ser_medidor'];

    $pdf->SetTitle('Reporte_Mensual_' . $mes . '_' . $year . '_' . $servicio_medidor . '.pdf');
    $pdf->Output('Reporte_Mensual_' . $mes . '_' . $year . '_' . $servicio_medidor . '.pdf', 'I');
  }
?>