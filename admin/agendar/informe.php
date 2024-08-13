<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
?>


<?php
if (isset($_SESSION['session_age_clientes'])) {
    // echo "existe session y paso por el login";
}else{
    // echo "no existe session por que no ha pasado por el login";
    header('Location:'.$URL.'/admin');
}
?>
   
<?php  include ('../../layout/admin/parte1.php'); ?>



  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">           
            <h1 class="m-0">Llenado de Informe</h1>
          </div>      
        </div>

            <div class="card card-primary">            
              <div class="card-body">
                <?php

                $id_agenda = $_GET["id"];
             

                if(isset($_GET['id'])) {
                    $query=$pdo->prepare("SELECT cli.tipo_urbanizacion, cli.nombres, cli.apellidos, con.celular, ag.detalle_agenda FROM tb_agendas ag INNER JOIN tb_clientes cli INNER JOIN tb_contactos con WHERE (ag.id_agenda='$id_agenda' AND ag.id_cliente_fk = cli.id_cliente) AND cli.id_contacto_fk = con.id_contacto");
                    $query->execute();

                    // Obtener el resultado de la consulta
                    $usuarios = $query->fetch(PDO::FETCH_ASSOC);
                    
                    // Guardar el tipo de urbanización en una variable
                    $tipo_urbanizacion = $usuarios['tipo_urbanizacion'];
                    $nombres = $usuarios['nombres'];
                    $apellidos = $usuarios['apellidos'];
                    $celular = $usuarios['celular'];
                    $detalle_agenda = $usuarios['detalle_agenda'];
                }
                ?>
              
                
              <form action="controller_create_informe.php" method="post">

                <input type="text" name="id_agenda" hidden value="<?php echo $_GET["id"] ?>" >
                  
                  <div class="card-body">
                    <div class="row"> 

                      <div class="col-sm-4 col-12 ">
                        <div class="form-group">
                          <label for="nombres">Nombres</label>
                          <input type="text" name="nombres" class="form-control" id="nombres" value="<?php echo $nombres?>" placeholder="Ingrese nombre completo" required/>
                        </div>
                      </div>

                      <div class="col-sm-4 col-12 ">
                        <div class="form-group">
                          <label for="apellidos">Apellidos</label>
                          <input type="text" name="apellidos" class="form-control" id="apellidos"  value="<?php echo $apellidos?>" placeholder="Ingrese Apellido Paterno"/>
                        </div>
                      </div>

                      <div class="col-sm-4 col-12 ">
                        <div class="form-group">
                          <label for="celular">Celular</label>
                          <input type="number" name="celular" class="form-control" id="celular"  value="<?php echo $celular?>" placeholder="Ingrese Apellido Materno"/>
                        </div>
                      </div>                   

                      <div class=" col-sm-6 col-12">
                        <div class="form-group">
                          <label for="urbanizacion">Tipo de Urbanizacion:</label>
                              <select name="urbanizacion" id="" class="form-control">
                                <option value="<?php echo $tipo_urbanizacion ?>"><?php echo $tipo_urbanizacion ?></option>

                                <?php
                                  $consulta = $pdo->prepare("SELECT * FROM tb_urbanizacion");
                                  $consulta->execute();
                                  $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);

                                  foreach ($datos as $nom_urb) {
                                ?>

                                <option value="<?php echo $nom_urb['nombre_urbanizacion'] ?>"><?php echo $nom_urb['nombre_urbanizacion'] ?></option>

                                <?php
                                  }
                                ?>
                              </select>
                        </div>
                      </div>
                      
                      <div class=" col-sm-6 col-12">
                        <div class="form-group">
                            <div class="form-group">
                              <label>FECHA REGISTRO <span class="text-danger">*</span> </label>
                              <input type="date" id="agenda" name="fecha_registro" class="form-control" readonly>
                            </div>
                          </div>
                      </div>

                      <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                          const today = new Date();
                          const formattedDate = today.toISOString().split('T')[0]; // YYYY-MM-DD
                          document.getElementById('agenda').value = formattedDate;
                        });                                            
                      </script>                      

                      <style>
                        .styled-input {
                          border: none;
                          border-bottom: 2px solid blue;
                          padding: 5px;
                          outline: none;
                        }
                      </style>

                      <div class="col-12">
                        <div class="form-group">
                          <div class="form-check">

                              <input class="form-check-input" type="radio" name="tipo_cliente" id="oficina" value="oficina" checked>                              
                              <label class="form-check-label" for="oficina">CLIENTE DE OFICINA</label>


                              <input type="text" name="detalle" id="detalle_oficina" class="styled-input form-control" value="<?php echo $detalle_agenda; ?>" style="display:none;" readonly>

                          </div>        
                          
                          
                          <div class="form-check mt-3">
                              <input class="form-check-input" type="radio" name="tipo_cliente" id="propio" value="propio" >
                              <label class="form-check-label" for="propio">CLIENTE PROPIO</label>


                              <input type="text" name="detalle" id="detalle_propio" class="styled-input form-control" value="<?php echo $detalle_agenda; ?>" readonly>
                          </div>    
                        </div>
                      </div>

                      <script>
                        document.addEventListener('DOMContentLoaded', function() {
                          // Obtener referencias a los radio buttons y los inputs
                          var radioPropio = document.getElementById('propio');
                          var radioOficina = document.getElementById('oficina');
                          var inputPropio = document.getElementById('detalle_propio');
                          var inputOficina = document.getElementById('detalle_oficina');

                          // Función para mostrar el input correspondiente al radio seleccionado
                          function toggleInput() {
                            if (radioPropio.checked) {
                              inputPropio.style.display = 'block';
                              inputOficina.style.display = 'none';
                            } else if (radioOficina.checked) {
                              inputPropio.style.display = 'none';
                              inputOficina.style.display = 'block';
                            }
                          }

                          // Ejecutar la función al cargar la página
                          toggleInput();

                          // Agregar event listener para detectar cambios en los radio buttons
                          radioPropio.addEventListener('change', toggleInput);
                          radioOficina.addEventListener('change', toggleInput);
                        });
                      </script>  

                      <div class="col-12">
                        <div class="form-group">
                          <label for="">Existe Medio de Pago </label>
                          <input type="checkbox" name="existe_pago" id="existeMedioPago">
                        </div>
                      </div>
                      <script>
                        document.addEventListener('DOMContentLoaded', function() {
                          var checkbox = document.getElementById('existeMedioPago');

                          checkbox.addEventListener('change', function() {
                            if (checkbox.checked) {
                              $('#input_manzano').removeClass('d-none');
                              $('#input_lote').removeClass('d-none');
                              $('#select_tipo_pago').removeClass('d-none');
                              $('#input_codigo').removeClass('d-none');
                              $('#input_pago').removeClass('d-none');
                            } else {
                              $('#input_manzano').addClass('d-none');
                              $('#input_lote').addClass('d-none');
                              $('#select_tipo_pago').addClass('d-none');
                              $('#input_codigo').addClass('d-none');
                              $('#input_pago').addClass('d-none');
                            }
                          });
                        });
                      </script>

                        
                      <div class="col-12 col-sm-4 d-none" id="select_tipo_pago">
                        <div class="form-group">
                          <label for="tipoPago">Seleccione el tipo de pago:</label>
                          <select class="form-control" id="tipoPago" name="tipoPago">
                            <option value="" selected >Seleccione...</option>
                            <option value="efectivo"> Efectivo </option>
                            <option value="qr">QR</option>
                            <option value="transferencia">Transferencia</option>                            
                          </select>
                        </div>
                      </div>

                     
                      <div class="col-12 col-sm-4 d-none" id="input_pago">
                          <div class="form-group" id="pago" style="display: none;">
                            <label for="numeroRecibo">
                            Monto en Bs</label>
                            <input type="number" class="form-control" id="numeroRecibo" name="monto">
                          </div>

                      </div>

                      <div class="col-12 col-sm-4 d-none" id="input_codigo">
                          <div class="form-group" id="numeroReciboGroup" style="display: none;">
                            <label for="numeroRecibo"><i class="fas fa-money-bill" style="color:#09974a"></i>
                            Número de recibo:</label>
                            <input type="number" class="form-control" id="numeroRecibo" name="numeroRecibo">
                          </div>


                          <div class="form-group" id="numeroTransferenciaGroup" style="display: none;">
                            <label for="numeroTransferencia"><i class="fas fa-credit-card "style="color:blue"></i>
                            Número de transferencia:</label>
                            <input type="number" class="form-control" id="numeroTransferencia" name="numeroTransferencia">
                          </div>
                      </div>

                      <div class="col-12 col-12 col-sm-4 d-none" id="input_lote">
                        <div class="form-group">
                          <label for="tipoPago">NUMERO DE LOTE:</label>
                          <input type="text" class="form-control" name="lote" id="lote" placeholder="INGRESE UN NUMERO DE LOTE">
                        </div>
                      </div>

                      <div class="col-12 col-12 col-sm-4 d-none" id="input_manzano">
                        <div class="form-group">
                          <label for="tipoPago">NUMERO DE MANZANO:</label>
                          <input type="text" class="form-control" name="manzano" id="manzano" placeholder="INGRESE UN NUMERO DE MANZANO">
                        </div>
                      </div>

                      <script>
                        $(document).ready(function() {
                          $('#tipoPago').change(function() {
                            var selectedOption = $(this).val();

                            // Ocultar todos los campos
                            $('#numeroReciboGroup').hide();
                            $('#numeroTransferenciaGroup').hide();
                            $('#pago').hide();

                            // Mostrar el campo correspondiente al tipo de pago seleccionado
                            if (selectedOption === 'efectivo') {
                              $('#numeroReciboGroup').show();
                              $('#pago').show();
                            } else if (selectedOption === 'qr' || selectedOption === 'transferencia') {
                              $('#numeroTransferenciaGroup').show();
                              $('#pago').show();
                            }
                          });
                        });
                      </script>

                                     

                      <div class="col-12">
                        <div class="form-group">
                          <label for="">RESUMEN DE LA VISITA</label>
                          <textarea class="form-control" name="resumen" id="" cols="30" rows="2"></textarea>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="">SIGUIENTE PASO POR EL ASESOR COMERCIAL</label>
                          <textarea class="form-control" name="siguiente" id="" cols="30" rows="2"></textarea>
                        </div>
                      </div>

                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <a href="<?php echo $URL;?>/admin/agendar/listar.php" class="btn btn-default">CANCELAR</a>
                    <button type="submit" class="btn btn-primary">REGISTRAR</button>
                  </div>

                </form>



              

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
<?php   include ('../../layout/admin/parte2.php');
?>


 