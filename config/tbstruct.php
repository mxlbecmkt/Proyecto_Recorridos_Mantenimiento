<?php

    $bd_config= array(
        'basedatos' =>'pad',
        'usuario' => 'padrol',
        'pass' => 'vapro450',
        );
    function conexion($bd_config){
        try {
            //$conexion = new PDO('mysql:host=localhost;dbname='.$bd_config['basedatos'], $bd_config['usuario'], $bd_config['pass']);
            $conexion = new PDO('mysql:host=localhost;dbname='."registro_servicios", "root");
            return $conexion;
        } catch (PDOException $e) {
            echo "Error!: " . $e->getMessage() . "<br/>";
            die();
            //return false;
        }
    }
    $conexion = conexion($bd_config);
    if(!$conexion){
        echo 'Fatal Error!';
		//header ('Location: ../error.php');
	}

    #Tabla tipo_servicio
    $tipo_servicio = $conexion->prepare('CREATE TABLE `registro_servicios`.`tipo_servicio` (`tipo_ser_id` INT NOT NULL AUTO_INCREMENT, `tipo_ser_nombre` VARCHAR(30) NOT NULL, PRIMARY KEY (`tipo_ser_id`)) ENGINE = InnoDB;');
    $tipo_servicio->execute();

    #Tabla tipo_lectura
    $tipo_lectura = $conexion->prepare('CREATE TABLE `registro_servicios`.`tipo_lectura` (`tipo_lec_id` INT NOT NULL AUTO_INCREMENT, `tipo_lec_nombre` VARCHAR(50) NOT NULL, PRIMARY KEY (`tipo_lec_id`)) ENGINE = InnoDB;');
    $tipo_lectura->execute();

    #Tabla servicios
    $servicios = $conexion->prepare('CREATE TABLE `registro_servicios`.`servicios` (`ser_id` INT NOT NULL AUTO_INCREMENT, `ser_tipo_ser_id` INT NOT NULL, `ser_status` BOOLEAN NOT NULL, `ser_num_cuenta` VARCHAR(30), `ser_medidor` VARCHAR(30), `ser_ubicacion` VARCHAR(30) NOT NULL, `ser_subestacion` VARCHAR(20), PRIMARY KEY (`ser_id`), FOREIGN KEY (`ser_tipo_ser_id`) REFERENCES tipo_servicio(`tipo_ser_id`) ON UPDATE CASCADE ON DELETE RESTRICT) ENGINE = InnoDB;');//Probar con INDEX
    $servicios->execute();

    #Tabla registros
    $registros = $conexion->prepare('CREATE TABLE `registro_servicios`.`registros` (`reg_num` INT NOT NULL AUTO_INCREMENT, `reg_ser_id` INT NOT NULL, `reg_num_empleado` INT NOT NULL, `reg_fecha_hora` DATETIME NOT NULL, `reg_hora` TIME NOT NULL, `reg_mes` VARCHAR(2) NOT NULL, `reg_year` VARCHAR(4) NOT NULL, `reg_img` VARCHAR(100) NOT NULL, PRIMARY KEY (`reg_num`), FOREIGN KEY (`reg_ser_id`) REFERENCES servicios(`ser_id`) ON UPDATE CASCADE ON DELETE RESTRICT) ENGINE = InnoDB;');
    $registros->execute();

    #Tabla lecturas
    $lecturas = $conexion->prepare('CREATE TABLE `registro_servicios`.`lecturas` (`lec_id` INT NOT NULL AUTO_INCREMENT, `lec_reg_num` INT NOT NULL, `lec_tipo_lec_id` INT NOT NULL, `lec_dato` VARCHAR(15) NOT NULL, PRIMARY KEY (`lec_id`), FOREIGN KEY (`lec_reg_num`) REFERENCES registros(`reg_num`) ON UPDATE CASCADE ON DELETE RESTRICT, FOREIGN KEY (`lec_tipo_lec_id`) REFERENCES tipo_lectura(`tipo_lec_id`) ON UPDATE CASCADE ON DELETE RESTRICT) ENGINE = InnoDB;');
    $lecturas->execute();

    #Tabla cuestionarios
    $cuestionarios = $conexion->prepare('CREATE TABLE `registro_servicios`.`cuestionarios` (`cue_id` INT NOT NULL AUTO_INCREMENT, `cue_tipo_ser_id` INT NOT NULL, `cue_tipo_lec_id` INT NOT NULL, PRIMARY KEY (`cue_id`), FOREIGN KEY (`cue_tipo_ser_id`) REFERENCES tipo_servicio(`tipo_ser_id`) ON UPDATE CASCADE ON DELETE RESTRICT, FOREIGN KEY (`cue_tipo_lec_id`) REFERENCES tipo_lectura(`tipo_lec_id`) ON UPDATE CASCADE ON DELETE RESTRICT) ENGINE = InnoDB;');
    $cuestionarios->execute();

    #Tabla administradores
    $administradores = $conexion->prepare('CREATE TABLE `registro_servicios`.`administradores` (`num_empleado` INT NOT NULL, PRIMARY KEY (`num_empleado`)) ENGINE = InnoDB;');
    $administradores->execute();

    //$solicitud = $conexion->prepare('CREATE TABLE `pad`.`si_solicitud` (`id_solicitud` INT NOT NULL AUTO_INCREMENT , `s_solicitante` INT NOT NULL, `s_fecha` VARCHAR(20) NOT NULL, `s_mes` INT NOT NULL, `s_year` INT NOT NULL, `s_estado` VARCHAR(12) NOT NULL, PRIMARY KEY (`id_solicitud`)) ENGINE = InnoDB; ');
    //$solicitud->execute();

    /*$tipoaf = $conexion->prepare('CREATE TABLE `pad`.`si_tipo_activo_fijo` (`id_activo` INT NOT NULL AUTO_INCREMENT, `af_nombre` VARCHAR(200) NOT NULL, `af_estatus` VARCHAR(12) NOT NULL, PRIMARY KEY (`id_activo`)) ENGINE = InnoDB;');
    $tipoaf->execute();

    $items = $conexion->prepare('CREATE TABLE `pad`.`si_items`( `id_item` INT NOT NULL AUTO_INCREMENT, `id_solicitud` INT NOT NULL, `i_num_placa` VARCHAR(50) NULL, `i_num_serie` VARCHAR(200) NULL, `id_activo` INT NULL, `i_descripcion` LONGTEXT NOT NULL, `i_estado` VARCHAR(12) NOT NULL, `i_costo` FLOAT NULL, `i_depreciacion` FLOAT NULL, `i_precio_venta` FLOAT NULL, `i_utilidad` FLOAT NULL, PRIMARY KEY (`id_item`), INDEX (`id_solicitud`), INDEX (`id_activo`), FOREIGN KEY (id_solicitud) REFERENCES si_solicitud(id_solicitud) ON UPDATE CASCADE ON DELETE RESTRICT, FOREIGN KEY (id_activo) REFERENCES si_tipo_activo_fijo(id_activo) ON UPDATE CASCADE ON DELETE RESTRICT) ENGINE = InnoDB;');

    $coments = $conexion->prepare('CREATE TABLE `pad`.`si_comentarios` (`id_comentario` INT NOT NULL AUTO_INCREMENT, `c_no_emp` INT NOT NULL, `id_item` INT NOT NULL, `c_comentario` LONGTEXT NULL, `c_foto` VARCHAR(200) NULL, `c_fecha` VARCHAR(12) NOT NULL ,PRIMARY KEY (`id_comentario`), INDEX (`id_item`), FOREIGN KEY  (id_item) REFERENCES si_items(id_item) ON UPDATE CASCADE ON DELETE RESTRICT) ENGINE = InnoDB;');
    $coments->execute();

    $aprob = $conexion->prepare('CREATE TABLE `pad`.`si_aprobaciones` (`id_aprobacion` INT NOT NULL AUTO_INCREMENT, `id_solicitud` INT NOT NULL, `a_firma_solicitante` LONGTEXT NULL, `a_no_emp_jefe` INT NOT NULL, `a_firma_jefe` LONGTEXT NULL, `a_firma_jefe_af` LONGTEXT NULL, `a_aprobacion_cm` INT NULL, `a_aprobacion_ch` INT NULL, PRIMARY KEY (`id_aprobacion`), INDEX (`id_solicitud`), FOREING KEY (`id_solicitud`) REFERENCES si_solicitud(id_solicitud) ON UPDATE CASCADE ON DELTE RESTRICT)ENGINE = InnoDB;');
    $aprob->execute();

    $admin = $conexion->prepare('CREATE TABLE `pad`.`si_admins` (`id_admin` INT NOT NULL AUTO_INCREMENT, `adm_no_emp` INT NOT NULL, `adm_permisos` INT NOT NULL, PRIMARY KEY (`id_admin`)) ENGINE = InnoDB;');
    $admin->execute();*/
?>