<?php
    include ("../../app/config/config.php");
    include ("../../app/config/conexion.php");

    $error="";

    if (empty($_POST['celular'])) {
        $error = "* INGRESE UN NÚMERO DE CELULAR"."<br>";
    } else {
        // Si existe el campo, validamos la información para que no entre código malicioso
        $celular = $_POST['celular'];    
        // Limpiamos el campo
        $celular = filter_var($celular, FILTER_SANITIZE_STRING);    
        // Con trim limpiamos si el usuario pone un espacio en blanco al principio del input
        $celular = trim($celular);    
        // Verificamos si el campo está vacío después de limpiar los espacios
        if ($celular == "") {
            $error .= "* EL NÚMERO DE CELULAR ESTÁ VACÍO, INGRESE UN NÚMERO VÁLIDO <br>";
        } else {
            // Verificamos si el número de celular es válido (por ejemplo, solo números y longitud específica)
            if (!preg_match("/^[0-9]{8}$/", $celular)) {
                $error .= "* INGRESE UN NÚMERO DE CELULAR VÁLIDO de (8 dígitos) <br>";
            }
        }
    }

    $id_usuario_fk=$_POST['id_usuario'];
    $detalle_agenda="NO";

    if ($error=="") {

        if (empty($_POST['nombre']) AND empty($_POST['apellidos'])) {

            $Detalle= "SIN DETALLES";
            $sql = $pdo->prepare('INSERT INTO tb_contactos (celular, created_at, updated_at,detalle ,estado,detalle_agenda, id_usuario_fk) VALUES (:celular, :created_at, :updated_at, :detalle, :estado, :detalle_agenda, :id_usuario_fk)');

            $sql->bindParam(':celular',$celular);
            $sql->bindParam(':created_at',$fechayhora);
            $sql->bindParam(':updated_at',$fechayhora);
            $sql->bindParam(':detalle',$Detalle);
            $sql->bindParam(':estado',$estado);
            $sql->bindParam(':detalle_agenda',$detalle_agenda);
            $sql->bindParam(':id_usuario_fk',$id_usuario_fk); 

                  
        }
        else {
            $nombre=$_POST['nombre'];
            $apellidos=$_POST['apellidos'];

            $Detalle= "Se registro con anterioridad por $nombre $apellidos";

            $sql = $pdo->prepare('INSERT INTO tb_contactos (celular, created_at, updated_at,detalle ,estado,detalle_agenda, id_usuario_fk) VALUES (:celular, :created_at, :updated_at, :detalle, :estado, :detalle_agenda, :id_usuario_fk)');

            $sql->bindParam(':celular',$celular);
            $sql->bindParam(':created_at',$fechayhora);
            $sql->bindParam(':updated_at',$fechayhora);
            $sql->bindParam(':detalle',$Detalle);
            $sql->bindParam(':estado',$estado);
            $sql->bindParam(':detalle_agenda',$detalle_agenda);
            $sql->bindParam(':id_usuario_fk',$id_usuario_fk); 

        }


        if ($sql->execute()) {
            echo "exito";
        }else {
            echo $error; 
        }   
    } else {
        echo $error;        
    }