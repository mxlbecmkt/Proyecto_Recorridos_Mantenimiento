<?php
  include("../connect.php"); 
  include("../session_check.php");
  include("../cards_fnc_admin.php");
  include("../getworkingdays.php");
  include("../access-programs.php");
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

    $sql = "SELECT * FROM servicios INNER JOIN tipo_servicio ON servicios.ser_tipo_ser_id=tipo_servicio.tipo_ser_id WHERE servicios.ser_tipo_ser_id=$tipo_servicio_id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($servicios as $servicio) {
        echo "<option value=\"{$servicio['ser_id']}\">{$servicio['ser_medidor']}</option>";
    }
    
    exit;
  }

  $stmt = $conexion->prepare("SELECT * FROM tipo_servicio");
  $stmt->execute();

  $tipos_servicio = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $id_usuario = $_SESSION['idusr_admin'];
  $nombre_usuario = $_SESSION['nombre_admin'];
  $correo_usuario = $_SESSION['mail_admin'];
  $num_emp_usuario = $_SESSION['noempleado_admin'];

  include("views/header.php");
  include("views/seleccion_servicio.view.php");
  include("views/footer.php");
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>