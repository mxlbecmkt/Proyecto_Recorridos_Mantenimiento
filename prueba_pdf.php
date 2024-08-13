<?php 
    require 'config/functions.php';
    require_once('libraries/TCPDF-main/examples/tcpdf_include.php');

    $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
	}

    function calculoDesvZ($lecturas, $cantidad_lecturas){
        
    }

    function calculoLI(){

    }

    function calculoLS(){

    }

    function calculoCP(){

    }

    function calculoCps(){

    }

    function calculoCpi(){

    }

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->setFont('dejavusans', '', 8, '', true);

    $pdf->AddPage();

    $pdf->setCellPaddings(0, 0, 0, 0);

    $pdf->setCellMargins(0, 0, 0, 0);

    $pdf->setFillColor(255, 255, 127);

    //Largo:210
    $pdf->MultiCell(40, 27, '[LOGO]', 1, 'C', 0, 0, 10, 10, true, 0, false, true, 27, 'M');
    $pdf->MultiCell(120, 27, 'LECTURAS DE TEMPERATURA', 1, 'C', 0, 0, 50, 10, true, 0, false, true, 27, 'M');
    $pdf->MultiCell(30, 9, '[TEXT1]', 1, 'C', 0, 1, 170, 10, true, 0, false, true, 9, 'M');
    $pdf->MultiCell(30, 9, '[TEXT2]', 1, 'C', 0, 1, 170, 19, true, 0, false, true, 9, 'M');
    $pdf->MultiCell(30, 9, '[TEXT3]', 1, 'C', 0, 1, 170, 28, true, 0, false, true, 9, 'M');

    $year = 2010;

    $pdf->MultiCell(20, 5, 'AÑO: ' . $year, 0, 'C', 0, 0, 25, 45, true);
    $pdf->MultiCell(80, 5, 'NO. TERMÓMETRO/HIGRÓMETRO: ' . $year, 0, 'C', 0, 0, 68, 45, true);
    $pdf->MultiCell(50, 5, 'UBICACIÓN: ' . $year, 0, 'C', 0, 1, 150, 45, true);

    $pdf->MultiCell(10, 4, 'CpK', 0, 'C', 0, 0, 185, 51, true);

    $pdf->MultiCell(6, 4, 'Día', 1, 'C', 0, 0, 10, 59, true);
    $pdf->MultiCell(10, 4, 'Mes', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(15, 4, 'Lectura', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(6, 4, 'LIE', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(6, 4, 'LSE', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(8, 4, 'X', 1, 'C', 0, 0, '', '', true);

    $sql = "SELECT tipo_lectura.tipo_lec_id, tipo_lectura.tipo_lec_nombre, tipo_servicio.tipo_ser_nombre
          FROM tipo_servicio JOIN cuestionarios
          ON tipo_servicio.tipo_ser_id=cuestionarios.cue_tipo_ser_id
          JOIN tipo_lectura
          ON cuestionarios.cue_tipo_lec_id=tipo_lectura.tipo_lec_id
          WHERE tipo_servicio.tipo_ser_id=5";
    $stmt =  $conexion->prepare($sql);
    $stmt->execute();
    $tipo_lecturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $servicio_id = 6;
        
    //$pdf->MultiCell(10, 4, $tipo_lecturas[0]['tipo_lec_nombre'], 1, 'C', 0, 0, 10, 63, true, 0, false, true, 4, 'M');

    $sql = "SELECT * FROM tipo_servicio JOIN servicios
          ON tipo_servicio.tipo_ser_id=servicios.ser_tipo_ser_id
          JOIN registros
          ON servicios.ser_id=registros.reg_ser_id
          WHERE servicios.ser_id=$servicio_id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* $desvZ = ;
    $li = ;
    $ls = ;
    $cp = ;
    $cps = ;
    $cpi = ; */

    $cont = 0;
    foreach ($registros as $registro){
        #$pdf->MultiCell(6, 4, $cont + 1, 1, 'C', 0, 0, 10, 59 + ($cont * 6), true, 0, false, true, 6, 'M');

        $fecha_hora = strtotime($registro['reg_fecha_hora']);
        $dia_formado = date('d', $fecha_hora);
        $pdf->MultiCell(6, 4, $dia_formado, 1, 'C', 0, 0, 10, 63 + ($cont * 4), true, 0, false, true, 4, 'M');    

        $pdf->MultiCell(10, 4, $registro['reg_mes'], 1, 'C', 0, 0, 16, 63 + ($cont * 4), true, 0, false, true, 4, 'M'); 
        
        $sql = "SELECT * FROM lecturas WHERE lec_reg_num={$registro['reg_num']} AND lec_tipo_lec_id=7";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $lectura = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lecs[] = floatval($lectura[0]['lec_dato']);
        $pdf->MultiCell(15, 4, $lectura[0]['lec_dato'], 1, 'C', 0, 0, 26, 63 + ($cont * 4), true, 0, false, true, 4, 'M');
        
        $pdf->MultiCell(6, 4, '17', 1, 'C', 0, 0, 41, 63 + ($cont * 4), true, 0, false, true, 4, 'M');
        $pdf->MultiCell(6, 4, '27', 1, 'C', 0, 0, 47, 63 + ($cont * 4), true, 0, false, true, 4, 'M');

        $cont++;
    }

    $x = array_sum($lecs) / $cont;
    $min = min($lecs);
    $max = max($lecs);
    $rango = $max - $min;

    $desvZ = calculoDesvZ($lecs, $cont);

    $pdf->MultiCell(50, 4, 'Especificación=   22 °C  +/-5°C', 0, 'C', 0, 0, 10, 55, true);
    $pdf->MultiCell(40, 4, 'X = ' . $x, 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 4, 'LI = ' . '19.05', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 4, 'Rango = ' . $rango, 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 8, 'Cp = ', 0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(12, 4, '10.00', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(15, 8, ' = ' . '0.3056', 0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(20, 4, 'Cps=' . '1.8644', 0, 'C', 0, 0, '', '', true);

    $pdf->MultiCell(40, 8, 'desv(z) = ' . '5.4356546' . '|' . '100.00%', 0, 'C', 0, 0, 60, 59, true);
    $pdf->MultiCell(20, 4, 'LS = ' . '19.05', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 4, 'min = ' . $min, 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(12, 4, '10.00', 0, 'C', 0, 0, 150, 59, true);
    $pdf->MultiCell(20, 4, 'Cpi=' . '-1.8644', 0, 'C', 0, 0, 177, 59, true);

    $pdf->MultiCell(20, 4, 'max = ' . $max, 0, 'C', 0, 0, 120, 63, true);
    
    $pdf->Output('Lecturas_Temperatura_Humedad.pdf', 'I');
?>