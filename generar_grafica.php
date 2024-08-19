<?php
    $sql = "SELECT * FROM tipo_servicio JOIN servicios
          ON tipo_servicio.tipo_ser_id=servicios.ser_tipo_ser_id
          JOIN registros
          ON servicios.ser_id=registros.reg_ser_id
          WHERE tipo_servicio.tipo_ser_id=$tipo_servicio_id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $lieT = 17;
    $lseT = 27;
    $lieH = 45;
    $lseH = 55;

    foreach ($registros as $registro){
        $sql = "SELECT * FROM lecturas WHERE lec_reg_num={$registro['reg_num']}";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $lectura = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lecsT[] = floatval($lectura[0]['lec_dato']);
        $lecsH[] = floatval($lectura[1]['lec_dato']);

        $fecha_hora = strtotime($registro['reg_fecha_hora']);
        $dia_formado = date('d', $fecha_hora); 

        $dias[] = $dia_formado;
    }

    $liesT = array_fill(0, count($registros), $lieT);
    $lsesT = array_fill(0, count($registros), $lseT);
    $liesH = array_fill(0, count($registros), $lieH);
    $lsesH = array_fill(0, count($registros), $lseH);

    $xT = array_sum($lecsT) / count($registros);
    $xsT = array_fill(0, count($registros), $xT);
    $xH = array_sum($lecsH) / count($registros);
    $xsH = array_fill(0, count($registros), $xH);
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
    <div hidden>
        <canvas id="GraficaT" with="400" height="320"></canvas>
        <canvas id="GraficaH" with="400" height="320"></canvas>
    </div>
    <script>
        const xsT = <?php echo json_encode($xsT); ?>;
        const xsH = <?php echo json_encode($xsH); ?>;

        const liesT = <?php echo json_encode($liesT); ?>;
        const liesH = <?php echo json_encode($liesH); ?>;

        const lsesT = <?php echo json_encode($lsesT); ?>;
        const lsesH = <?php echo json_encode($lsesH); ?>;

        const lecsT = <?php echo json_encode($lecsT); ?>;
        const lecsH = <?php echo json_encode($lecsH); ?>;

        const dias = <?php echo json_encode($dias); ?>;

        const ctxT = document.getElementById('GraficaT');
        var graficaT = new Chart(ctxT, {
            type: 'line',
            data: {
            labels: dias,
            datasets: [{
                label: 'Lectura',
                data: lecsT,
                borderColor: 'blue',
                backgroundColor: 'blue',
                borderWidth: 1
            }, {
                label: 'LIE',
                data: liesT,
                borderColor: 'red',
                backgroundColor: 'red',
                borderWidth: 1
            }, {
                label: 'LSE',
                data: lsesT,
                borderColor: 'green',
                backgroundColor: 'green',
                borderWidth: 1
            }, {
                label: 'X',
                data: xsT,
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
                },
                animation: {
                    onComplete: function () {
                        var imgData = graficaT.toBase64Image();
                        console.log(imgData);

                        fetch('grafica_imagen.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ image: imgData })
                        })
                        .then(response => response.blob())
                        .then(blob => {})
                        .catch(error => console.error('Error:', error));
                    }
                }
            }
        });

        const ctxH = document.getElementById('GraficaH');
        var graficaH = new Chart(ctxH, {
            type: 'line',
            data: {
            labels: dias,
            datasets: [{
                label: 'Lectura',
                data: lecsH,
                borderColor: 'blue',
                backgroundColor: 'blue',
                borderWidth: 1
            }, {
                label: 'LIE',
                data: liesH,
                borderColor: 'red',
                backgroundColor: 'red',
                borderWidth: 1
            }, {
                label: 'LSE',
                data: lsesH,
                borderColor: 'green',
                backgroundColor: 'green',
                borderWidth: 1
            }, {
                label: 'X',
                data: xsH,
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
                },
                animation: {
                    onComplete: function () {
                        var imgData = graficaH.toBase64Image();
                        console.log(imgData);

                        fetch('grafica_imagen.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ image: imgData })
                        })
                        .then(response => response.blob())
                        .then(blob => {})
                        .catch(error => console.error('Error:', error));

                        window.location='generar_reporte_pdf_grafica.php';
                    }
                }
            }
        });
    </script>
</body>
</html>