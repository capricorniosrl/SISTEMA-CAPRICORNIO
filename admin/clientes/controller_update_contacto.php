<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');
include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');


$dsn = 'mysql:host=localhost;dbname=bd_capricornio'; 
$username = 'root';
$password = '';
 $error ="";
//try {
    // Crear una instancia de PDO
$pdo = new PDO($dsn, $username, $password);
    
    // Configurar el modo de error de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$celular = $_POST['celular_actualizar'];
$celular_obt = $_POST['celular_obtenido'];

//echo "celular_obtenido: ".$celular_obt;
//echo "celular a actualizar: ".$celular;
//$id_contacto = $_POST['id_contacto_actualizar'];

function verifica_datos_error($celular,$id_usuario,$pdo,$celular_obt,$error){
    if (empty($celular)) {
        $error .= "* INGRESE UN NÚMERO DE CELULAR" . "<br>";
        //$error = $celular_obt;
    } else {
    
        // Si existe el campo, validamos la información para que no entre código malicioso
      
        //$celular = "";
        // Limpiamos el campo
        $celular = filter_var($celular, FILTER_SANITIZE_STRING);
        // Con trim limpiamos si el usuario pone un espacio en blanco al principio del input
        $celular = trim($celular);
        // Verificamos si el campo está vacío después de limpiar los espacios
        if ($celular === "") {
            $error .= "EL NÚMERO DE CELULAR ESTÁ VACÍO, INGRESE UN NÚMERO VÁLIDO <br>";
            exit;
            echo "celular a actualizar: ".$celular;
        } else {
            // Verificamos si el número de celular es válido (por ejemplo, solo números y longitud específica)
            if (!preg_match("/^[0-9]{8}$/", $celular)) {
                $error .= "* INGRESE UN NÚMERO DE CELULAR VÁLIDO de (8 dígitos) <br>";
            }
        }    
        consulta_la_BD($celular,$id_usuario,$error,$pdo,$celular_obt);

    }

    if($error ==""){
        echo "success";
    }else{
        echo $error;
    }
}

function consulta_la_BD($celular,$id_usuario,$error,$pdo,$celular_obt){
    
    $consulta = $pdo->prepare('SELECT * FROM `tb_contactos` WHERE celular = :celular');
    $consulta->bindParam(':celular', $celular);
    $consulta->execute();

    $resultados = $consulta->fetchAll();
    $nro_filas = is_array($resultados) ? count($resultados) : 0;
    if ($nro_filas > 0) {      
        //existe en la base de datos
        //$error .= "El numero " . $celular . " ya existe en la base de datos<br>";
        $consulta_1 = $pdo->prepare('SELECT * 
            FROM tb_contactos conta
            INNER JOIN 
            tb_usuarios us ON conta.id_usuario_fk = us.id_usuario
            WHERE (conta.celular = :celular AND us.id_usuario = :id_usuario)
            GROUP BY conta.celular');
        $consulta_1->bindParam(':celular', $celular);
        $consulta_1->bindParam(':id_usuario', $id_usuario);
        $consulta_1->execute();
        $datos = $consulta_1->fetchAll();
        $nroTotal = is_array($datos) ? count($datos) : 0;
        if ($nroTotal > 0) {
            //esta en la base de datos y en el usuario
            ?>
            <script>
                console.log("El numero " + <?php echo $celular ?> + " ya existe en la base de datos, y ya esta registrado con usted por favor registre otro numero<br>");
                Swal.fire(
        'INCORRECTO',
        'El numero " , <?php echo $celular ?>  " ya existe en la base de datos, y ya esta registrado con usted por favor registre otro numero<br>',
        'error'
      ).then((result) => {
        if (result.value) {
            window.location.reload();
        }
      });
            </script>
            <?php
            $error = "El numero " .$celular ." ya existe en la base de datos, y ya esta registrado con usted por favor registre otro numero<br>";
        } else {
            $error .= "";
            $nomC = "";
            $nom = "";
            $ap_p = "";
            $ap_m = "";
            $sqli = $pdo->prepare('SELECT * 
            FROM tb_contactos conta
            INNER JOIN 
            tb_usuarios us ON conta.id_usuario_fk != us.id_usuario
            WHERE (conta.celular =  :celular AND us.id_usuario = :id_usuario)
            GROUP BY conta.celular');
            $sqli->bindParam(':celular', $celular);
            $sqli->bindParam(':id_usuario', $id_usuario);
            $sqli->execute();
            $datitos = $sqli->fetchAll();
            
    $nro_filas = is_array($datitos) ? count($datitos) : 0;
    if ($nro_filas > 0) {
        //se repite en toda la base de datos y no en el usuario
        foreach ($datitos as $dato) {
            $nom = $dato['nombre'];
            $ap_p = $dato['ap_paterno'];
            $ap_m = $dato['ap_materno'];
            $nomC = $nom." ".$ap_p." ".$ap_m;
        }
        $detalle ="ESTE USUARIO YA HA SIDO REGISTRADO , por  $nomC";

                $response = [
                    'status' => 'success',
                    'data' => [
                        'sw' => 0,
                        'celular' => $celular,
                        'detalle' => $detalle,
                        'id_usuario' => $id_usuario
                    ]
                ];
                echo json_encode($response);
                ?>
                        <script>
                    Swal.fire({
                title: "ESTE USUARIO YA HA SIDO REGISTRADO , por <?php echo $nomC ?>",
                text: "Estas seguro de proceder con la actualizacion!",
                showDenyButton: true,
                confirmButtonText: "Aceptar",
                denyButtonText: `Cancelar`
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire("Correcto", "", "success");
                    $.ajax({
                                    type: "POST",
                                    url: "update_validate.php",
                                    data: { 
                                        data: JSON.stringify(<?php echo json_encode($response);?>)
                                    },
                                    contentType: 'application/json', 
                                    dataType: 'json',
                                    success: function(response){
                                        console.log("el respuesta completa es: ",response);
                                        console.log("el dato esperado es ",response.status);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Error en la solicitud:", error);
                                        console.log("Respuesta del servidor:", xhr.responseText);
                                    }                                    
                                  });
                   /*$sql = $pdo->prepare('UPDATE tb_contactos
                            SET celular = :celular,
                            detalle =:detalle,
                            updated_at = :updated_at
                            WHERE celular = :celular  and id_usuario_fk = :id_contacto');
                     $sql->bindParam(':celular', $celular);
                     $sql->bindParam(':detalle', $detalle);
                     $sql->bindParam(':updated_at',date('Y-m-d H:i:s'));

                     //$sql->bindParam(':celularobt', $celular_obt);
                     $sql->bindParam(':id_contacto', $id_usuario);
                 $sql->execute();
                 $datos = $sql->fetchAll();
                 $nroTotal = is_array($datos) ? count($datos) : 0;
                 if ($nroTotal > 0) {
                     return "success";
                 }else{
                     return $error;
                 }*/
     //        }
     
     //window.location.reload();
                } else if (result.isDenied) {
                    Swal.fire("Los cambios no fueron efectuados", "", "info");
                    window.location.reload();
                }
                });
</script>
<?php                 
                 
    }else{
                $response = array(
                    'status' => 'success',
                    'data' => array(
                        'sw' => 1,
                        'celular' => $celular,
                        'id_usuario' => $id_usuario
                    )
                );
                
        ?>
        <script>
Swal.fire({
                title: "Estas seguro de actualizar al contacto??",
                //text: "Estas seguro de proceder con la actualizacion!",
                showDenyButton: true,
                confirmButtonText: "Aceptar",
                denyButtonText: `Cancelar`
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire("Correcto", "", "success");
                   $.ajax({
                                    type: "POST",
                                    url: "update_validate.php",
                                    data: { 
                                        data: JSON.stringify({$response})
                                    },
                                    contentType: 'application/json', 
                                    dataType: 'json',
                                    success: function(response){
                                        console.log(response);
                                    }                                    
                                  });

                  /*$sql = $pdo->prepare('UPDATE tb_contactos
                  SET celular = :celular,
                  updated_at = :updated_at
                  WHERE celular = :celular  and id_usuario_fk = :id_contacto');
           $sql->bindParam(':celular', $celular);
           $sql->bindParam(':updated_at',date('Y-m-d H:i:s'));
           //$sql->bindParam(':celularobt', $celular_obt);
           $sql->bindParam(':id_contacto', $id_usuario);
       $sql->execute();*/

     //window.location.reload();
                } else if (result.isDenied) {
                    Swal.fire("Los cambios no fueron efectuados", "", "info");
                    window.location.reload();
                }
                });

        </script>
        <?php
        //este codigo incluir
        
    }
            //}
        }

    }else{



        $sql = $pdo->prepare('SELECT * FROM `tb_contactos` WHERE celular = :celular');
        $sql->bindParam(':celular', $celular);
        $sql->execute();
        $resultados = $sql->fetchAll();
        $nro_filas = is_array($resultados) ? count($resultados) : 0;
        if ($nro_filas < 1) {
            $sql = $pdo->prepare('UPDATE tb_contactos cont
                    SET cont.celular=:celular
                    WHERE cont.celular = :celularobt  and cont.id_usuario_fk = :id_contacto');
                        //$sql->bindParam(':detalle', $detalle);
                        $sql->bindParam(':celular', $celular);
                        $sql->bindParam(':celularobt', $celular_obt);
                        $sql->bindParam(':id_contacto', $id_usuario);
                    if ($sql->execute()) {
                        return "success";
                        ?>
                    <script>
                Swal.fire(
        'CORRECTO',
        'actualizado con exito <br>',
        'success'
      ).then((result) => {
        if (result.value) {
            window.location.reload();
        }
      });
            </script>
                    <?php
                    }else{
                        return $error;
                        ?>
                    <script>
                Swal.fire(
        'CORRECTO',
        'actualizado con exito <br>',
        'success'
      ).then((result) => {
        if (result.value) {
            window.location.reload();
        }
      });
            </script>
                    <?php
                    }
                    
        } 

    }

    if($error==""){
        return "success";
    }else{
        return $error;
    }

}

verifica_datos_error($celular,$id_usuario,$pdo,$celular_obt,$error);

//aqui incluir el alert de confirmacion