<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');
include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

$error = "";
$id_contacto = $_POST['id_contacto_actualizar'];

if (empty($_POST['celular_actualizar'])) {
    $error = "* INGRESE UN NÚMERO DE CELULAR" . "<br>";
} else {

    // Si existe el campo, validamos la información para que no entre código malicioso
    $celular = $_POST['celular_actualizar'];
    //$celular = "";
    // Limpiamos el campo
    $celular = filter_var($celular, FILTER_SANITIZE_STRING);
    // Con trim limpiamos si el usuario pone un espacio en blanco al principio del input
    $celular = trim($celular);
    // Verificamos si el campo está vacío después de limpiar los espacios
    if ($celular == "") {
        $error .= "EL NÚMERO DE CELULAR ESTÁ VACÍO, INGRESE UN NÚMERO VÁLIDO <br>";
    } else {
        // Verificamos si el número de celular es válido (por ejemplo, solo números y longitud específica)
        if (!preg_match("/^[0-9]{8}$/", $celular)) {
            $error .= "* INGRESE UN NÚMERO DE CELULAR VÁLIDO de (8 dígitos) <br>";
        }
    }
    $consulta = $pdo->prepare('SELECT * FROM `tb_contactos` WHERE celular = :celular');
    $consulta->bindParam(':celular', $celular);
    $consulta->execute();

    $resultados = $consulta->fetchAll();
    $nro_filas = is_array($resultados) ? count($resultados) : 0;
    if ($nro_filas > 0) {
        //$error .= "El numero " . $celular . " ya existe en la base de datos, ingrese otro numero por favor <br>";
        //echo "id usuario: ".$id_usuario;
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
            $error .= "El numero " . $celular . " ya existe en la base de datos, y ya esta registrado con usted por favor registre otro numero<br>";
            //var_dump($resultados);
            //$resultados_dump = ob_get_clean(); // Obtener el contenido del buffer y limpiarlo
            $error .= "<pre>" . htmlspecialchars($id_usuario) . "</pre>";
        } else {
            $error .= "";
            $nomC = "";
            foreach ($datos as $datobusq) {
                $nomC .= $datobusq['nombre'] . " ";
                $nomC .= $datobusq['ap_paterno'] . " ";
                $nomC .= $datobusq['ap_materno'];
            }
            $sqli = $pdo->prepare('SELECT conta.*
FROM tb_contactos conta
 INNER JOIN 
 tb_usuarios us ON conta.id_usuario_fk = us.id_usuario
 WHERE conta.celular = :celular
 GROUP BY conta.celular');
            $sqli->bindParam(':celular', $celular);
            $sqli->execute();
            $datitos = $sqli->fetchAll();
            foreach ($datitos as $dato) {
                if ($dato['detalle'] == 'SIN DETALLES') {
                    $detalle = "Este contacto se registro con anterioridad por " . $nomC;
                } else {
                    $detalle = "Este contacto se registro con anterioridad por " . $nomC;
                }
            }
        }
    }
}


if ($error == "") {
    ?><script>obtienevalores()</script><?php
?>
    <script>
        function obtienevalores() {
            let inputElement = document.getElementById('celular_modal_actualizar');

            // Obtener el valor inicial
            let valorInicial = inputElement.value;

            console.log("Valor inicial:", valorInicial);

            let valorModificado = inputElement.value;
            console.log("Valor modificado:", valorModificado);
            // Escuchar el evento de cambio de valor
            /*inputElement.addEventListener('input', function() {
                // Obtener el valor modificado
                
                
                
            });*/
        }
    </script>
<?php

    /*$sql = $pdo->prepare('UPDATE tb_contactos cont
SET cont.celular=:celular_actualizado, cont.detalle= :detalle
WHERE cont.celular = :celular  and cont.id_usuario_fk = :id_contacto');
    $sql->bindParam(':detalle', $detalle);
    $sql->bindParam(':celular', $celular);
    $sql->bindParam(':celular2', $celular2);

    if ($sql->execute()) {
        echo "exito";
    } else {
        echo $error;
    }*/
} else {
    echo $error;
}
