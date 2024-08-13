<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro Lecturas</title>
</head>
<body>
  <div class="app-content content container-fluid">
      <div class="content-wrapper">
          <div class="content-detached">
              <div class="content-body">
                <center><h1>Registro de Lecturas del Servicio</h1>
                <form action="insertar_registro.php" method="post" enctype="multipart/form-data">
                    <p>Ingrese las lecturas del servicio:</p>
                    <input type="hidden" value="<?php echo $tipo_servicio ?>" name="tipoServicio">
                    <input type="hidden" value="<?php echo $servicio ?>" name="servicio">
                    <?php
                      $cont = 0;
                      foreach ($tipos_lectura as $tipo_lectura): 
                    ?>
                        <label for="<?php echo $cont ?>"><?php echo $tipo_lectura['tipo_lec_nombre'] . ":"?></label>
                        <input type="hidden" value="<?php echo $tipo_lectura['tipo_lec_id'] ?>" name="<?php echo "id" . $cont ?>">
                        <input type="text" name="<?php echo $cont ?>" required></br></br>
                    <?php
                      $cont++; 
                      endforeach;
                    ?>
                    <label>Ingresar imagen de prueba de toma de lecturas: </label>
                    <input type="file" name="imagen" required accept=".jpg,.png,.jpeg"></br></br>
                    <input type="submit" value="Confirmar lecturas"></br></br>
                    <input type="reset" value="Reestablecer">
                </form></center>
              </div>
          </div>
      </div>
  </div>
</body>
</html>