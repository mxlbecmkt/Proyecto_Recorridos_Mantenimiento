<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección Servicio</title> -->
    <script>
        function actualizarServicios() {
            const tipoServicioId = document.getElementById('tipo_servicio').value;
            console.log(tipoServicioId);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'seleccion_servicio.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('servicio').innerHTML = xhr.responseText;
                }
            };
            xhr.send('tipo_ser_id=' + encodeURIComponent(tipoServicioId));
        }

        function inicializar(){
            document.getElementById('tipo_servicio').value = "1";
            actualizarServicios();
        }
    </script>
<!-- </head>
<body onload="inicializar()"> -->
  <div class="app-content content container-fluid">
      <div class="content-wrapper">
          <div class="content-detached">
              <div class="content-body">
                <center><h1>Selección de Servicio a Ingresar las Lecturas</h1>
                <label>Seleccionar por medio de QR:</label></br>
                <a href="qr-reader/qrreader.php" id="open_qr"><img src="assets/icons/qr.png" alt="QR" style="width: 35px; margin: 10px;"></a>
                <form action="registro_lecturas.php" method="post">
                    <p>Seleccione el servicio:</p>
                    <select id="tipo_servicio" name="tipo_servicio" onchange="actualizarServicios()">
                        <?php foreach ($tipos_servicio as $tipo_servicio): ?>
                            <option value="<?php echo $tipo_servicio['tipo_ser_id']; ?>"><?php echo $tipo_servicio['tipo_ser_nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br><br>
                    <select id="servicio" name="servicio">
                    </select>
                    </br></br>
                    <input type="submit" value="Confirmar selección"></br></br>
                    <input type="reset" value="Borrar" onclick="inicializar()">
                </form></center>
              </div>
          </div>
      </div>
  </div>
<!-- </body>
</html> -->