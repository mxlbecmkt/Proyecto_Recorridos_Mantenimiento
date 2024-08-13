<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mostrar Registros</title>
  <script>
    function inicializar() {
      const yearActual = new Date();

      document.getElementById('FechaMes').value = yearActual.getMonth() + 1;
      year = document.getElementById('FechaYear').value = yearActual.getFullYear();

      filtrarRegistros();
    }

    function filtrarRegistros() {
      const antiguedad = document.getElementById('FechaAnt').value;
      const mes = document.getElementById('FechaMes').value;
      const year = document.getElementById('FechaYear').value;
      const tipoServicioID = document.getElementById('tipoServicio').value;
      console.log(mes + "-" + year + "-" + antiguedad + "-" + tipoServicioID);
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'mostrar_registros_usuario.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          document.getElementById('tablaConsultas').innerHTML = xhr.responseText;
        }
      };
      xhr.send('datos_consulta=' + encodeURIComponent(mes + "-" + year + "-" + antiguedad + "-" + tipoServicioID));
    }
  </script>
</head>
<body onload="inicializar()">
<div class="app-content content container-fluid">
      <div class="content-wrapper">
          <div class="content-detached">
              <div class="content-body">
                <center><h1>Registros</h1>
                  <div>
                    <label for="FechaAnt">Filtrar antiguedad:</label>
                    <select id="FechaAnt" name="FechaAnt" onchange="filtrarRegistros()">
                      <option value="1">Más Reciente</option>
                      <option value="2" selected>Más Antiguo</option>
                    </select>
                    <label for="FechaMes">&nbspFiltrar mes:</label>
                    <select id="FechaMes" name="FechaMes" onchange="filtrarRegistros()">
                      <option value="1">Enero</option>
                      <option value="2">Febrero</option>
                      <option value="3">Marzo</option>
                      <option value="4">Abril</option>
                      <option value="5">Mayo</option>
                      <option value="6">Junio</option>
                      <option value="7">Julio</option>
                      <option value="8">Agosto</option>
                      <option value="9">Septiembre</option>
                      <option value="10">Octubre</option>
                      <option value="11">Noviembre</option>
                      <option value="12">Diciembre</option>
                    </select>
                    <label for="FechaYear">&nbspFiltrar año:</label>
                    <select id="FechaYear" name="FechaYear" onchange="filtrarRegistros()">
                      <?php foreach ($years as $year): ?>
                          <option value="<?php echo $year['reg_year']; ?>"><?php echo $year['reg_year']; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <label for="tipoServicio">&nbspTipo de Servicio:</label>
                    <select id="tipoServicio" name="tipoServicio" onchange="filtrarRegistros()">
                      <?php foreach ($tipos_servicio as $tipo_servicio): ?>
                          <option value="<?php echo $tipo_servicio['tipo_ser_id']; ?>"><?php echo $tipo_servicio['tipo_ser_nombre']; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div id="tablaConsultas"></div>
                  </div></br></br>
                </center>
              </div>
          </div>
      </div>
  </div>
</body>
</html>