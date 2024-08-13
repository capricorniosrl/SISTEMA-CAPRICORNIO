<?php
include ("../../../app/config/config.php");
include ("../../../app/config/conexion.php");

include ('../../../layout/admin/session.php');
include ('../../../layout/admin/datos_session_user.php');

$carpeta_destino = '../img/';


$img_nueva=$_FILES["img_nuevo"];

$nombre_UPDATE=$_POST["nombre"];
$ap_paterno_UPDATE=$_POST["ap_paterno"];
$ap_materno_UPDATE=$_POST["ap_materno"];
$ci_UPDATE=$_POST["ci"];
$exp_UPDATE=$_POST["exp"];
$celular_UPDATE=$_POST["celular"];
$direccion_UPDATE=$_POST["direccion"];




if ($_FILES['img_nuevo']['name'] != null) {
    
    $img_nueva =$_FILES["img_nuevo"];

    if ($img_nueva["type"]=="image/jpeg" OR $img_nueva["type"]=="image/png" OR $img_nueva["type"]=="image/jpg"OR $img_nueva["type"]=="image/webp") {
        
        $img_nueva = $_FILES['img_nuevo'];
        $nombre_archivo = $img_nueva['name'];
        $tipo_archivo = $img_nueva['type'];
        $tmp_archivo = $img_nueva['tmp_name'];
        $error_archivo = $img_nueva['error'];
        $tamano_archivo = $img_nueva['size'];


        // Generar un nombre único para evitar conflictos
        $nombre_archivo_unico = uniqid() . '-' . basename($nombre_archivo);
        $ruta_archivo = $carpeta_destino . $nombre_archivo_unico;

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($tmp_archivo, $ruta_archivo)) {

                $img="img/".$nombre_archivo_unico;
            
                $query ="UPDATE tb_usuarios SET foto_perfil=:foto_perfil WHERE id_usuario=:id_usuario";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':foto_perfil', $img, PDO::PARAM_STR);
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            
                $stmt->execute();

            
            if ($stmt->execute()) {
                echo "Imagen cargada y ruta actualizada correctamente.";
            } else {
                echo "Error al actualizar la base de datos.";
            }
        } else {
            echo "Error al mover el archivo a la carpeta de destino.";
        }


       
    

        
    } else {
        echo "debe seleccionar una imagen valida";
    }
    
}





$sentencia = $pdo->prepare('UPDATE tb_usuarios SET
nombre=:nombre,
ap_paterno=:ap_paterno,
ap_materno=:ap_materno,
ci=:ci,
exp=:exp,
celular=:celular,
direccion=:direccion,
updated_at=:updated_at
WHERE id_usuario=:id_usuario

');



$sentencia->bindParam(':nombre',$nombre_UPDATE);
$sentencia->bindParam(':ap_paterno',$ap_paterno_UPDATE);
$sentencia->bindParam(':ap_materno',$ap_materno_UPDATE);
$sentencia->bindParam(':ci',$ci_UPDATE);
$sentencia->bindParam(':exp',$exp_UPDATE);
$sentencia->bindParam(':celular',$celular_UPDATE);
$sentencia->bindParam(':direccion',$direccion_UPDATE);
$sentencia->bindParam(':updated_at',$fechayhora);
$sentencia->bindParam(':id_usuario',$id_usuario);


if ($sentencia->execute()) {
    header('location:'.$URL.'/admin/usuarios/config/configurar_usuario.php');
} else {
    echo "ERROR EN EL REGISTRO DE LA INFORMACION";
}


?>