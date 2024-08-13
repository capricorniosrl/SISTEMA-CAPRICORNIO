<?php
include ("../app/config/config.php");
include ("../app/config/conexion.php");

include ('../layout/admin/session.php');
include ('../layout/admin/datos_session_user.php');


?>

<?php
// Verificar el estado del usuario
$stmt = $pdo->prepare("SELECT estado_guia FROM tb_usuarios WHERE id_usuario = :id_usuario");
$stmt->execute(['id_usuario' => $id_usuario]); // Asumiendo que estás verificando al usuario con ID 1
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$mostrarGuia = false;

if ($user && $user['estado_guia'] == 0) {
    $mostrarGuia = true;
}
?>




<?php  include ('../layout/admin/parte1.php'); ?>


<?php if ($mostrarGuia): ?>
    <script>
        $(document).ready(function() {
            const driver = window.driver.js.driver;


            const driverObj = driver({
              showProgress: true,
              steps: [
                { element: '#pantalla_completa', popover: { title: 'PANTALLA COMPLETA', description: 'Con esta opcion podras poden en Modo Full Screen .', side: "left", align: 'start' }},
                { element: '#configuracion', popover: { title: 'CONFIGURACION', description: 'Aqui podras configurar tu perfil de usuario, Configuracion de Contraseña y Cerrar Session de Usuario.', side: "left", align: 'start' }},

                { element: '#mensaje', popover: { title: 'MENSAJERIA', description: 'Aqui te notificara si tienes Llamadas Programadas' }},
                { element: '#panel_guia', popover: { title: 'PANEL DE CONTROL', description: 'Aqui es donde administras todo tu contenido' }},
                { element: '#modo_oscuro_guia', popover: { title: 'MODO OSCURO', description: 'Con esta opcion podras aplicar el modo Oscuro para cambiar la visualizacion del Panel de Administracion' }},
                { popover: {
                  description: "<img style='height:100px;' src='../public/img/logo.png' /><span style='font-size: 15px;  display: block; margin-top: 10px; text-align: center;'>Bienvenido al Sistema Capricornio SRL.</span>  <h4 style='display: block; margin-top: 10px; text-align: center;'>EMPECEMOS A TRABAJAR</h4>",
                }
                 }
                
              ]
            });

            driverObj.drive();

            $.ajax({
              url: 'update_status.php',
              method: 'POST',
              data: { id: 1 },
              success: function(response) {
                  console.log('Estado actualizado');
              }
            });


        });
    </script>
<?php endif; ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Bienvenido</h1>
          </div><!-- /.col -->         
        </div><!-- /.row -->
        

        <div class="row">
          <div class="col-3"></div>
          <div class="col-md-6">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo $URL."/admin/usuarios/".$foto_perfil;?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $nombre." ".$ap_paterno." ".$ap_materno?></h3>

                <p class="text-muted text-center"><?php echo $cargo?></p>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Datos Personales</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Cedula de Identidad</strong>

                <p class="text-muted">
                  <?php echo $ci?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Direccion</strong>

                <p class="text-muted"><?php echo $direccion?></p>

                <hr>
               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-3"></div>
        </div>
        
        <section class="content">
          <div class="container-fluid">
              <!-- Small boxes (Stat box) -->
              <div class="row">


              <?php 
                $sql = $pdo->prepare("SELECT COUNT(*) as vendido_contado FROM tb_contado con INNER JOIN tb_comprador comp WHERE comp.id_usuario_fk=$id_usuario AND comp.id_comprador=con.id_comprador_fk");
                $sql->execute();
                $venta_contado=$sql->fetch(PDO::FETCH_ASSOC);

              ?>

              <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-success">
                  <div class="inner">
                      <h3><?php echo $venta_contado['vendido_contado']?></h3>

                      <p>Ventas al Contado</p>
                  </div>
                  <div class="icon">
                      <svg  width="103" height="103"  viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="a" gradientUnits="userSpaceOnUse" x1="114.244" x2="21.876" y1="106.124" y2="13.756"><stop offset="0" stop-color="#f87c68"></stop><stop offset="1" stop-color="#fcc440"></stop></linearGradient><path d="m4.557 31.8a1.75 1.75 0 0 1 1.75-1.75h19.639a1.75 1.75 0 1 1 0 3.5h-19.639a1.749 1.749 0 0 1 -1.75-1.75zm118.886 13.635v50.765a1.75 1.75 0 0 1 -1.75 1.75h-15.313a1.75 1.75 0 0 1 0-3.5h13.563v-47.265h-41.73a7.9 7.9 0 0 1 1.27 3.3h28.541a1.75 1.75 0 0 1 1.75 1.75 5.127 5.127 0 0 0 5.121 5.122 1.75 1.75 0 0 1 1.75 1.75v23.424a1.749 1.749 0 0 1 -1.75 1.75 5.127 5.127 0 0 0 -5.121 5.121 1.749 1.749 0 0 1 -1.75 1.75h-58.173a1.749 1.749 0 0 1 -1.751-1.752 5.127 5.127 0 0 0 -5.122-5.121 1.75 1.75 0 0 1 -1.75-1.75v-14.576a25.756 25.756 0 0 1 -3.3.422v26.075h45.059a1.75 1.75 0 0 1 0 3.5h-46.8a1.75 1.75 0 0 1 -1.75-1.75v-27.825a22.585 22.585 0 0 1 -17.021-8.8h-11.109a1.75 1.75 0 1 1 0-3.5h12.031a1.752 1.752 0 0 1 1.508.861c.192.321 4.938 8.007 16.337 8.007s16.144-7.686 16.34-8.013a1.763 1.763 0 0 1 1.5-.855h17.61a4.443 4.443 0 0 0 0-8.885h-17.606a1.75 1.75 0 0 1 0-3.5h31.319l-8.031-8.031a7.137 7.137 0 0 0 -5.08-2.1h-36.925a1.75 1.75 0 0 1 0-3.5h36.925a10.615 10.615 0 0 1 7.555 3.13l10.51 10.496h31.4a1.75 1.75 0 0 1 1.743 1.75zm-55.987 25.382a11.482 11.482 0 1 0 11.481-11.481 11.494 11.494 0 0 0 -11.481 11.481zm39-16.835h-27.237a7.911 7.911 0 0 1 -.881 1.884c.2-.008.4-.03.6-.03a15.035 15.035 0 1 1 -9.863 3.734h-14.122a21.984 21.984 0 0 1 -10.224 7.436v13.954a8.647 8.647 0 0 1 6.693 6.692h55.031a8.646 8.646 0 0 1 6.692-6.692v-20.285a8.646 8.646 0 0 1 -6.692-6.693zm-9.732 40.468h-4.5a1.75 1.75 0 0 0 0 3.5h4.5a1.75 1.75 0 0 0 0-3.5zm-18.749-18.895v-3.55c-2.673-.685-4.513-1.647-4.513-4.235 0-2.439 1.8-4.193 4.513-4.535v-1.326h2.075v1.348a8.127 8.127 0 0 1 4.6 1.967l-1.65 2.268a7.376 7.376 0 0 0 -2.951-1.476v3.422c3.016.684 5.005 1.647 5.005 4.3 0 2.609-1.84 4.406-5.005 4.641v1.348h-2.074v-1.413a9.266 9.266 0 0 1 -5.155-2.352l1.818-2.162a7.744 7.744 0 0 0 3.337 1.755zm2.075.128c1.2-.149 1.818-.812 1.818-1.6 0-.813-.513-1.2-1.818-1.561zm-2.075-6.8v-2.91a1.572 1.572 0 0 0 -1.326 1.476c0 .706.385 1.112 1.326 1.433z" fill="url(#a)" style="fill: rgb(34, 142, 59);"></path></svg>
                  </div>
                  <a href="#" class="small-box-footer">Ver tus Ventas <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>



              <!-- ./col -->
              <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                  <div class="inner">
                      <h3><?php echo $venta_contado['vendido_contado']?></h3>

                      <p>Ventas al Semicontado</p>
                  </div>
                  <div class="icon">
                     
                      <svg class="mt-2" width="65" height="65" id="Capa_1" enable-background="new 0 0 510 510" viewBox="0 0 510 510" xmlns="http://www.w3.org/2000/svg"><g><path d="m90 180h150v30h-150z" fill="#000000" style="fill: rgb(20, 138, 157);"></path><path d="m420 210h30v30h-30z" fill="#000000" style="fill: rgb(20, 138, 157);"></path><path d="m360 210h30v30h-30z" fill="#000000" style="fill: rgb(20, 138, 157);"></path><path d="m300 210h30v30h-30z" fill="#000000" style="fill: rgb(20, 138, 157);"></path><path d="m465 0h-390c-24.813 0-45 20.187-45 45v210c0 9.434 2.994 18.457 8.27 25.933-23.668 24.331-38.27 57.523-38.27 94.067 0 74.44 60.561 135 135 135 43.269 0 81.844-20.465 106.566-52.221l52.221 52.221h216.213v-30h-203.787l-48.583-48.583c19.426-42.057 16.025-91.963-10.436-131.417h217.806c24.813 0 45-20.186 45-45v-210c0-24.813-20.187-45-45-45zm-390 30h390c8.271 0 15 6.729 15 15v15h-420v-15c0-8.271 6.729-15 15-15zm405 60v30h-420v-30zm-345 390c-57.897 0-105-47.103-105-105s47.103-105 105-105 105 47.103 105 105-47.103 105-105 105zm330-210h-245.252c-45.845-37.075-109.687-39.759-158.136-8.256-1.041-2.061-1.612-4.365-1.612-6.744v-105h420v105c0 8.272-6.729 15-15 15z" fill="#000000" style="fill: rgb(20, 138, 157);"></path><path d="m150 300h-30v83.027l51.68 34.453 16.64-24.96-38.32-25.547z" fill="#000000" style="fill: rgb(20, 138, 157);"></path><path d="m329.989 420h30v30h-30z" fill="#000000" style="fill: rgb(20, 138, 157);"></path><path d="m389.994 420.002h120.006v30h-120.006z" fill="#000000" style="fill: rgb(20, 138, 157);"></path><path d="m329.989 360h30v30h-30z" fill="#000000" style="fill: rgb(20, 138, 157);"></path><path d="m389.994 360.002h120.006v30h-120.006z" fill="#000000" style="fill: rgb(20, 138, 157);"></path></g></svg>
                     
                       
                  </div>
                  <a href="#" class="small-box-footer">Ver tus Ventas <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                  <div class="inner">
                      <h3><?php echo $venta_contado['vendido_contado']?></h3>

                      <p>Ventas a Credito</p>
                  </div>
                  <div class="icon">
                      <!-- <i class="ion ion-person-add"></i> -->
                      <svg class="mt-2" width="70" height="70"  enable-background="new 0 0 72 72" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg"><g id="Layer_16"><g><path d="m63 5h-44c-.552 0-1-.448-1-1s.448-1 1-1h44c.552 0 1 .448 1 1s-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m14 55c-.552 0-1-.447-1-1v-45c0-.552.448-1 1-1s1 .448 1 1v45c0 .553-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m53 69h-44c-.552 0-1-.447-1-1s.448-1 1-1h44c.552 0 1 .447 1 1s-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m58 64c-.552 0-1-.447-1-1v-54c0-.552.448-1 1-1s1 .448 1 1v54c0 .553-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m68 23h-10c-.552 0-1-.448-1-1s.448-1 1-1h9v-12c0-2.206-1.794-4-4-4s-4 1.794-4 4c0 .552-.448 1-1 1s-1-.448-1-1c0-3.309 2.691-6 6-6s6 2.691 6 6v13c0 .552-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m53 69c-3.309 0-6-2.691-6-6v-8h-42v8c0 2.206 1.794 4 4 4 .552 0 1 .447 1 1s-.448 1-1 1c-3.309 0-6-2.691-6-6v-9c0-.553.448-1 1-1h44c.552 0 1 .447 1 1v9c0 2.206 1.794 4 4 4s4-1.794 4-4c0-.553.448-1 1-1s1 .447 1 1c0 3.309-2.691 6-6 6z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m14 10c-.552 0-1-.448-1-1 0-3.309 2.691-6 6-6 .552 0 1 .448 1 1s-.448 1-1 1c-2.206 0-4 1.794-4 4 0 .552-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m61 29c-.552 0-1-.448-1-1v-1c0-.552.448-1 1-1s1 .448 1 1v1c0 .552-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m61 44c-.552 0-1-.447-1-1v-11c0-.552.448-1 1-1s1 .448 1 1v11c0 .553-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m11 25c-.552 0-1-.448-1-1v-7c0-.552.448-1 1-1s1 .448 1 1v7c0 .552-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m11 32c-.552 0-1-.448-1-1v-3c0-.552.448-1 1-1s1 .448 1 1v3c0 .552-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m11 36c-.552 0-1-.448-1-1v-1c0-.552.448-1 1-1s1 .448 1 1v1c0 .552-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m11 52c-.552 0-1-.447-1-1v-1c0-.553.448-1 1-1s1 .447 1 1v1c0 .553-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m11 48c-.552 0-1-.447-1-1v-2c0-.553.448-1 1-1s1 .447 1 1v2c0 .553-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m61 57c-.552 0-1-.447-1-1v-1c0-.553.448-1 1-1s1 .447 1 1v1c0 .553-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><g><path d="m61 65c-.552 0-1-.447-1-1v-5c0-.553.448-1 1-1s1 .447 1 1v5c0 .553-.448 1-1 1z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g><path d="m36 10c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm-19-18-3 3v47h34v10l2 3 4 1 4-3v-57l2-3 2-1zm5 41h4c.55 0 1 .45 1 1s-.45 1-1 1h-4c-.55 0-1-.45-1-1s.45-1 1-1zm-1-3c0-.55.45-1 1-1h4c.55 0 1 .45 1 1s-.45 1-1 1h-4c-.55 0-1-.45-1-1zm1 7h4c.55 0 1 .45 1 1s-.45 1-1 1h-4c-.55 0-1-.45-1-1s.45-1 1-1zm7 1c0-.55.45-1 1-1h20c.55 0 1 .45 1 1s-.45 1-1 1h-20c-.55 0-1-.45-1-1zm1-5h20c.55 0 1 .45 1 1s-.45 1-1 1h-20c-.55 0-1-.45-1-1s.45-1 1-1zm-1-3c0-.55.45-1 1-1h20c.55 0 1 .45 1 1s-.45 1-1 1h-20c-.55 0-1-.45-1-1zm7-4c-8.27 0-15-6.73-15-15s6.73-15 15-15 15 6.73 15 15-6.73 15-15 15zm0-28c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3zm0-12c-7.17 0-13 5.83-13 13s5.83 13 13 13 13-5.83 13-13-5.83-13-13-13zm0 12c2.76 0 5 2.24 5 5 0 2.42-1.72 4.44-4 4.9v1.1c0 .55-.45 1-1 1s-1-.45-1-1v-1.1c-2.28-.46-4-2.48-4-4.9 0-.55.45-1 1-1s1 .45 1 1c0 1.65 1.35 3 3 3s3-1.35 3-3-1.35-3-3-3c-2.76 0-5-2.24-5-5 0-2.42 1.72-4.44 4-4.9v-1.1c0-.55.45-1 1-1s1 .45 1 1v1.1c2.28.46 4 2.48 4 4.9 0 .55-.45 1-1 1s-1-.45-1-1c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3z" fill="#000000" style="fill: rgb(217, 164, 1);"></path></g></svg>
                  </div>
                  <a href="#" class="small-box-footer">Ver tus Ventas <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                  <div class="inner">
                      <h3><?php echo $venta_contado['vendido_contado']?></h3>

                      <p>Liberaciones</p>
                  </div>
                  <div class="icon">
                      <!-- <i class="ion ion-pie-graph"></i> -->
                       <svg width="95" height="95" id="Layer_1" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"><path d="m17 6h30v40h-30z" fill="#1d3557" style="fill: rgb(216, 111, 121);"></path><path d="m20 9h24v34h-24z" fill="#a8dadc" style="fill: rgb(240, 183, 189);"></path><circle cx="32" cy="26" fill="#f1faee" r="8"></circle><path d="m32 25c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1h2c0-1.3-.84-2.4-2-2.82v-1.18h-2v1.18c-1.16.41-2 1.51-2 2.82 0 1.65 1.35 3 3 3 .55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1h-2c0 1.3.84 2.4 2 2.82v1.18h2v-1.18c1.16-.41 2-1.51 2-2.82 0-1.65-1.35-3-3-3z" fill="#457b9d" style="fill: rgb(172, 93, 93);"></path><path d="m35 54v-9l-5-3 1-4 6 3v-17h4v14h7c1.1 0 2 .9 2 2v9l-3 2v3" fill="#457b9d" style="fill: rgb(172, 93, 93);"></path><path d="m34 54h14v4h-14z" fill="#1d3557" style="fill: rgb(216, 111, 121);"></path><path d="m28 11h4v2h-4z" fill="#f1faee"></path><path d="m34 11h2v2h-2z" fill="#f1faee"></path><g fill="#e63946"><path d="m56 35v-12h2l-4-6-4 6h2v12" fill="#e63946"></path><path d="m12 35v-12h2l-4-6-4 6h2v12" fill="#e63946"></path></g></svg>
                  </div>
                  <a href="#" class="small-box-footer">Ver tus Liberaciones <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              </div>
          </div>
        </section>

      </div><!-- /.container-fluid -->
    </div>
  </div>
<?php   include ('../layout/admin/parte2.php'); ?>