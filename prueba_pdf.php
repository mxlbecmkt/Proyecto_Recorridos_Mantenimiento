<?php 
    require 'config/functions.php';
    require_once('libraries/TCPDF-main/examples/tcpdf_include.php');

    $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
	}

    /* class MYPDF extends TCPDF {
        public $nombre;
        public $formato;
        public $fecha;
        public $quien;
        public $starthead;
        public $pars;
        public $logo;

        public function setValores($nombre,$formato,$fecha,$quien,$starthead,$pars,$logo){
            $this->nombre = $nombre;
            $this->formato = $formato;
            $this->fecha = $fecha;
            $this->quien = $quien;
            $this->starthead = $starthead;
            $this->pars = $pars;
            $this->logo = $logo;
        }
        #var $top_margin = 20;
        public function Header() {
        //$image_file = K_PATH_IMAGES.'ccl-lo.jpg';
        
        //$image_file = $this->Image('img/ccl-logo.png',0, 0, 25, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $cab = '<table cellspacing="0" cellpadding="1" border="1"><tr><th rowspan="2" align="center"><img src="'.$this->logo.'" style="width: 100px; padding-top: 10px;"></th><th colspan="4" rowspan="2" style="text-align:center"><h2 style="text-align: center">Revisión de dispositivos de seguridad</h2> <h2 style="text-align:center">'. $this->nombre .'</h2></th><th align="center" rowspan="1">'.$this->formato.'</th></tr><tr><th align="center" rowspan="1">Versión: 1.0<br>Fecha recorrido: '.$this->fecha.' <br>'.$this->quien.'</th></tr></table>';
        $this->writeHTMLCell($w = 285, $h = 1, $x = 6, $y = '', $cab, $border = 1, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = false);
        #$this->SetTopMargin($this->GetY());
        #$this->$top_margin = $this->GetY() + 20;
        }
    } */

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->setFont('dejavusans', '', 8, '', true);

    $pdf->AddPage();

    $pdf->setCellPaddings(0, 0, 0, 0);

    $pdf->setCellMargins(0, 0, 0, 0);

    $pdf->setFillColor(255, 255, 127);

    $txt = '';

    //Largo:210
    $pdf->MultiCell(40, 27, '[LOGO] '.$txt, 1, 'C', 0, 0, 10, 10, true, 0, false, true, 27, 'M');
    $pdf->MultiCell(120, 27, 'LECTURAS '.$txt, 1, 'C', 0, 0, 50, 10, true, 0, false, true, 27, 'M');
    $pdf->MultiCell(30, 9, '[TEXT1]', 1, 'L', 0, 1, 170, 10, true, 0, false, true, 9, 'M');
    $pdf->MultiCell(30, 9, '[TEXT2]', 1, 'L', 0, 1, 170, 19, true, 0, false, true, 9, 'M');
    $pdf->MultiCell(30, 9, '[TEXT3]', 1, 'L', 0, 1, 170, 28, true, 0, false, true, 9, 'M');

    $year = 2010;

    $pdf->MultiCell(20, 5, 'AÑO: ' . $year, 0, 'C', 0, 0, 25, 45, true);
    $pdf->MultiCell(80, 5, 'NO. TERMÓMETRO/HIGRÓMETRO: ' . $year, 0, 'C', 0, 0, 68, 45, true);
    $pdf->MultiCell(50, 5, 'UBICACIÓN: ' . $year, 0, 'C', 0, 1, 150, 45, true);

    $pdf->MultiCell(10, 4, 'CpK', 0, 'C', 0, 0, 185, 51, true);

    $pdf->MultiCell(50, 4, 'Especificación=   50 %   +/-5°C', 0, 'C', 0, 0, 10, 55, true);
    $pdf->MultiCell(40, 4, 'X = ' . '24.50', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 4, 'LI = ' . '19.05', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 4, 'Rango = ' . '15', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 8, 'Cp = ', 0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(12, 4, '10.00', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(15, 8, ' = ' . '0.3056', 0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(20, 4, 'Cps=' . '1.8644', 0, 'C', 0, 0, '', '', true);

    $pdf->MultiCell(40, 8, 'desv(z) = ' . '5.4356546' . '|' . '100.00%', 0, 'C', 0, 0, 60, 59, true);
    $pdf->MultiCell(20, 4, 'LS = ' . '19.05', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 4, 'min = ' . '15', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(12, 4, '10.00', 0, 'C', 0, 0, 150, 59, true);
    $pdf->MultiCell(20, 4, 'Cpi=' . '-1.8644', 0, 'C', 0, 0, 177, 59, true);

    $pdf->MultiCell(20, 4, 'max = ' . '15', 0, 'C', 0, 0, 120, 63, true);

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
    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($servicios as $servicio){
        $pdf->MultiCell($longitud_casilla, 8, $servicio['tipo_lec_nombre'], 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    }

    for ($i=0;$i<count($dias);$i++){
        
    }
    
    $pdf->Output('Lecturas_Temperatura_Humedad.pdf', 'I');
?>