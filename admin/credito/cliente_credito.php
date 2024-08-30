<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
?>
<?php include ('../../layout/admin/parte1.php'); ?>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />


<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">DETALLES DEL CLIENTE - CREADITO</h1>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DETALLES</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-3 col-md-6 col-sm-12">




                            <?php $id_comprado=$_GET['variable'];



                            
                            $sql=$pdo->prepare("SELECT * FROM tb_credito cre
                            INNER JOIN tb_comprador comp
                            INNER JOIN tb_usuarios us
                            INNER JOIN tb_agendas ag
                            INNER JOIN tb_clientes cli
                            INNER JOIN tb_contactos con
                            INNER JOIN tb_informe info
                            WHERE (((((((cre.id_comprador_fk=comp.id_comprador) AND comp.id_usuario_fk=us.id_usuario) AND ag.id_usuario_fk=us.id_usuario) AND info.id_agenda_fk=ag.id_agenda) AND ag.id_cliente_fk=cli.id_cliente) AND cli.id_contacto_fk=con.id_contacto) AND cli.id_usuario_fk=us.id_usuario)
                            AND (comp.id_comprador=:id_comprador) AND con.celular=comp.celular_1");

                            $sql->bindParam(':id_comprador',$id_comprado);

                            $sql->execute();
                            $datos=$sql->fetch(PDO::FETCH_ASSOC);

                            
                            
                            ?>
                            <h5 class=""> <b>DATOS DEL CLIENTE</b> </h5>
                            <hr class="text-primary bg-primary" style="height: 3px;">
                          
                            <dl class="row">

                              <dt class="col-sm-3">NOMBRE COMPLETO:</dt>
                              <dd class="col-sm-9"><?php echo $datos['nombre_1']." ".$datos['ap_paterno_1']." ".$datos['ap_materno_1']?></dd>

                              <dt class="col-sm-3">CI:</dt>
                              <dd class="col-sm-9"><?php echo $datos['ci_1']." ".$datos['exp_1']?></dd>

                              <dt class="col-sm-3">CELULAR:</dt>
                              <dd class="col-sm-9"><?php echo $datos['celular_1']?></dd>   
                            
                            </dl>
                            <?php
                                if ($datos['nombre_2']) {
                                ?> 
                                <hr class="text-secondary bg-secondary" style="height: 0.1px;">

                                <dl class="row">

                                <dt class="col-sm-3">NOMBRE COMPLETO:</dt>
                                <dd class="col-sm-9"><?php echo $datos['nombre_2']." ".$datos['ap_paterno_2']." ".$datos['ap_materno_2']?></dd>

                                <dt class="col-sm-3">CI:</dt>
                                <dd class="col-sm-9"><?php echo $datos['ci_2']." ".$datos['exp_2']?></dd>

                                <dt class="col-sm-3">CELULAR:</dt>
                                <dd class="col-sm-9"><?php echo $datos['celular_2']?></dd>   

                                </dl>
                                <?php  
                                }                                
                            ?>

                        </div>
                        <div class="col-12 col-lg-3 col-md-6 col-sm-12">
                            <h5 > <b>DATOS DE LA URBANIZACION</b> </h5>
                            <hr class="text-primary bg-primary" style="height: 3px;">
                            <dl class="row">

                              <dt class="col-sm-4">URBANIZACION:</dt>
                              <dd class="col-sm-8"><?php echo $datos['urbanizacion']?></dd>
                              
                              <dt class="col-sm-4">LOTE:</dt>
                              <dd class="col-sm-8"><?php echo $datos['lote']?></dd>

                              <dt class="col-sm-4">MANZANO:</dt>
                              <dd class="col-sm-8"><?php echo strtoupper($datos['manzano'])?></dd> 

                              <dt class="col-sm-4">SUPERFICIE:</dt>
                              <dd class="col-sm-8"><?php echo $datos['superficie']." Mts<sup>2</sup>"?></dd> 
                            </dl>
                        </div>
                        <div class="col-12 col-lg-6 col-md-12 col-sm-12">
                            <h5> <b> DETALLES DE LA VENTA </b> </h5>
                          
                            <hr class="text-primary bg-primary" style="height: 3px;">
                            <dl class="row">
                                <dt class="col-sm-4">PRECIO DE VENTA ACORDADO:</dt>
                                <dd class="col-sm-8"><?php echo $datos['monto_dolar']." Dólares"?></dd>

                                <dt class="col-sm-4">TIPO CAMBIO:</dt>
                                <dd class="col-sm-8"><?php echo  "1 $"."us. = ". $datos['tipo_cambio']." Bs."?></dd>

                                <dt class="col-sm-4">CUOTA INICIAL:</dt>
                                <dd class="col-sm-8"><?php echo $datos['cuota_inicial']." Dólares"?></dd>

                                <dt class="col-sm-4">RESERVA TERRENO:</dt>
                                
                                <dd class="col-sm-8"><?php echo $datos['monto']."Bs = ".round($datos['monto']/$datos['tipo_cambio'],2)." Dólares"?></dd>

                                <?php

                                $id_credito=$datos['id_credito'];

                                $sql2=$pdo->prepare("SELECT  COUNT(*) as cuotas FROM tb_credito cre INNER JOIN tb_comprador comp INNER JOIN tb_cuotas_credito cu WHERE ((cre.id_comprador_fk=comp.id_comprador) AND comp.id_comprador='$id_comprado') AND cu.id_credito_fk='$id_credito'");

                                $sql2->execute();
                                $dato2=$sql2->fetch(PDO::FETCH_ASSOC);

                                ?>

                                <dt  class="col-sm-4">INTERES ACORDADO:</dt>
                                <dd class="col-sm-8"> <span class='badge badge-primary'style='font-size: 16px;'> <?php echo $datos['cuota_interes']."</span> Dólares"?></dd> 

                                <dt  class="col-sm-4">Nro. CUOTAS A CANCELAR:</dt>

                                <?php
                                $reserva=round($datos['monto']/$datos['tipo_cambio'],2);
                                $cuota_inicial=$datos['cuota_inicial'];
                                $total= ((($datos['monto_dolar']+$datos['cuota_interes'])-$datos['cuota_inicial'])-$reserva)/$dato2['cuotas'];
                                
                                ?>

                                <dd class="col-sm-8"><?php echo $dato2['cuotas']." Coutas de
                                <span class='badge badge-danger'style='font-size: 16px;''>". round($total,2)."
                                </span> Dolares Incluido el Interes" ?></dd> 


                               



                                <dt class="col-sm-4">FECHA INICIO:</dt>
                                <dd class="col-sm-8"><?php echo date("d/m/Y", strtotime($datos['fecha_registro']))?></dd> 
                                <dt class="col-sm-4">FECHA FIN:</dt>

                                <?php
                                  $sumar = $dato2['cuotas'];
                                  $fecha_act = $datos['fecha_registro'];
                                  $timestamp = strtotime($fecha_act);
                                  $timestamp_nueva = strtotime("+$sumar months", $timestamp);
                                  $fecha_nueva = date('Y-m-d', $timestamp_nueva);

                                ?>
                                

                                <dd class="col-sm-8"><?php echo date("d/m/Y", strtotime($fecha_nueva))?></dd> 
                            </dl>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="row">
        <div class="col-sm-12 col-md-8 col-12 col-lg-8">
          <section class="content">
            <div class="container-fluid">
              <div class="row justify-content-center">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">PAGOS REALIZADOS</h3>
                        <div class="card-tools">
                          <a class="btn btn-primary "  id="btnAgregarCuota" data-id="<?php echo $datos['id_credito']; ?>">
                              <i class="fas fa-plus"></i> Cuota
                          </a>
                       
                            <script>
                                $(document).ready(function() {
                                    $('#btnAgregarCuota').click(function(e) {
                                        e.preventDefault(); // Evita el comportamiento predeterminado del enlace
                                        
                                        var idCredito = $(this).data('id');
                                        
                                        $.ajax({
                                            url: 'agregar_cuota_credito.php',
                                            type: 'POST',
                                            data: { id_credito: idCredito },
                                            success: function(response) {
                                                // Muestra el toast de SweetAlert2
                                                Swal.fire({
                                                    toast: true,
                                                    position: 'top-end',
                                                    icon: 'success',
                                                    title: 'Cuota agregada exitosamente',
                                                    showConfirmButton: false,
                                                    timer: 1000,
                                                    timerProgressBar: true,
                                                    didOpen: (toast) => {
                                                        toast.addEventListener('mouseenter', Swal.stopTimer);
                                                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                                                    }
                                                }).then(() => {
                                                    // Después de que el toast ha terminado de mostrarse, recarga la página
                                                    location.reload();
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error:', error);
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Ocurrió un error',
                                                    text: 'No se pudo agregar la cuota.',
                                                    confirmButtonText: 'Aceptar'
                                                });
                                            }
                                        });
                                    });
                                });
                            </script>



                          <a target="_blank" href="../reporte_credito/index.php?id=<?php echo $id_comprado?>">Reporte General <img src="../../public/img/print.ico" alt="" height="45px"></a>
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        
                        <table class="table table-striped scr" id="tabla_cuotas">                 
                            <thead>
                              <tr>
                                <th>Nro.</th>
                                <th>Cuota</th>
                                <th>Cuota Inicial</th>
                                <th>Saldo a Cancelar</th>
                              </tr>                            
                            </thead>  

                            <tbody>

                              <tr>
                                <th scope="row"> Cuota Inicial </th>

                                <td><?php echo date("d/m/Y", strtotime($datos['fecha_registro']))?></td>


                                <td><?php echo $datos['cuota_inicial']." $"?></td>
                       

                                <td><?php
                                $monto_cancelar=($datos['monto_dolar']-$datos['cuota_inicial'])-round($datos['monto']/$datos['tipo_cambio'],2);
                                echo $monto_cancelar." Dólares"
                                ?></td>

                              </tr>

                              <?php
                              // Preparar y ejecutar la consulta
                              $sql3 = $pdo->prepare("SELECT cu.nueva_cuota, cu.tipo_pago,cu.numero_recibo, cu.fecha_registro_pago, cu.id_cuota, cu.nombre_cuota, cu.monto FROM tb_credito cre INNER JOIN tb_comprador comp INNER JOIN tb_cuotas_credito cu WHERE ((cre.id_comprador_fk=comp.id_comprador) AND comp.id_comprador='$id_comprado') AND cu.id_credito_fk='$id_credito'");
                              $sql3->execute();
                              $contador = 0;
                              $dato3 = $sql3->fetchAll(PDO::FETCH_ASSOC);

                              // Crear un objeto DateTime para manejar la fecha
                              $fechaInicial = new DateTime($datos['fecha_registro']);

                              // Crear un array con los nombres de los meses en español
                              $meses = [
                                  1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5 => 'MAYO', 6 => 'JUNIO',
                                  7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'
                              ];

                              $suma_cuotas=0;

                              foreach ($dato3 as $valor) {
                                  $contador++;

                                  
                                  $suma_cuotas=$suma_cuotas+$valor['monto'];
                                  
                                  // Sumar un mes para la próxima iteración
                                  $fechaInicial->modify('+1 month');
                                  
                                  // Obtener el mes y el año de la fecha actual
                                  $mes = $fechaInicial->format('n'); // 'n' da el número del mes sin ceros iniciales
                                  $anio = $fechaInicial->format('Y');
                                  
                                  // Obtener el nombre del mes usando el array
                                  $nombreMes = $meses[$mes];
                                  
                                  // Formatear la fecha en el formato deseado
                                  $fechaFormateada = $nombreMes . '-' . $anio;

                                  // Imprimir los datos en la tabla
                                  ?>
                                  <tr>

                                      <?php
                                      if ($valor['nueva_cuota']==0 ) {
                                      ?>
                                      <th scope="row"><?php echo $valor['nombre_cuota']; ?> </th>
                                      <?php
                                      } else {
                                      ?>
                                      <th scope="row"><?php echo $valor['nombre_cuota']; ?>  <span class="badge badge-pill badge-primary">Cuota nueva Agregado</span></th>
                                      <?php
                                      }
                                      
                                      ?>

                                      




                                      <td><?php echo $fechaFormateada; ?></td>
                                      
                                      <?php
                                      if ($valor['monto']) {
                                        echo "<td class='bg-success'>";
                                          echo $valor['monto']." Dolares";
                                          ?>
                                          <a class=""  data-toggle="collapse" href="#detalles<?php echo $contador; ?>"><i class="fas fa-eye text-dark pl-2"></i></a>
                                          <div class="collapse" id="detalles<?php echo $contador; ?>">
                                              <div class="card card-body text-dark">
                                                <p>Detalles del Pago <span class="text-danger"> <strong> Cod. <?php echo $valor['id_cuota'] ?> </strong></span> </p>
                                                <dl>
                                                  <dt>Monto</dt>
                                                  <dd><?php echo $valor['monto'] ?></dd>

                                                  <dt>Tipo de Pago</dt>
                                                  <dd><?php echo $valor['tipo_pago'] ?></dd>

                                                  <dt>Numero Recibo</dt>
                                                  <dd><?php echo $valor['numero_recibo'] ?></dd>

                                                  <dt>Fecha de Pago</dt>
                                                  <dd><?php echo $valor['fecha_registro_pago'] ?></dd>
                                                </dl>
                                                <a target="_blank" class="btn btn-danger btn-block" href="../reporte_credito/pagos_cuotas.php?id=<?php echo $id_comprado?>&id_cuota=<?php echo $valor['id_cuota']?>">GENERAR PDF</a>
                                              </div>
                                          </div>
                                          <?php
                                        echo "</td>";
                                      }
                                      else {
                                        echo "<td class='badge badge-pill badge-danger'>";
                                        echo "SIN CANCELAR";
                                        echo "</td>";
                                      }
                                      
                                      
                                      ?>

                                      
                                      <td>                                        
                                        <?php
                                        if ($valor['monto'] ) {
                                          if (($monto_cancelar-$suma_cuotas)<1) {
                                            echo "SALDO CANCELADO";
                                          ?>
                                            <script>
                                                function bloquear(){
                                                    document.getElementById('monto_cancelar').disabled = true;
                                                    document.getElementById('recibo').disabled = true;
                                                    document.getElementById('tipo_pago').disabled = true;
                                                    document.getElementById('id_cuota').disabled = true;
                                                    document.getElementById('fechaActual').disabled = true;
                                                    document.getElementById('registrar').disabled = true;
                                                    $('#btnAgregarCuota').addClass('disabled');

                                                }

                                                // Llama a la función cuando el documento esté listo
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    bloquear();
                                                });
                                            </script>
                                          <?php
                                            
                                          }
                                          else {
                                            echo $monto_cancelar-$suma_cuotas." Dólares";
                                          }
                                          
                                        }
                                        
                                        ?>
                                      </td>

                                  </tr>                                 
                                  
                                  <?php
                                  

                              }
                              ?>
                              <tr>
                                <td colspan="2">
                                    <b>TOTAL</b>
                                </td>
                                <td >
                                    <b><?php echo round($suma_cuotas+$datos['cuota_inicial']+$reserva,0)." Dólares" ?></b>
                                </td>
                              </tr>

                            </tbody> 
                            

                        </table>
                      </div>                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
        <div class="col-sm-12 col-md-4 col-12 col-lg-4">
          <section class="content">
            <div class="container-fluid">
              <div class="row justify-content-center">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">REALIZAR PAGO</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">


                      <form action="" id="formulario-pagos" novalidate>

                        <label for="" hidden>id_credito = <input name="id_credito" type="text" value="<?php echo $datos['id_credito'] ?>"></label>

                        <div class="row">
                          <div class="col-12 col-md-12 col-sm-12">
                            <div class="form-group">
                            <label for="">Monto a Cancelar</label>
                              <div class="input-group">                                
                                  <input type="number" class="form-control" name="monto_cancelar" id="monto_cancelar" placeholder="<?php echo round($total,2)." Dolares" ?>">
                                  <div class="input-group-append">
                                      <span class="input-group-text">Dolares</span>
                                  </div>
                              </div>
                            </div>
                            <script>
                              const valorMaximo = <?php echo $monto_cancelar-$suma_cuotas; ?>;
                              const montoInput = document.getElementById('monto_cancelar');
                              montoInput.addEventListener('change', function() {
                                  const monto = parseFloat(montoInput.value);

                                  if (isNaN(monto)) {
                                      Swal.fire({
                                          icon: 'error',
                                          title: 'Valor Inválido',
                                          text: 'Por favor, ingrese un monto válido.',
                                          confirmButtonText: 'Aceptar'
                                      });
                                      return;
                                  }

                                  if (monto > valorMaximo) {
                                      Swal.fire({
                                          icon: 'error',
                                          title: 'Monto Excedido',
                                          text: 'El monto ingresado supera el límite permitido de ' + valorMaximo,
                                          confirmButtonText: 'Aceptar'
                                      }).then(() => {
                                          montoInput.value = '';
                                      });
                                  } else {
                                      Swal.fire({
                                          icon: 'success',
                                          title: 'Monto Aceptado',
                                          text: 'El monto ingresado es válido.',
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000,
                                          timerProgressBar: true
                                      });
                                  }
                              });
                            </script>
                          </div>
                          <div class="col-12 col-md-12 col-sm-12">
                            <div class="form-group">
                              <label for="">Nro. Recibo o Transferencia</label>
                              <input type="number" name="recibo" id="recibo" class="form-control" placeholder="Numero de Recibo">
                            </div>
                          </div>

                          <div class="col-12 col-md-12 col-sm-12">
                            <div class="form-group">
                              <label for="">Tipo de Pago</label>
                              <select name="tipo_pago" id="tipo_pago" class="form-control">
                                <option value="EFECTIVO">EFECTIVO</option>
                                <option value="TRANFERENCIA BANCARIA">TRANFERENCIA BANCARIA</option>
                                <option value="QR">QR</option>
                              </select>
                            </div>
                          </div>

                          <div class="col-12 col-md-12 col-sm-12">
                            <div class="form-group">
                              <label for="">Nro. Cuotas</label>
                              <select name="id_cuota" id="id_cuota" class="form-control">
                                <?php foreach ($dato3 as $cuota) {
                                  if ($cuota['monto'] ) {
                                    
                                  } else {
                                  ?>
                                  <option value="<?php echo $cuota['id_cuota']; ?>"> <?php echo $cuota['nombre_cuota']; ?></option>
                                  <?php  
                                  }
                                  
                               
                                }
                                ?>
                                
                                


                              </select>
                            </div>
                          </div>

                          <div class="col-12 col-md-12 col-sm-12">
                            <div class="form-group">
                              <label for="">Fecha de Pago</label>
                              <input type="date" name="fecha_pago" id="fechaActual" class="form-control">
                            </div>
                          </div>

                          <script>
                              // Obtener el elemento del input
                              const inputFecha = document.getElementById('fechaActual');
                              
                              // Crear un objeto Date para obtener la fecha actual
                              const fecha = new Date();
                              
                              // Obtener el año, mes y día de la fecha actual
                              const año = fecha.getFullYear();
                              const mes = ('0' + (fecha.getMonth() + 1)).slice(-2); // Los meses en JavaScript van de 0 a 11
                              const dia = ('0' + fecha.getDate()).slice(-2);
                              
                              // Formatear la fecha en 'YYYY-MM-DD'
                              const fechaFormateada = `${año}-${mes}-${dia}`;
                              
                              // Asignar la fecha formateada al valor del input
                              inputFecha.value = fechaFormateada;
                          </script>


                          <div class="col-12">
                            <input type="submit" value="REGISTRAR" id="registrar" class="btn btn-danger btn-block">
                          </div>
                        </div> 
                      </form>                                             
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>

      



    </div>
  </div>
</div>

<script src="script.js"></script>

<?php include ('../../layout/admin/parte2.php'); ?>




