<?php
/*     include("../connect.php"); 
    include("../session_check.php");
    include("../cards_fnc_admin.php");
    include("../getworkingdays.php");
    include("../access-programs.php"); */
    require 'config/functions.php';

    $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
	}

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
    }

    #Prueba insertar datos
    /*$instr = "INSERT INTO `registro_servicios`.`tipo_servicio` (`tipo_ser_nombre`) VALUES (:servicio)";
    $resultado = $conexion->prepare($instr);
    $resultado->bindValue(':servicio',"Cisterna");
    $resultado->execute();*/

    //include("views/header.php");
    //include("views/index.view.php");
    //include("views/footer.php");

    $num_empleado = 2032;

    $sql = "SELECT * FROM administradores WHERE num_empleado=$num_empleado";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $empleado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(empty($empleado))
        echo "<script>window.location='seleccion_servicio.php';</script>";
    else
        echo "<script>window.location='crud_administrador.php';</script>";
?>

<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
