<?php 
  /* include("../connect.php"); 
  include("../session_check.php");
  include("../cards_fnc_admin.php");
  include("../getworkingdays.php");
  include("../access-programs.php"); */
  require 'config/functions.php';

  session_start();

  $conexion = conexion($bd_config);
  if(!$conexion){
      echo 'Fatal Error!';
  }

/*$conexion2 = conexion2($bd_config);
  if(!$conexion2){
      echo 'Fatal Error!';
  }*/

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo_ser_id'])) {
      $tipo_servicio_id = $_POST['tipo_ser_id'];  

      $sql = "SELECT tipo_lectura.tipo_lec_id, tipo_lectura.tipo_lec_nombre, tipo_servicio.tipo_ser_nombre
      FROM cuestionarios JOIN tipo_servicio 
      ON cuestionarios.cue_tipo_ser_id=tipo_servicio.tipo_ser_id 
      JOIN tipo_lectura
      ON cuestionarios.cue_tipo_lec_id=tipo_lectura.tipo_lec_id
      WHERE cuestionarios.cue_tipo_ser_id=$tipo_servicio_id";
      
      $stmt = $conexion->prepare($sql);
      $stmt->execute();

      $tipos_lectura = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $cont = 0;

      foreach ($tipos_lectura as $tipo_lectura) {
        echo "<label for=$cont>{$tipo_lectura['tipo_lec_nombre']}: </label>";
        echo "<input type='hidden' value='{$tipo_lectura['tipo_lec_id']}' name='id" . $cont . "'>";
        echo "<input type='text' name='$cont' required></br></br>";

        $cont++;
      }

      exit;
    }

  $stmt = $conexion->prepare("SELECT * FROM tipo_servicio");
  $stmt->execute();

  $tipos_servicio = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = $conexion->prepare("SELECT DISTINCT reg_year FROM registros");
  $stmt->execute();

  $years = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = $conexion->prepare("SELECT * FROM tipo_lectura");
  $stmt->execute();

  $tipo_lecturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

  //include("views/header.php");
  include("views/crud_administrador.view.php");
  //include("views/footer.php");
?>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->