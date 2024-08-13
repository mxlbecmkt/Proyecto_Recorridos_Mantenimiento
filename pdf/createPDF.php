<?
    include("../connect.php"); 
/*     include("../session_check.php");
    include("../cards_fnc_admin.php");
    include("../getworkingdays.php");
    include("../access-programs.php"); */
    require 'conf/functions.php';
    require_once($_SERVER['DOCUMENT_ROOT'].'/cclnet/pdfv2/tcpdf.php');
    //require_once('/cclnet/pdfv2/examples/tcpdf_include.php');

    $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
	}

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $rec = $_GET['rec'];
        $recorrido = getRecorridoId($conexion, $rec);
        $itemhead = getOneReportItem($conexion, $rec);
        $cuestionario = getParambyRevfromCuest($conexion, $recorrido['id_revision']);
        $reporte = getReportebyRecorrido($conexion, $rec);
        $params = '';
        $html2 = '';
        $numparms = count($cuestionario);
        foreach($cuestionario as $c){
            $params .= '<th>'.$c['p_nombre'].'</th>';
        }

        $logos = '/cclnet/pdfv2/examples/images/'.$recorrido['rr_division'] . '.jpg';
        //echo '<img src="'.$logos.'">';
        $headerrep ='<th>No.</th>';
        if($itemhead['rp_agente'] != NULL){
            $headerrep .= '<th>Agente</th>';
        }
        if($itemhead['rp_capacidad'] != NULL){
            $headerrep .= '<th>Cap.</th>';
        }
        if($itemhead['rp_ubicacion'] != NULL){
            $headerrep .= '<th>Ubicación</th>';
        }
        if($itemhead['rp_fecha_rec'] != NULL){
            $headerrep .= '<th>Fecha de recarga</th>';
        }
        if($itemhead['rp_fecha_prox_rec'] != NULL){
            $headerrep .= '<th>Próxima Recarga</th>';
        }
        $commenthead = '<th colspan="3">Commentarios</th>';

        $datathead = '<table cellspacing="0" cellpadding="1" border="1"><thead><tr align="center" style="background-color: #0057b8;color:white;">'. $headerrep.$params.$commenthead.'</tr></thead><tbody>';
        $datatbody = '';
        $datatend = '</tbody></table>';
        $index = 1;
        foreach($reporte as $r){
            $datatbody .= '<tr align="center"><td>'. $r['rp_numero'] . '</td>';
            if($r['rp_agente'] != NULL){
                $datatbody .= '<td>'. $r['rp_agente'] . '</td>';
            }
            if($r['rp_capacidad'] != NULL){
                $datatbody .= '<td>'. $r['rp_capacidad'] . '</td>';
            }
            $datatbody .= '<td>'. $r['rp_ubicacion'] . '</td>';
            if($r['rp_fecha_rec'] != NULL){
                $datatbody .= '<td>'. $r['rp_fecha_rec'] . '</td>';
            }
            if($r['rp_fecha_prox_rec'] != NULL){
                $datatbody .= '<td>'. $r['rp_fecha_prox_rec'] . '</td>';
            }
            for($y=1; $y <= $numparms; $y++){
                $datatbody .= '<td>'. $r['rp_resp'.$y] . '</td>';
            }
            $comment = getComments($conexion, $r['id_reporte']);
            $datatbody .= '<td colspan="3">'. $comment['rc_comentario'] . '</td>';
            $datatbody.= '</tr>';
            $imgtab = '<table cellspacing="0" cellpadding="1" border="1" width="930px"><tr>';
            $imgtabend = '</tr></table>';
            
            if($comment['rc_foto'] != NULL){
                correctImageOrientation($comment['rc_foto']);
                $html2 .= '<td><h2>'.$comment['rp_numero'].'</h2><img src="'.$comment['rc_foto'].'"></td>';
                if($index % 3 == 0){
                    $html2 .= '</tr><tr>';
                }
                $index = $index + 1;
            }
        }

        class MYPDF extends TCPDF {
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
        }

        // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setValores($recorrido['rr_nombre_revision'],$recorrido['rr_formato'],$recorrido['fecha'],$recorrido['rr_quien_cerro'],$headerrep,$params,$logos);
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        #$pdf->SetAutoPageBreak(FALSE, 0);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        /* if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        } */
        
        // set font
        $pdf->SetFont('helvetica', 'B', 13);

        // add a page
        $pdf->AddPage('L', 'A4');

        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 6);

        $pdf->SetMargins(15, 35, 15);
        $pdf->SetHeaderMargin(5);
        #$pdf->SetFooterMargin(0);
        #$pdf ->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //add table code html and query $html

        $html = $datathead . $datatbody . $datatend;
        //$html2 = '<img src="evidencia/1691781442.jpg" alt="">';

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->AddPage('L', 'A4');
        /* $pdf->Cell(0, 0, 'EX-123', 1, 1, 'C', 0, '', 0);
        $pdf->Cell(0, 0, 'EX-456', 1, 1, 'C', 0, '', 0);
        $pdf->Cell(0, 0, 'EX-789', 1, 1, 'C', 0, '', 0); */
        //$pdf->Image('evidencia/1691781442.jpg', 0, 20);
        $finalhtml = $imgtab . $html2 . $imgtabend;
        $pdf->writeHTML($finalhtml, true, false, true, false, '');
        // -----------------------------------------------------------------------------
        $pdf->lastPage();
        //Close and output PDF document
        $pdf->Output('CCL_reporte_recorrido_'.$recorrido['fecha'].'.pdf', 'I');
        
        //============================================================+
        // END OF FILE
        //============================================================+
        
        
        
        /* $updatestatus = $conexion->prepare('UPDATE ssyma_revision_recorrido SET id_status = 2 WHERE id_recorrido =' . $rec);
        $updatestatus->execute(); */
        //header('Location: crear_reporte.php?idrec='.$recorrido['id_recorrido'].'&idrev='.$recorrido['id_revision']);
        
    }else{
        header('Location: reportes_revision.php');
    }

?>

