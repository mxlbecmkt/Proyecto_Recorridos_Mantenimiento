<?php 
  require 'config/functions.php';

  $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
    }

  $conexion2 = conexion2($bd_config);
  if(!$conexion2){
      echo 'Fatal Error!';
  }

  date_default_timezone_set('America/Mexico_City');

  $tipo_servicio = array_shift($_POST);
  $servicio = array_shift($_POST);
  $numero_post = count($_POST);

  $num_empleado = 2036;

  if(isset($_FILES['imagen'])){
    $imagen = $_FILES['imagen'];
    
    $nombre_imagen = $imagen['name'];
    $url_temp = $imagen['tmp_name'];

    $url_insertar = "assets/galeria/" . $servicio;
    $url_normalizada = str_replace('\\', '/', $url_insertar) . '/' . time() . '.' . pathinfo($nombre_imagen, PATHINFO_EXTENSION);

    if (move_uploaded_file($url_temp, $url_normalizada)) {
      echo "Subida correcta";
    } else {
        echo "Ha habido un error al cargar tu archivo.";
    }

    $sql = "INSERT INTO `registros`(`reg_ser_id`, `reg_num_empleado`, `reg_fecha_hora`, `reg_hora`, `reg_mes`, `reg_year`, `reg_img`) 
          VALUES (?,?,?,?,?,?,?)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$servicio,$num_empleado,date('Y-m-d H:i:s'),date('H:i:s'),date('m'),date('Y'),$url_normalizada]);
    $num_registro = $conexion->lastInsertId();
    
    for($i=0; $i<$numero_post/2; $i++){
      $sql = "INSERT INTO `lecturas`(`lec_reg_num`, `lec_tipo_lec_id`, `lec_dato`) VALUES (?,?,?)";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$num_registro,$_POST['id' . $i],$_POST[$i]]);
    }
  }

  $sql = "SELECT * FROM administradores WHERE num_empleado=$num_empleado";
  $stmt = $conexion->prepare($sql);
  $stmt->execute();

  $empleado = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if(empty($empleado))
    echo "<script>window.location='mostrar_registros_usuario.php';</script>";
  else
    echo "<script>window.location='crud_administrador.php';</script>";
?>