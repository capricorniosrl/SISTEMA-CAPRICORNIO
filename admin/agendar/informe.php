<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
?>


<?php
if (isset($_SESSION['session_age_clientes'])) {
  // echo "existe session y paso por el login";
} else {
  // echo "no existe session por que no ha pasado por el login";
  header('Location:' . $URL . '/admin');
}
?>

<?php include('../../layout/admin/parte1.php'); ?>



<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Llenado de Informe</h1>
        </div>
      </div>

      <div class="card card-primary">
        <div class="alert d-none" style="background: #e9cfcf;" id="error">
          <strong style="color: #a94442;">ERROR <i class="fas fa-exclamation-triangle"></i></strong>
          <div id="error_msj" style="color: #a94442;"></div>
        </div>
        <div class="card-body">
          <?php

          $id_agenda = $_GET["id"];


          if (isset($_GET['id'])) {
            $query = $pdo->prepare("SELECT cli.tipo_urbanizacion, cli.nombres, cli.apellidos, con.celular, ag.detalle_agenda FROM tb_agendas ag INNER JOIN tb_clientes cli INNER JOIN tb_contactos con WHERE (ag.id_agenda='$id_agenda' AND ag.id_cliente_fk = cli.id_cliente) AND cli.id_contacto_fk = con.id_contacto");
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


          <form action="" id="form-informe">

            <input type="text" name="id_agenda" hidden value="<?php echo $_GET["id"] ?>">

            <div class="card-body">
              <div class="row">

                <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 col-12 ">
                  <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" name="nombres" class="form-control" id="nombres" value="<?php echo $nombres ?>" placeholder="Ingrese nombre completo" required />
                  </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2 col-12 ">
                  <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" id="apellidos" value="<?php echo $apellidos ?>" placeholder="Ingrese Apellido Paterno" />
                  </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-5 col-xl-3 col-12 ">
                  <div class="form-group">
                    <label for="apellidos">C.I. <small>Si hacer la reserva es obligatorio este campo</small> </label>
                    <input type="text" name="ci_cliente" class="form-control" id="ci_cliente" value="" placeholder="Ingrese el Numero de Carnet" />
                  </div>
                </div>
                <div class="col-sm-3 col-lg-3 col-xl-2 col-md-6">
                  <div class="form-group">
                    <label>EXP</label>
                    <div class="input-group">
                      <select name="exp_cliente" id="exp_cliente" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="LP.">LA PAZ</option>
                        <option value="OR.">ORURO</option>
                        <option value="PT.">POTOSI</option>
                        <option value="CBBA.">COCHABAMBA</option>
                        <option value="CH.">CHUQUISACA</option>
                        <option value="TJ.">TARIJA</option>
                        <option value="PD.">PANDO</option>
                        <option value="BE.">BENI</option>
                        <option value="SCZ.">SANTA CRUZ</option>
                        <option value="QR.">QR</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-sm-3 col-md-6 col-lg-3 col-xl-2 col-12 ">
                  <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="number" name="celular" class="form-control" id="celular" value="<?php echo $celular ?>" placeholder="Ingrese Apellido Materno" />
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
                      $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

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
                      <input class="form-check-input" type="radio" name="tipo_cliente" id="propio" value="propio">
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
                    <label for="">Existe Reserva </label>
                    <input type="checkbox" name="existe_pago" id="existeMedioPago">
                  </div>
                </div>
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    var checkbox = document.getElementById('existeMedioPago');



                    checkbox.addEventListener('change', function() {
                      if (checkbox.checked) {
                        const input = document.getElementById('ci_cliente');
                        const input_exp = document.getElementById('exp_cliente');
                        $('#input_superficie').removeClass('d-none');
                        $('#input_manzano').removeClass('d-none');
                        $('#input_lote').removeClass('d-none');
                        $('#select_tipo_pago').removeClass('d-none');
                        $('#input_codigo').removeClass('d-none');
                        $('#input_pago').removeClass('d-none');
                        $('#monto_literal').removeClass('d-none');
                        $('#precio_acordado_literal').removeClass('d-none');
                        $('#concepto').removeClass('d-none');
                        $('#precio_acordado').removeClass('d-none');
                        $('#tipo_cambio').removeClass('d-none');
                        $('#plan').removeClass('d-none');
                        $('#fecha_limite').removeClass('d-none');
                        $('#observacion').removeClass('d-none');
                        const contenedor = document.getElementById('contenedor');
                        contenedor.style.backgroundColor = '#f2f2f2';
                        // input.setAttribute('required', 'required');
                        // input_exp.setAttribute('required', 'required');
                      } else {
                        $('#input_superficie').addClass('d-none');
                        $('#input_manzano').addClass('d-none');
                        $('#input_lote').addClass('d-none');
                        $('#select_tipo_pago').addClass('d-none');
                        $('#input_codigo').addClass('d-none');
                        $('#input_pago').addClass('d-none');
                        $('#monto_literal').addClass('d-none');
                        $('#precio_acordado_literal').addClass('d-none');
                        $('#concepto').addClass('d-none');
                        $('#precio_acordado').addClass('d-none');
                        $('#tipo_cambio').addClass('d-none');
                        $('#plan').addClass('d-none');
                        $('#fecha_limite').addClass('d-none');
                        $('#observacion').addClass('d-none');
                        const contenedor = document.getElementById('contenedor');
                        contenedor.style.backgroundColor = '#fff';
                        input.removeAttribute('required');
                      }
                    });
                  });
                </script>

                <div class="container-fluid pl-5 pr-5" id="contenedor">

                  <div class="row">
                    <div class="col-12 col-sm-4 d-none" id="select_tipo_pago">
                      <div class="form-group">
                        <label for="tipoPago">SELECCIONE EL TIPO DE PAGO:</label>
                        <select class="form-control" id="tipoPago" name="tipoPago">
                          <option value="" selected>Seleccione...</option>
                          <option value="efectivo"> Efectivo </option>
                          <option value="qr">QR</option>
                          <option value="transferencia">Transferencia</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-12 col-sm-4 d-none" id="input_pago">
                      <div class="form-group" id="pago" style="display: none;">
                        <label for="numeroRecibo">
                          Monto de reserva en Bs</label>
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
                        <label for="numeroTransferencia"><i class="fas fa-credit-card " style="color:blue"></i>
                          Número de transferencia:</label>
                        <input type="number" class="form-control" id="numeroTransferencia" name="numeroTransferencia">
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <input type="text" name="monto_literal" id="monto_literal" class="form-control d-none" placeholder="MONTO LITERAL">
                      </div>
                    </div>
                    <script>
                      // Función para convertir un número a palabras
                      function numberToWords(num) {
                        const unidades = ["", "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE"];
                        const decenas = ["", "DIEZ", "VEINTE", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA"];
                        const centenas = ["", "CIENTO", "DOSCIENTOS", "TRESCIENTOS", "CUATROCIENTOS", "QUINIENTOS", "SEISCIENTOS", "SETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS"];
                        const especiales = ["DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISETE", "DIECIOCHO", "DIECINUEVE"];

                        if (num === 0) return "CERO";
                        if (num === 100) return "CIEN";

                        let words = "";

                        if (num >= 1000000) {
                          let millones = Math.floor(num / 1000000);
                          words += `${numberToWords(millones)} MILLÓN${millones > 1 ? "ES" : ""} `;
                          num %= 1000000;
                        }

                        if (num >= 1000) {
                          let miles = Math.floor(num / 1000);
                          if (miles === 1) {
                            words += "MIL ";
                          } else {
                            words += `${numberToWords(miles)} MIL `;
                          }
                          num %= 1000;
                        }

                        if (num >= 100) {
                          let centenasIndex = Math.floor(num / 100);
                          if (centenasIndex === 1 && num % 100 === 0) {
                            words += "CIEN ";
                          } else {
                            words += `${centenas[centenasIndex]} `;
                          }
                          num %= 100;
                        }

                        if (num >= 20) {
                          let decenasIndex = Math.floor(num / 10);
                          words += `${decenas[decenasIndex]}`;
                          num %= 10;
                          if (num > 0) {
                            words += ` Y ${unidades[num]}`;
                          }
                        } else if (num >= 10) {
                          words += `${especiales[num - 10]}`;
                        } else if (num > 0) {
                          words += `${unidades[num]}`;
                        }

                        return words.trim();
                      }

                      // Función para actualizar el campo de texto con el número en palabras
                      function actualizarLiteral() {
                        const inputNumero = document.getElementById('numeroRecibo');
                        const inputLiteral = document.getElementById('monto_literal');
                        const valor = parseFloat(inputNumero.value);

                        if (!isNaN(valor)) {
                          const enteros = Math.floor(valor);
                          const decimales = Math.round((valor - enteros) * 100);
                          let palabras = numberToWords(enteros);

                          if (decimales > 0) {
                            palabras += ` CON ${decimales.toString().padStart(2, '0')}/100 BOLIVIANOS`;
                          } else {
                            palabras += ` CON 00/100 BOLIVIANOS`;
                          }

                          inputLiteral.value = palabras;
                        } else {
                          inputLiteral.value = "";
                        }
                      }

                      // Añadir event listener para el campo de entrada
                      document.getElementById('numeroRecibo').addEventListener('input', actualizarLiteral);
                    </script>

                    <div class="col-12 col-lg-6 col-sm-4 d-none" id="concepto">
                      <div class="form-group">
                        <label for="tipoPago">POR CONCEPTO DE:</label>
                        <input type="text" class="form-control" name="concepto" id="concepto" placeholder="INGRESE UN NUMERO DE LOTE">
                      </div>
                    </div>

                    <div class="col-12 col-lg-6 col-sm-4 d-none" id="precio_acordado">
                      <label for="">PRECIO ACORDADO DEL TERRENO EN DOLARES:</label>
                      <div class="input-group mb-3">
                        <input type="number" name="precio_acordado" id="precio_acor" class="form-control" placeholder="PRECIO EN DOLARES">
                        <div class="input-group-append">
                          <span class="input-group-text">Dólares</span>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <input type="text" name="precio_acordado_literal" id="precio_acordado_literal" class="form-control d-none" placeholder="MONTO LITERAL">
                      </div>
                    </div>
                    <script>
                      // Función para convertir un número a palabras
                      function numberToWords(num) {
                        const unidades = ["", "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE"];
                        const decenas = ["", "DIEZ", "VEINTE", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA"];
                        const centenas = ["", "CIENTO", "DOSCIENTOS", "TRESCIENTOS", "CUATROCIENTOS", "QUINIENTOS", "SEISCIENTOS", "SETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS"];
                        const especiales = ["DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISETE", "DIECIOCHO", "DIECINUEVE"];

                        if (num === 0) return "CERO";
                        if (num === 100) return "CIEN";

                        let words = "";

                        if (num >= 1000000) {
                          let millones = Math.floor(num / 1000000);
                          words += `${numberToWords(millones)} MILLÓN${millones > 1 ? "ES" : ""} `;
                          num %= 1000000;
                        }

                        if (num >= 1000) {
                          let miles = Math.floor(num / 1000);
                          if (miles === 1) {
                            words += "MIL ";
                          } else {
                            words += `${numberToWords(miles)} MIL `;
                          }
                          num %= 1000;
                        }

                        if (num >= 100) {
                          let centenasIndex = Math.floor(num / 100);
                          if (centenasIndex === 1 && num % 100 === 0) {
                            words += "CIEN ";
                          } else {
                            words += `${centenas[centenasIndex]} `;
                          }
                          num %= 100;
                        }

                        if (num >= 20) {
                          let decenasIndex = Math.floor(num / 10);
                          words += `${decenas[decenasIndex]}`;
                          num %= 10;
                          if (num > 0) {
                            words += ` Y ${unidades[num]}`;
                          }
                        } else if (num >= 10) {
                          words += `${especiales[num - 10]}`;
                        } else if (num > 0) {
                          words += `${unidades[num]}`;
                        }

                        return words.trim();
                      }

                      // Función para actualizar el campo de texto con el número en palabras
                      function actualizarLiteral() {
                        const inputNumero = document.getElementById('precio_acor');
                        const inputLiteral = document.getElementById('precio_acordado_literal');
                        const valor = parseFloat(inputNumero.value);

                        if (!isNaN(valor)) {
                          const enteros = Math.floor(valor);
                          const decimales = Math.round((valor - enteros) * 100);
                          let palabras = numberToWords(enteros);

                          if (decimales > 0) {
                            palabras += ` CON ${decimales.toString().padStart(2, '0')}/100 DOLARES AMERICANOS`;
                          } else {
                            palabras += ` 00/100 DOLARES AMERICANOS`;
                          }

                          inputLiteral.value = palabras;
                        } else {
                          inputLiteral.value = "";
                        }
                      }

                      // Añadir event listener para el campo de entrada
                      document.getElementById('precio_acor').addEventListener('input', actualizarLiteral);
                    </script>

                    <div class="col-12 col-lg-4 col-sm-4 d-none" id="tipo_cambio">
                      <label for="">TIPO DE CAMBIO:</label>
                      <div class="input-group mb-3">
                        <input type="number" name="tipo_cambio" class="form-control" placeholder="PRECIO EN BOLIVIANOS">
                        <div class="input-group-append">
                          <span class="input-group-text">Bs.</span>
                        </div>
                      </div>
                    </div>

                    <div class="col-12 col-lg-4 col-sm-4 d-none" id="plan">
                      <label for="">PLAN</label>
                      <select name="plan" id="" class="form-control">
                        <option value="CONTADO">CONTADO</option>
                        <option value="SEMI CONTADO">SEMI CONTADO</option>
                        <option value="CREDITO">CREDITO</option>
                      </select>
                    </div>

                    <div class="col-12 col-lg-4 col-sm-4 d-none" id="fecha_limite">
                      <label for="">MESES PARA PAGAR</label><small> Indique solo cuantos meses tienes para pagar</small>
                      <div class="input-group mb-3">
                        <input class="form-control" type="text" name="fecha_limite" id="fecha_lim" placeholder="10">
                        <div class="input-group-append">
                          <span class="input-group-text">MESES</span>
                        </div>
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

                    <div class="col-12 col-12 col-sm-4 d-none" id="input_superficie">
                      <div class="form-group">
                        <label for="tipoPago">SUPERFICIE:</label>

                        <div class="input-group mb-3">
                          <input type="text" class="form-control" name="superficie" id="superficie" placeholder="INGRESE LA SUPERFICIE DEL TERRENO">
                          <div class="input-group-append">
                            <span class="input-group-text">Mts<sup>2</sup></span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12 col-12 col-sm-12 d-none" id="observacion">
                      <div class="form-group">
                        <label for="tipoPago">OBSERVACIONES</label>

                        <input type="text" class="form-control" name="observacion" id="" placeholder="INGRESE SI EXISTE ALGUNA OBSERVACION CONFORME A LA RESERVA">

                      </div>
                    </div>
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
              <a href="<?php echo $URL; ?>/admin/agendar/listar.php" class="btn btn-default">CANCELAR</a>
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
<?php include('../../layout/admin/parte2.php');

?>

<script>
  var URL = "<?php echo $URL; ?>";
  $('#form-informe').submit(function(event) {
    event.preventDefault(); //almacena los datos sin refrezcar la pagina
    enviar();

  });

  function enviar() {
    var datos = $('#form-informe').serialize();
    $.ajax({
      type: "post",
      url: "controller_create_informe.php",
      data: datos,
      success: function(text) {
        if (text == "exito") {
          correcto();
        } else {
          phperror(text);
        }
      }

    })
  }

  function correcto() {

    $('#error').addClass('d-none');

    Swal.fire({
      title: 'CORRECTO',
      text: 'REGISTRO EXITOSO',
      icon: 'success',
    }).then((result) => {
      window.location.href = URL + '/admin/agendar/listar.php';
    });
  }

  function phperror(text) {
    $('#error').removeClass('d-none');
    $('#error_msj').html(text);
  }
</script>