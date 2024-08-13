<?php
include ("../app/config/config.php");
include ("../app/config/conexion.php");

$error="";
// validados de email
if (empty($_POST['correo'])) {        
    $error = "INGRESE SU CORRECO ELECTRONICO"."<hr>";
}else{
    $correo=$_POST['correo'];

    if (!filter_var($correo,FILTER_VALIDATE_EMAIL)) {
        $error .= "INGRESE UN EMAIL VERDADERO"."<hr>";
    } else {
        $correo = filter_var($correo,FILTER_SANITIZE_EMAIL);
    }
}


// validados de password
if (empty($_POST['password'])) {        
    $error .= "INGRESE SU PASSWORD"."<br>";
}else {
    // si existe el campo validamos la informacion para que no entre vados o codigo malicioso
    $contraseña=$_POST['password'];
    // limpiamos el campo
    $contraseña = filter_var($contraseña,FILTER_SANITIZE_STRING);



}


if ($error=='') {

    // creamos la consulta en una varable query_login
    $query_login = $pdo->prepare("SELECT * FROM tb_usuarios WHERE email='$correo' AND estado='1'");

    // ejecutamos la consulta
    $query_login->execute();

    // almacenamos en la variable usuarios los datos
    $usuarios = $query_login->fetchAll(PDO::FETCH_ASSOC);
    $contador=0;
    foreach ($usuarios as $usuario) {
        $contador=$contador+1;
        $nombre = $usuario['nombre'];
        $password_bd = $usuario['password'];            
    }
    if ($contador==0) {
        echo $error .= "NO SE ENCONTRO NINGUN USUARIO CON EL CORREO ELECTRONICO"."<hr>";         
    }else
    {
        if (password_verify($contraseña,$password_bd )) {               
            session_start();

            $_SESSION['session_email']=$correo;
            echo "exito";
        }
        else {
            echo $error .="CONTRASEÑA INCORRECTA"."<hr>";
        }
    }
           
} else {
    echo $error;
    
}
?>
