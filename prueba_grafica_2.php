<?php
    require 'config/functions.php';

    $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
	}

    //Obtener de pantalla de administrador
    $servicio_id = 6;

    $sql = "SELECT * FROM tipo_servicio JOIN servicios
          ON tipo_servicio.tipo_ser_id=servicios.ser_tipo_ser_id
          JOIN registros
          ON servicios.ser_id=registros.reg_ser_id
          WHERE servicios.ser_id=$servicio_id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $lie = 17;
    $lse = 27;

    foreach ($registros as $registro){
        $sql = "SELECT * FROM lecturas WHERE lec_reg_num={$registro['reg_num']} AND lec_tipo_lec_id=7";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $lectura = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lecs[] = floatval($lectura[0]['lec_dato']);

        $fecha_hora = strtotime($registro['reg_fecha_hora']);
        $dia_formado = date('d', $fecha_hora); 

        $dias[] = $dia_formado;
    }

    $lies = array_fill(0, count($registros), $lie);
    $lses = array_fill(0, count($registros), $lse);

    $x = array_sum($lecs) / count($registros);
    $xs = array_fill(0, count($registros), $x);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfica</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div>
        <canvas id="myChart" with="400" height="320"></canvas>
        <button id="generarPDF">Generar en PDF</button>
        <iframe id="pdfIframe" style="width:100%; height:600px; border:none; display:none;"></iframe>
    </div>
    <script>
        const xs = <?php echo json_encode($xs); ?>;
        const lies = <?php echo json_encode($lies); ?>;
        const lses = <?php echo json_encode($lses); ?>;
        const lecs = <?php echo json_encode($lecs); ?>;
        const dias = <?php echo json_encode($dias); ?>;

        const ctx = document.getElementById('myChart');

        var grafica = new Chart(ctx, {
            type: 'line',
            data: {
            labels: dias,
            datasets: [{
                label: 'Lectura',
                data: lecs,
                borderColor: 'blue',
                backgroundColor: 'blue',
                borderWidth: 1
            }, {
                label: 'LIE',
                data: lies,
                borderColor: 'red',
                backgroundColor: 'red',
                borderWidth: 1
            }, {
                label: 'LSE',
                data: lses,
                borderColor: 'green',
                backgroundColor: 'green',
                borderWidth: 1
            }, {
                label: 'X',
                data: xs,
                borderColor: 'yellow',
                backgroundColor: 'yellow',
                borderWidth: 1
            }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });

        document.getElementById('generarPDF').addEventListener('click', function() {
            var imgData = grafica.toBase64Image();

            fetch('prueba_pdf.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ image: imgData })
            })
            .then(response => response.blob())
            .then(blob => {
                /* const pdfUrl = URL.createObjectURL(blob);
                window.open(pdfUrl, '_blank'); */
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>