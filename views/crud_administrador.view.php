<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administración de Datos</title> -->
  <script>
    function elegirAccion(accion){
      //console.log(accion);
      ocultarDivs();

      switch (accion){
        case 1:
          document.getElementById('createCrud').style.display = "block";
          inicializarAcciones(1);
          break;
        case 2:
          document.getElementById('readCrud').style.display = "block";
          inicializarAcciones(2);
          break;
        case 3:
          document.getElementById('agregarLecSer').style.display = "block";
          inicializarAcciones(3);
          break;
        case 4:
          document.getElementById('consultaMensualCrud').style.display = "block";
          inicializarAcciones(4);
          break;
      }
    }

    function ocultarDivs(){
      document.getElementById('createCrud').style.display = "none";
      document.getElementById('readCrud').style.display = "none";
      document.getElementById('updateCrud').style.display = "none";
      document.getElementById('agregarLecSer').style.display = "none";
      document.getElementById('consultaMensualCrud').style.display = "none";
    }

    function inicializarAcciones(accion) {
      switch (accion){
        case 1:
          ocultarForms();
          document.getElementById('selInsertar').value = "1";
          document.getElementById('formTipoLec').style.display = "block";
          break;
        case 2:
          const yearActual = new Date();

          document.getElementById('FechaMes').value = yearActual.getMonth() + 1;
          document.getElementById('FechaYear').value = yearActual.getFullYear();
          document.getElementById('FechaAnt').value = "2";
          document.getElementById('tipoServicio').value = "1";

          filtrarRegistros();
          break;
        case 3:
          break;
        case 4:
          const yearActual2 = new Date();

          document.getElementById('FechaMes2').value = yearActual2.getMonth() + 1;
          document.getElementById('FechaYear2').value = yearActual2.getFullYear();
          //document.getElementById('FechaAnt').value = "2";
          document.getElementById('tipoServicio2').value = "1";

          actualizarServicios2();
          break;
      }
    }

    function selInsertar(){
      const valorIns = document.getElementById('selInsertar').value;
      //console.log(valorIns);
      ocultarForms();
      
      switch (valorIns){
        case "1":
          document.getElementById('formTipoLec').style.display = "block";
          break;
        case "2":
          document.getElementById('formTipoSer').style.display = "block";
          break;
        case "3":
          document.getElementById('formServicio').style.display = "block";
          break;
        case "4":
          document.getElementById('formRegistro').style.display = "block";
          actualizarServicios();
          break;
      }
    }

    function ocultarForms(){
      document.getElementById('formTipoLec').style.display = "none";
      document.getElementById('formTipoSer').style.display = "none";
      document.getElementById('formServicio').style.display = "none";
      document.getElementById('formRegistro').style.display = "none";
    }

    function actualizarServicios() {
      const tipoServicioId = document.getElementById('selServicio2').value;
      //console.log(tipoServicioId);
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'seleccion_servicio.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
          if (xhr.status === 200) {
              document.getElementById('selServicio3').innerHTML = xhr.responseText;
          }
      };
      xhr.send('tipo_ser_id=' + encodeURIComponent(tipoServicioId));

      ingresarCamposLecturas();
    }

    function ingresarCamposLecturas(){
      const tipoServicioId = document.getElementById('selServicio2').value;
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'crud_administrador.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
          if (xhr.status === 200) {
              document.getElementById('lecturas').innerHTML = xhr.responseText;
          }
      };
      xhr.send('tipo_ser_id=' + encodeURIComponent(tipoServicioId));
    }

    function reestablecerFormRegistro(){
      document.getElementById('selServicio2').value = "1";
      actualizarServicios();
    }

    function filtrarRegistros(){
      const antiguedad = document.getElementById('FechaAnt').value;
      const mes = document.getElementById('FechaMes').value;
      const year = document.getElementById('FechaYear').value;
      const tipoServicioID = document.getElementById('tipoServicio').value;
      const numEmpleado = document.getElementById('numEmpleado').value;
      console.log(mes + "-" + year + "-" + antiguedad + "-" + tipoServicioID + "-" + numEmpleado);
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'mostrar_consultas_crud.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          document.getElementById('tablaConsultas').innerHTML = xhr.responseText;
        }
      };
      xhr.send('datos_consulta=' + encodeURIComponent(mes + "-" + year + "-" + antiguedad + "-" + tipoServicioID + "-" + numEmpleado));
    }

    function accionRegistro(accion,num_registro){
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'editar_eliminar_registro_crud.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          document.getElementById('formUpdate').innerHTML = xhr.responseText;
        }
      };
      xhr.send('datos_accion=' + encodeURIComponent(accion + "-" + num_registro));

      ocultarDivs();

      if(accion == 1)
        document.getElementById('updateCrud').style.display = "block";
    }

    function AgregarTipoLec(){
      const tipoSer = document.getElementById('selServicio4').value;
      const tipoLec = document.getElementById('selTiposLecturas').value;
      console.log(tipoSer + " - " + tipoLec);
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'agregar_lectura_cuestionario.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send('datos_accion=' + encodeURIComponent(tipoSer + "-" + tipoLec));
    }

    /* function generarReporte(){
      const mes = document.getElementById('FechaMes2').value;
      const year = document.getElementById('FechaYear2').value;
      const tipoServicioID = document.getElementById('tipoServicio2').value;
      const ServicioID = document.getElementById('Servicio2').value;
      console.log(mes + "-" + year + "-" + tipoServicioID + "-" + ServicioID);

      if(tipoServicioID == 5){
        console.log('Temperatura');
      } else {
        header('generar_reporte_pdf.php?variable=' . $year);
        /* const xhr = new XMLHttpRequest();
        xhr.open('POST', 'generar_reporte_pdf.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          if (xhr.status === 200) {
            //document.getElementById('tablaConsultas').innerHTML = xhr.responseText;
          }
        };
        xhr.send('datos_reporte=' + encodeURIComponent(mes + "-" + year + "-" + tipoServicioID + "-" + ServicioID));
      }
    } */

    function actualizarServicios2() {
      const tipoServicioId = document.getElementById('tipoServicio2').value;
      //console.log(tipoServicioId);
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'seleccion_servicio.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
          if (xhr.status === 200) {
              document.getElementById('Servicio2').innerHTML = xhr.responseText;
          }
      };
      xhr.send('tipo_ser_id=' + encodeURIComponent(tipoServicioId));

      ingresarCamposLecturas();
    }
  </script>
<!-- </head>
<body> -->
<div class="app-content content container-fluid">
      <div class="content-wrapper">
          <div class="content-detached">
              <div class="content-body">
                <center><h1>Administración de Datos</h1>
                  <div id="inicial">
                    <button id="btnInsertar" onclick="elegirAccion(1)">Insertar</button>
                    <button id="btnConsultar" onclick="elegirAccion(2)">Consultar</button>
                    <button id="btnAgregarLecASer" onclick="elegirAccion(3)">Agregar Lectura a Cuestionario</button>
                    <button id="btnConsulRepoMen" onclick="elegirAccion(4)">Consultar Reporte Mensual</button>
                  </div></br></br>
                  <div id="createCrud" style="display: none;">
                    <label for="selInsertar">Elegir elemento a ingresar:</label>
                    <select id="selInsertar" name="selInsertar" onchange="selInsertar()">
                      <option value="1" selected>Tipo Lectura</option>
                      <option value="2">Tipo Servicio</option>
                      <option value="3">Servicio</option>
                      <option value="4">Registro</option>
                    </select></br></br>
                    <form action="insertar_datos_crud.php" method="post" id="formTipoLec" style="display: none;">
                      <label>Nombre del Tipo de Lectura:</label>
                      <input type="text" name="tipo_lectura" required></br></br>
                      <input type="hidden" value="1" name="opcionInsertar">
                      <input type="submit" value="Confirmar"></br></br>
                      <input type="reset" value="Reestablecer">
                    </form>
                    <form action="insertar_datos_crud.php" method="post" id="formTipoSer" style="display: none;">
                      <label>Nombre del Tipo de Servicio:</label>
                      <input type="text" name="tipo_servicio" required></br></br>
                      <input type="hidden" value="2" name="opcionInsertar">
                      <input type="submit" value="Confirmar"></br></br>
                      <input type="reset" value="Reestablecer">
                    </form>
                    <form action="insertar_datos_crud.php" method="post" id="formServicio" style="display: none;">
                      <label>Tipo de Servicio:</label>
                      <select id="selServicio" name="tipoServicio">
                        <?php foreach ($tipos_servicio as $tipo_servicio): ?>
                            <option value="<?php echo $tipo_servicio['tipo_ser_id']; ?>"><?php echo $tipo_servicio['tipo_ser_nombre']; ?></option>
                        <?php endforeach; ?>
                      </select></br></br>
                      <label>Estatus:</label>
                      <select name="estatus">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                      </select></br></br>
                      <label>Número de Cuenta:</label>
                      <input type="text" name="num_cuenta"></br></br>
                      <label>Medidor:</label>
                      <input type="text" name="medidor"></br></br>
                      <label>Ubicación:</label>
                      <input type="text" name="ubicacion" required></br></br>
                      <label>Subestación:</label>
                      <input type="text" name="subestacion"></br></br>
                      <input type="hidden" value="3" name="opcionInsertar">
                      <input type="submit" value="Confirmar"></br></br>
                      <input type="reset" value="Reestablecer">
                    </form>
                    <form action="insertar_registro.php" method="post" id="formRegistro" enctype="multipart/form-data" style="display: none;">
                      <label>Tipo de Servicio:</label>
                      <select id="selServicio2" name="tipoServicio" onchange="actualizarServicios()">
                          <?php foreach ($tipos_servicio as $tipo_servicio): ?>
                              <option value="<?php echo $tipo_servicio['tipo_ser_id']; ?>"><?php echo $tipo_servicio['tipo_ser_nombre']; ?></option>
                          <?php endforeach; ?>
                      </select>
                      <br><br>
                      <label>Servicio:</label>
                      <select id="selServicio3" name="servicio"></select>
                      </br></br>
                      <div id="lecturas"></div>
                      <label>Ingresar imagen de prueba de toma de lecturas: </label>
                      <input type="file" name="imagen" required accept=".jpg,.png,.jpeg"></br></br>
                      <input type="submit" value="Confirmar"></br></br>
                      <input type="reset" value="Reestablecer" onclick="reestablecerFormRegistro()">
                    </form>
                  </div>
                  <div id="readCrud" style="display: none;">
                    <label for="FechaAnt">Filtrar antiguedad:</label>
                    <select id="FechaAnt" name="FechaAnt" onchange="filtrarRegistros()">
                      <option value="1">Más Reciente</option>
                      <option value="2">Más Antiguo</option>
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
                    <label for="numEmpleado">&nbspNúmero de Empleado:</label>
                    <input type="text" id="numEmpleado" name="numEmpleado"></br></br>
                    <button id="btnBuscar" onclick="filtrarRegistros()">Buscar</button></br></br>
                    <div id="tablaConsultas"></div>
                  </div>
                  <div id="updateCrud" style="display: none;">
                    <form action="actualizar_lecturas_registro.php" method="post"  id="formUpdate" ></form>
                  </div>
                  <div id="agregarLecSer" style="display: none;">
                    <label>Tipo de Servicio:</label>
                    <select id="selServicio4">
                      <?php foreach ($tipos_servicio as $tipo_servicio): ?>
                          <option value="<?php echo $tipo_servicio['tipo_ser_id']; ?>"><?php echo $tipo_servicio['tipo_ser_nombre']; ?></option>
                      <?php endforeach; ?>
                    </select></br></br>
                    <select id="selTiposLecturas">
                      <?php foreach ($tipo_lecturas as $tipo_lectura): ?>
                          <option value="<?php echo $tipo_lectura['tipo_lec_id']; ?>"><?php echo $tipo_lectura['tipo_lec_nombre']; ?></option>
                      <?php endforeach; ?>
                      </select></br></br>
                    <button id="btnAgregaTipoLec" onclick="AgregarTipoLec()">Agregar</button>
                  </div>
                  <div id="consultaMensualCrud" style="display: none;">
                    <form action="generar_reporte_pdf.php" method="post" id="formReporte">
                      <label for="FechaMes2">&nbspFiltrar mes:</label>
                      <select id="FechaMes2" name="FechaMes">
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
                      <label for="FechaYear2">&nbspFiltrar año:</label>
                      <select id="FechaYear2" name="FechaYear">
                        <?php foreach ($years as $year): ?>
                            <option value="<?php echo $year['reg_year']; ?>"><?php echo $year['reg_year']; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <label for="tipoServicio2">&nbspTipo de Servicio:</label>
                      <select id="tipoServicio2" name="tipoServicio" onchange="actualizarServicios2()">
                        <?php foreach ($tipos_servicio as $tipo_servicio): ?>
                            <option value="<?php echo $tipo_servicio['tipo_ser_id']; ?>"><?php echo $tipo_servicio['tipo_ser_nombre']; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <label for="Servicio2">&nbspServicio:</label>
                      <select id="Servicio2" name="Servicio"></select></br></br>
                      <input type="submit" value="Generar Reporte Mensual">
                    </form>
                  </div>
                </center>
              </div>
          </div>
      </div>
  </div>
<!-- </body>
</html> -->