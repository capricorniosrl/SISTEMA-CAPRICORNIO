<!DOCTYPE html>

<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Intranet</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo $URL;?>/public/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $URL;?>/public/dist/css/adminlte.min.css">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- jQuery -->
<script src="<?php echo $URL;?>/public/plugins/jquery/jquery.min.js"></script>

  <!-- datatable -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />  
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- animateCSS -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/> -->
  
  <!-- driver.js -->
  <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>

<link rel="shortcut icon" href="<?php echo $URL?>/public/img/ICONO.ico" type="image/x-icon">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-dark bg-dark" >
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo $URL;?>/admin" class="nav-link">Inicio</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown" >
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments fa-lg" id="mensaje"></i>


          <?php
            $query=$pdo->prepare("SELECT con.id_contacto, con.id_usuario_fk, con.celular, con.created_at, con.detalle, cli.fecha_llamada, cli.hora_llamada, cli.nombres, cli.apellidos, cli.id_cliente, cli.nombres, cli.apellidos, cli.detalle FROM tb_contactos con INNER JOIN tb_clientes cli WHERE
            (((con.id_contacto=cli.id_contacto_fk) AND cli.detalle_llamada='CONTESTO') AND cli.reprogramar='SI') AND cli.id_usuario_fk='$id_usuario'");

            $query->execute();
            

            $usuarios=$query->fetchAll(PDO::FETCH_ASSOC);

            $contador = 0;
            foreach ($usuarios as $usuario){
              $contador++;
            }

            if ($contador!=0) {
            ?>
              <span class="badge badge-danger navbar-badge"><?php echo $contador?></span>
            <?php
            }
            
          ?>




          
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        
        
          
          
        
        


        <div class="dropdown-divider"></div>
            
          <div class="dropdown-divider"></div>
            <?php
              $query=$pdo->prepare("SELECT con.id_contacto, con.id_usuario_fk, con.celular, con.created_at, con.detalle, cli.fecha_llamada, cli.hora_llamada, cli.nombres, cli.apellidos, cli.id_cliente, cli.nombres, cli.apellidos, cli.detalle FROM tb_contactos con INNER JOIN tb_clientes cli WHERE
              (((con.id_contacto=cli.id_contacto_fk) AND cli.detalle_llamada='CONTESTO') AND cli.reprogramar='SI') AND cli.id_usuario_fk='$id_usuario' ORDER BY fecha_llamada, hora_llamada ASC LIMIT 3");

              $query->execute();
              

              $usuarios=$query->fetchAll(PDO::FETCH_ASSOC);

              $contador = 0;
              foreach ($usuarios as $usuario) {

              $id = $usuario['id_contacto'];


            ?>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                
                <div class="media-body">
                
                  <h4 class="dropdown-item-title">
                     <?php echo $usuario['celular']?>
                    <span class="float-right text-sm text-warning"><i class="fas fa-phone text-success"></i></span>
                  </h4>
                  <p class=""><i class="far fa-clock mr-1 text-info"></i><?php echo $usuario['fecha_llamada']?> <strong>a horas</strong>  <?php echo $usuario['hora_llamada']?> </p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
          <?php
          }
          ?>
          
          
          <a href="<?php echo $URL?>/admin/clientes/reprogramar.php" class="dropdown-item dropdown-footer bg-primary">Ver todos los mensajes</a>
        </div>


      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown" >
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user fa-lg" id="configuracion"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">Configuracion de Uusuario</span>

          <div class="dropdown-divider"></div>
          <a href="<?php echo $URL?>/admin/usuarios/config/configurar_usuario.php" class="dropdown-item">
            <i class="fas fa-cog mr-2"></i> Gestionar Usuario
          </a>
          <a href="<?php echo $URL?>/admin/contraseña" class="dropdown-item">
            <i class="fas fa-unlock-alt mr-2"></i> Gestionar Contraseña
          </a>

          <div class="dropdown-divider "></div>
          <a href="<?php echo $URL?>/login/controller_cerrar_session.php" class="dropdown-item dropdown-footer ">
          CERRAR SESSION
          <svg style="height: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
        </a>
        </div>
      </li>
      <li class="nav-item" >
        <a class="nav-link" data-widget="fullscreen" href="#" role="button" >
          <i class="fas fa-expand-arrows-alt" id="pantalla_completa"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo $URL;?>/admin" class="brand-link">
      <img src="<?php echo $URL;?>/public/img/ICONO.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light">CAPRICORNIO s.r.l.</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $URL."/admin/usuarios/".$foto_perfil;?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $nombre." ".$ap_paterno." ".$ap_materno?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2" id="panel_guia">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          
          <?php if (isset($_SESSION['session_cargo'])) {?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              
              <i class="nav-icon fas fa-id-card"></i>
              <p> 
                Cargos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/cargos" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registrar Cargo</p>
                </a>
              </li>
            </ul>
          </li>

          <?php             
          }else {
            unset($_SESSION['session_cargo']);
          }   
          if (isset($_SESSION['session_funciones'])) {     
          ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              
            <i class="nav-icon fas fa-tasks"></i>
              <p> 
                Funciones
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/funciones" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Asignar Funciones</p>
                </a>
              </li>
            </ul>
          </li>
          <?php             
          }   else {
            unset($_SESSION['session_funciones']);
          }
          if (isset($_SESSION['session_urbanizaciones'])) {     
          ?>
          <li class="nav-item">
            <a href="#" class="nav-link ">
              
            <i class="nav-icon fas fa-layer-group"></i>
              <p> 
                Urbanizaciones
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/urbanizacion" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registrar Urbanizacion</p>
                </a>
              </li>
            </ul>
          </li>
          <?php             
          }  else {
            unset($_SESSION['session_urbanizaciones']);
          } 
          if (isset($_SESSION['session_usuarios'])) {     
          ?>









          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Usuarios
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/usuarios" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado de Usuarios</p>
                </a>
              </li>
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nuevo Usuario</p>
                </a>
              </li>
            </ul>
          </li>






          
          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-key"></i>
              <p>
                Restaurar Contraseña
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/contraseña/buscar.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buscar al Usuario</p>
                </a>
              </li>
            </ul>
          </li>
          <?php             
          }   
          else {
            unset($_SESSION['session_usuarios']);
          }
          if (isset($_SESSION['session_reg_clientes'])) {     
          ?>
          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Clientes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/clientes/" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nuevo Contacto</p>
                </a>
              </li>
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/clientes/sin_responder.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contactos sin Responder</p>
                </a>
              </li>
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/clientes/reprogramar.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reprogramar Llamada</p>
                </a>
              </li>
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/clientes/sin_interes.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Clientes No Interesados</p>
                </a>
              </li>             
            </ul>
          </li>
          <?php             
          }   else {
            unset($_SESSION['session_reg_clientes']);
          }
          if (isset($_SESSION['session_age_clientes'])) {     
          ?>
          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-address-book"></i>
              <p>
                Agendadas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/agendar/listar.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lista Clientes Agendadas</p>
                </a>
              </li>
            </ul>
          </li>
          <?php             
          }   else {
            unset($_SESSION['session_age_clientes']);
          }
          if (isset($_SESSION['session_reservas'])) {     
          ?>
          <li class="nav-item ">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-map-marked-alt"></i>
              <p>
                Reserva
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/reserva/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lista de Reservas</p>
                </a>
              </li>
            </ul>
          </li>
          <?php             
          } else {
            unset($_SESSION['session_reservas']);
          }  
          if (isset($_SESSION['session_designar'])) {     
          ?>
          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Buscar y Designar
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/agendar/control.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listar</p>
                </a>
              </li> 
            </ul>
          </li>
          <?php             
          }  else {
            unset($_SESSION['session_designar']);
          }  
          if (isset($_SESSION['session_reportes'])) {     
          ?>
          <li class="nav-item ">
            
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Generar Reportes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">


              <li class="ml-3 nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon "></i>
                  <p>
                    Clientes Agendadas
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="ml-3 nav-item">
                    <a href="<?php echo $URL;?>/admin/reporte/reporte_asesor.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Por Asesor</p>
                    </a>
                  </li>
                  <li class="ml-3 nav-item">
                    <a href="<?php echo $URL;?>/admin/reporte/reporte_urbanizacion.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Por Urbanizacion</p>
                    </a>
                  </li>
                  <li class="ml-3 nav-item">
                    <a href="<?php echo $URL;?>/admin/reporte/reporte_general.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>General</p>
                    </a>
                  </li>
                </ul>
              </li>

              

              <li class="ml-3 nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon "></i>
                  <p>
                    Clientes con reserva
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="ml-3 nav-item">
                    <a href="<?php echo $URL;?>/admin/reporte/reporte_cliente_reserva.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Por Asesor</p>
                    </a>
                  </li>
                  <li class="ml-3 nav-item">
                    <a href="<?php echo $URL;?>/admin/reporte/reporte_urbanizacion_reserva.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Por Urbanizacion</p>
                    </a>
                  </li>
                  <li class="ml-3 nav-item">
                    <a href="<?php echo $URL;?>/admin/reporte/reporte_general_reserva.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>General</p>
                    </a>
                  </li>
                </ul>
              </li>



            </ul>
          </li>
          <?php             
          } else {
            unset($_SESSION['session_reportes']);
          }   
          ?>

          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Cierres
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/contado/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contado</p>
                </a>
              </li> 
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/semi-contado/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Semi Contado</p>
                </a>
              </li> 
            </ul>
          </li>


          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-solid fa-file"></i>
              <p>
                Reportes
              </p>
            </a>
          </li> -->











          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-ship"></i>
              <p>
                Importaciones
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/importacion/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registrar Cliente</p>
                </a>
              </li> 
              <li class="ml-3 nav-item">
                <a href="<?php echo $URL;?>/admin/importacion/listar.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listar Clientes</p>
                </a>
              </li>
            </ul>
          </li>




        </ul>
      </nav>

    

      <!-- MODO OSCURO -->
      <div class="navbar-nav ml-auto" id="modo_oscuro_guia">
        <li class="nav-item">
          <button id="dark-mode-toggle" class="nav-link" role="button">
            <i id="dark-mode-icon" class="fas fa-sun"></i> <!-- Sol por defecto -->
          </button>
        </li>
      </div>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>