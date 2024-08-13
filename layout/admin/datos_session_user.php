<?PHP
$email_session=$_SESSION['session_email'];

$query_usuario = $pdo->prepare("SELECT * FROM tb_usuarios WHERE email='$email_session' AND estado='1'");
$query_usuario->execute();

$session_usuarios = $query_usuario->fetchAll(PDO::FETCH_ASSOC);
foreach ($session_usuarios as $session_usuario) {
  
  $id_usuario = $session_usuario['id_usuario'];
  $nombre = strtoupper($session_usuario['nombre']);
  $ap_paterno = strtoupper($session_usuario['ap_paterno']);
  $ap_materno = strtoupper($session_usuario['ap_materno']);
  $ci = $session_usuario['ci'];
  $celular = $session_usuario['celular'];
  $cargo = strtoupper($session_usuario['cargo']);
  $direccion = strtoupper($session_usuario['direccion']);
  $exp=$session_usuario['exp'];

  $foto_perfil = $session_usuario['foto_perfil']; //recuperamos la ruta de la imagen

}


$query_funciones = $pdo->prepare("SELECT fun.nombre_funcion FROM tb_usuarios us INNER JOIN tb_funciones fun WHERE (us.email='$email_session' AND us.estado='1')AND us.id_usuario=fun.id_usuario_fk GROUP BY fun.nombre_funcion");
$query_funciones->execute();

$session_funciones = $query_funciones->fetchAll(PDO::FETCH_ASSOC);

foreach ($session_funciones as $dato_funcion) {
  if ($dato_funcion['nombre_funcion']=='CARGO') {
    $_SESSION['session_cargo']=$dato_funcion['nombre_funcion'];
  }



  if ($dato_funcion['nombre_funcion']=='FUNCIONES') {
    $_SESSION['session_funciones']=$dato_funcion['nombre_funcion'];
  }



  if ($dato_funcion['nombre_funcion']=='URBANIZACIONES') {
    $_SESSION['session_urbanizaciones']=$dato_funcion['nombre_funcion'];
  }


  if ($dato_funcion['nombre_funcion']=='USUARIOS') {
    $_SESSION['session_usuarios']=$dato_funcion['nombre_funcion'];
  }



  if ($dato_funcion['nombre_funcion']=='REG_CLIENTES') {
    $_SESSION['session_reg_clientes']=$dato_funcion['nombre_funcion'];
  }



  if ($dato_funcion['nombre_funcion']=='AGE_CLIENTES') {
    $_SESSION['session_age_clientes']=$dato_funcion['nombre_funcion'];
  }



  if ($dato_funcion['nombre_funcion']=='RESERVAS') {
    $_SESSION['session_reservas']=$dato_funcion['nombre_funcion'];
  }

  
  if ($dato_funcion['nombre_funcion']=='DESIGNAR') {
    $_SESSION['session_designar']=$dato_funcion['nombre_funcion'];
  }



  if ($dato_funcion['nombre_funcion']=='REPORTES') {
    $_SESSION['session_reportes']=$dato_funcion['nombre_funcion'];
  }



}

?>