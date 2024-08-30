<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

?>

<!-- <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  /> -->

<?php include('../../layout/admin/parte1.php'); ?>
<!-- Select2 -->
<!-- Select2 -->
<link rel="stylesheet" href="../../public/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../../public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="../../public/dist/css/adminlte.min.css">


<?php
$id = $_GET['id'];
$sql = $pdo->prepare("SELECT info.id_informe, cli.ci_cliente, cli.exp_cliente, info.fecha_limite_pago, info.precio_acordado,info.tipo_cambio, UPPER(cli.nombres) as nombres, cli.apellidos, con.celular,info.monto, UPPER(info.tipo_pago) as tipo_pago, info.num_recibo, info.num_transferencia, cli.tipo_urbanizacion, UPPER(info.lote) as lote, UPPER(info.manzano) as manzano, info.superficie FROM tb_informe info INNER JOIN tb_agendas ag INNER JOIN tb_clientes cli INNER JOIN tb_usuarios us INNER JOIN 	tb_contactos con WHERE (((id_informe='$id' AND info.id_agenda_fk = ag.id_agenda) AND ag.id_cliente_fk = cli.id_cliente) AND ag.id_usuario_fk = us.id_usuario) AND con.id_contacto = cli.id_contacto_fk");
$sql->execute();
$dato = $sql->fetch(PDO::FETCH_ASSOC);

$id_informe = $dato['id_informe'];


?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0 ">CIERRE AL SEMI CONTADO PARA LA URBANIZACION <span class="text-primary"><?php echo $dato['tipo_urbanizacion'] ?></span></h1>
          <div class="alert d-none" style="background: #e9cfcf;" id="error">
            <strong style="color: #a94442;">ERROR <i class="fas fa-exclamation-triangle"></i></strong>
            <div id="error_msj" style="color: #a94442;"></div>
          </div>
        </div>
      </div>


      <div class="row ">
        <div class="col-12 col-sm-12">
          <div class="card card-danger card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">INFORMACION DEL CLIENTE</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">PRECIO</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">DATOS URBANIZACION</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">FINALIZAR</a>
                </li>
              </ul>
            </div>
            <form id="formulario_semicontado" novalidate>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                    <div class="row">
                      <div class="col-sm-3 col-lg-3 col-md-6">

                        <input name="id_informe" type="text" value="<?php echo $id ?>" hidden>

                        <div class="form-group">
                          <label>NOMBRES</label>
                          <div class="input-group">
                            <input type="text" class="form-control" value="<?php echo $dato['nombres'] ?>" id="nombre_1" name="nombre_1" oninput="concatenateInputs()">
                          </div>
                        </div>
                      </div>
                      <?php

                      $partes_apellidos = explode(' ', $dato['apellidos']);

                      if (count($partes_apellidos) >= 2) {
                        $apellido_paterno = $partes_apellidos[0];
                        $apellido_materno = $partes_apellidos[1];
                      } else {
                        $apellido_paterno = $partes_apellidos[0];
                        $apellido_materno = '';
                      }

                      ?>
                      <div class="col-sm-3 col-lg-3 col-md-6">
                        <div class="form-group">
                          <label>APELLIDO PARTENO</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="ap_paterno_1" name="ap_paterno_1" value="<?php echo $apellido_paterno ?>" oninput="concatenateInputs()">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3 col-lg-3 col-md-6">
                        <div class="form-group">
                          <label>APELLIDO MATERNO</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="ap_materno_1" name="ap_materno_1" value="<?php echo $apellido_materno ?>" oninput="concatenateInputs()">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 col-lg-2 col-md-6">
                        <div class="form-group">
                          <label>CI</label>
                          <div class="input-group">
                            <input type="number" class="form-control" name="ci_1" value="<?php echo $dato['ci_cliente'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1 col-lg-1 col-md-6">
                        <div class="form-group">
                          <label>EXP</label>
                          <div class="input-group">
                            <select name="exp_1" class="form-control">
                              <option value="" <?php if ($dato['exp_cliente'] == '') echo 'selected'; ?>>Seleccione</option>
                              <option value="LP." <?php if ($dato['exp_cliente'] == 'LP.') echo 'selected'; ?>>LA PAZ</option>
                              <option value="OR." <?php if ($dato['exp_cliente'] == 'OR.') echo 'selected'; ?>>ORURO</option>
                              <option value="PT." <?php if ($dato['exp_cliente'] == 'PT.') echo 'selected'; ?>>POTOSI</option>
                              <option value="CBBA." <?php if ($dato['exp_cliente'] == 'CBBA.') echo 'selected'; ?>>COCHABAMBA</option>
                              <option value="CH." <?php if ($dato['exp_cliente'] == 'CH.') echo 'selected'; ?>>CHUQUISACA</option>
                              <option value="TJ." <?php if ($dato['exp_cliente'] == 'TJ.') echo 'selected'; ?>>TARIJA</option>
                              <option value="PD." <?php if ($dato['exp_cliente'] == 'PD.') echo 'selected'; ?>>PANDO</option>
                              <option value="BE." <?php if ($dato['exp_cliente'] == 'BE.') echo 'selected'; ?>>BENI</option>
                              <option value="SCZ." <?php if ($dato['exp_cliente'] == 'SCZ.') echo 'selected'; ?>>SANTA CRUZ</option>
                              <option value="QR." <?php if ($dato['exp_cliente'] == 'QR.') echo 'selected'; ?>>QR</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3 col-lg-3 col-md-6">
                        <div class="form-group">
                          <label>NOMBRES</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="nombre_2" name="nombre_2" oninput="concatenateInputs()">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3 col-lg-3 col-md-6">
                        <div class="form-group">
                          <label>APELLIDO PARTENO</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="ap_paterno_2" name="ap_paterno_2" oninput="concatenateInputs()">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3 col-lg-3 col-md-6">
                        <div class="form-group">
                          <label>APELLIDO MATERNO</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="ap_materno_2" name="ap_materno_2" oninput="concatenateInputs()">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 col-lg-2 col-md-6">
                        <div class="form-group">
                          <label>CI</label>
                          <div class="input-group">
                            <input type="number" class="form-control" name="ci_2">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1 col-lg-1 col-md-6">
                        <div class="form-group">
                          <label>EXP.</label>
                          <div class="input-group">
                            <select name="exp_2" id="" class="form-control">
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
                    </div>
                    <hr class="text-primary bg-primary">

                    <div class="row">
                      <div class="col-sm-12 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label>NOMBRE CLIENTE 1</label>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" value="<?php echo $dato['nombres'] . " " . $dato['apellidos'] ?>" id="nombre_completo_1" name="" data-mask readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label>CELULAR</label>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" value="<?php echo $dato['celular'] ?>" class="form-control" name="celular_1" data-mask>
                          </div>
                        </div>
                      </div>



                      <div class="col-sm-12 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label>NOMBRE CLIENTE 2</label>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="nombre_completo_2" name="" data-mask readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label>CELULAR</label>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" name="celular_2" data-mask>
                          </div>
                        </div>
                      </div>

                    </div>

                    <script>
                      function concatenateInputs() {
                        const nombre_1 = document.getElementById('nombre_1').value;
                        const apellidoPaterno_1 = document.getElementById('ap_paterno_1').value;
                        const apellidoMaterno_1 = document.getElementById('ap_materno_1').value;


                        const nombreCompleto_1 = `${nombre_1} ${apellidoPaterno_1} ${apellidoMaterno_1}`;
                        document.getElementById('nombre_completo_1').value = nombreCompleto_1.trim();




                        const nombre_2 = document.getElementById('nombre_2').value;
                        const apellidoPaterno_2 = document.getElementById('ap_paterno_2').value;
                        const apellidoMaterno_2 = document.getElementById('ap_materno_2').value;

                        const nombreCompleto_2 = `${nombre_2} ${apellidoPaterno_2} ${apellidoMaterno_2}`;
                        document.getElementById('nombre_completo_2').value = nombreCompleto_2.trim();
                      }
                    </script>

                  </div>
                  <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                    <div class="row">
                      <div class="col-sm-5 col-12 col-md-4">
                        <div class="row">
                          <div class="col-12">
                            <h3>DATOS DE LA RESERVA</h3>
                            <hr class="text-primary bg-primary" style="height: 3px;">

                            <div class="card-body">
                              <dl class="row">

                                <dt class="col-sm-4">MONTO RESERVADO:</dt>
                                <?php
                                $sql_aumento1 = $pdo->prepare("SELECT SUM(monto_aumento) as monto_aumento FROM tb_aumento_reserva WHERE id_informe_fk='$id_informe'");
                                $sql_aumento1->execute();
                                $dato_suma = $sql_aumento1->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <dd class="col-sm-8"><?php echo $dato['monto'] + $dato_suma['monto_aumento'] ?> Bolivianos</dd>

                                <dt class="col-sm-4">TIPO DE PAGO:</dt>
                                <dd class="col-sm-8"><?php echo $dato['tipo_pago'] ?></dd>

                                <?php
                                if ($dato['num_recibo']) {
                                ?>
                                  <dt class="col-sm-4">NRO. DE RECIBO:</dt>
                                  <dd class="col-sm-8"><?php echo $dato['num_recibo'] ?></dd>
                                  <?php
                                } else {
                                  if ($dato['num_transferencia']) {
                                  ?>
                                    <dt class="col-sm-4">NRO. DE TRANSFERENCIA:</dt>
                                    <dd class="col-sm-8"><?php echo $dato['num_transferencia'] ?></dd>
                                <?php
                                  }
                                }
                                ?>
                              </dl>

                              <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">MONTO TOTAL</th>
                                    <th scope="col">MONTO RESERVA</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td id="monto_total">0 Bs.</td>
                                    <input type="text" value="" name="monto_general" id="monto_general" hidden>

                                    <td><?php echo $dato['monto'] + $dato_suma['monto_aumento']  ?> Bs.</td>
                                  </tr>
                                  <tr>
                                    <td> <strong>TOTAL A CANCELAR</strong></td>
                                    <td id="total_cancelar" class="bg-primary">0 Bs.</td>
                                  </tr>
                                </tbody>
                              </table>

                            </div>

                          </div>

                        </div>
                      </div>
                      <div class="col-sm-7 col-12 col-md-8">
                        <div class="row">
                          <div class="col-12">
                            <h3>DATOS DE LA COMPRA - SEMI CONTADO</h3>
                            <hr class="text-primary bg-primary" style="height: 3px;">

                            <div class="row">
                              <div class="col-6">
                                <label for="precio_dolares">PRECIO EN DOLARES</label>
                                <div class="input-group mb-3">
                                  <input type="number" class="form-control" value="<?php echo $dato['precio_acordado'] ?>" name="precio_dolares" id="precio_dolares" placeholder="Precio en Dolares">
                                  <div class="input-group-append">
                                    <span class="input-group-text">$</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <label for="tipo_cambio">Tipo Cambio</label>
                                <input type="text" value="<?php echo $dato['tipo_cambio'] ?>" name="tipo_cambio" id="tipo_cambio" class="form-control">
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-12">
                                <div class="form-group">
                                  <label for="">POR CONCEPTO DE:</label>
                                  <input type="text" name="concepto" id="" class="form-control">
                                </div>
                              </div>

                            </div>



                            <div class="row">
                              <div class="col-6">
                                <div class="form-group">
                                  <label for="">LA SUMA EN BOLIVIANOS A CANCELAR:</label>
                                  <input type="number" id="numero" name="numero" class="form-control  bg-primary ">
                                </div>
                              </div>
                              <div class="col-6">
                                <label for="">Tipo Moneda</label>
                                <select name="moneda" id="moneda" class="form-control">
                                  <option value="Bolivianos">Bolivianos</option>
                                  <!-- <option value="Dolares">Dolares</option> -->
                                </select>
                              </div>
                            </div>


                            <div class="form-group">
                              <label for="literal">Literal:</label>
                              <textarea id="literal" name="literal" class="form-control" rows="1" readonly></textarea>
                            </div>


                          </div>
                        </div>

                        <script>
                          // Obtén los elementos de los inputs y de la tabla
                          const precioDolares = document.getElementById('precio_dolares');
                          const tipoCambio = document.getElementById('tipo_cambio');
                          const montoTotal = document.getElementById('monto_total');
                          const montoReserva = <?php echo $dato['monto'] + $dato_suma['monto_aumento']; ?>;
                          const totalCancelar = document.getElementById('total_cancelar');
                          const inputNumero = document.getElementById('numero'); // Input del monto en números
                          const textareaLiteral = document.getElementById('literal'); // Textarea para el monto en palabras
                          const inputMontoGeneral = document.getElementById('monto_general'); // Input para el monto en palabras
                          const moneda = "Bolivianos"; // Moneda fija (puedes cambiarla si es necesario)

                          // Función para calcular y actualizar los montos
                          function actualizarMontos() {
                            const precio = parseFloat(precioDolares.value) || 0;
                            const cambio = parseFloat(tipoCambio.value) || 0;

                            // Multiplica el precio en dólares por el tipo de cambio
                            const montoBs = precio * cambio;

                            // Actualiza el monto total en la tabla
                            montoTotal.textContent = `${montoBs.toFixed(2)} Bs.`;

                            // Calcula y actualiza el total a cancelar
                            const totalACancelar = montoBs - montoReserva;
                            totalCancelar.textContent = `${totalACancelar.toFixed(2)} Bs.`;

                            // Actualiza el valor en el input
                            inputNumero.value = totalACancelar.toFixed(2);

                            // Convierte el número a su representación literal y actualiza el textarea
                            convertNumberToLiteral();

                            // Convierte el monto total a su representación literal y lo coloca en inputMontoGeneral
                            const montoLiteral = numberToWords(Math.floor(montoBs));
                            inputMontoGeneral.value = `${montoLiteral.toUpperCase()} ${moneda.toUpperCase()}`;
                          }

                          // Función para convertir el número a su representación literal
                          function convertNumberToLiteral() {
                            const numero = parseFloat(inputNumero.value);
                            if (isNaN(numero)) {
                              textareaLiteral.value = '';
                              return;
                            }

                            const entero = Math.floor(numero);
                            const decimal = Math.round((numero - entero) * 100);
                            const literalEntero = numberToWords(entero);
                            const literalDecimal = decimal < 10 ? `0${decimal}` : decimal;
                            const literalCompleto = `${literalEntero} ${literalDecimal}/100 ${moneda}`;
                            textareaLiteral.value = literalCompleto.toUpperCase();
                          }

                          // Función para convertir un número a palabras
                          function numberToWords(num) {
                            const unidades = ["", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"];
                            const decenas = ["", "diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"];
                            const centenas = ["", "ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"];
                            const especiales = ["diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve"];

                            if (num === 0) return "cero";
                            if (num === 100) return "cien";

                            let words = "";

                            if (num > 999999) {
                              let millones = Math.floor(num / 1000000);
                              words += `${numberToWords(millones)} millón${millones > 1 ? "es" : ""} `;
                              num %= 1000000;
                            }

                            if (num > 999) {
                              let miles = Math.floor(num / 1000);
                              words += `${numberToWords(miles)} mil `;
                              num %= 1000;
                            }

                            if (num > 99) {
                              let centenasIndex = Math.floor(num / 100);
                              if (centenasIndex === 1 && num % 100 === 0) {
                                words += "cien ";
                              } else {
                                words += `${centenas[centenasIndex]} `;
                              }
                              num %= 100;
                            }

                            if (num > 19) {
                              let decenasIndex = Math.floor(num / 10);
                              words += `${decenas[decenasIndex]}`;
                              num %= 10;
                              if (num > 0) {
                                words += ` y ${unidades[num]}`;
                              }
                            } else if (num > 9) {
                              words += `${especiales[num - 10]}`;
                            } else if (num > 0) {
                              words += `${unidades[num]}`;
                            }

                            return words.trim();
                          }

                          // Agrega los eventos para actualizar los montos cuando se cambian los inputs
                          precioDolares.addEventListener('input', actualizarMontos);
                          tipoCambio.addEventListener('input', actualizarMontos);

                          // Inicializar la función para que el valor inicial sea correcto
                          actualizarMontos();
                        </script>

                      </div>
                      <div class="col-12">
                        <h3>CUOTAS MENSUALES</h3>
                        <hr class="text-primary bg-primary" style="height: 5px;">
                        <div class="row">
                          <div class="col-6">
                            <div class="row">
                              <div class="col-12">
                                <div class="form-group">
                                  <label for="">Ingrese la Cantidad de Cuotas</label>
                                  <input type="number" class="form-control" value="<?php echo $dato['fecha_limite_pago'] ?>" name="num_cuotas" id="cantidadCuotas" min="1" placeholder="Número de cuotas">
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Seleccionar Cuotas</label>
                              <select class="select2" multiple="multiple" id="selectCuotas" name="cuotas[]" data-placeholder="Seleccionar Cuotas" style="width: 100%;">
                                <!-- Opciones generadas dinámicamente -->
                              </select>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="row">

                              <div class="col-12">
                                <label>Cuota Inicial</label>

                                <div class="input-group mb-3">
                                  <input type="number" class="form-control" name="cuota_inicial" id="cuota_inicial" placeholder="INGRESE SU PRIMERA CUOTA INICIAL EN DOLARES">
                                  <div class="input-group-append">
                                    <span class="input-group-text">$</span>
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>



                      </div>
                    </div>


                  </div>
                  <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                    <div class="row justify-content-center">
                      <div class="col-12 col-sm-6">
                        <div class="form-group row">
                          <label for="lote" class="col-sm-2 col-form-label">Urbanizacion</label>
                          <div class="col-sm-10">
                            <select name="urbanizacion" id="" class="form-control">
                              <option value="<?php echo $dato['tipo_urbanizacion'] ?>"><?php echo $dato['tipo_urbanizacion'] ?></option>

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
                        <div class="form-group row">
                          <label for="lote" class="col-sm-2 col-form-label">Lote</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $dato['lote'] ?>" name="lote" id="lote" placeholder="Lote">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="manzano" class="col-sm-2 col-form-label">Manzano</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $dato['manzano'] ?>" name="manzano" id="manzano" placeholder="Manzano">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="superficie" class="col-sm-2 col-form-label">Superficie</label>
                          <div class="col-sm-10">
                            <div class="input-group mb-3">
                              <input type="text" value="<?php echo $dato['superficie'] ?>" class="form-control" name="superficie" id="superficie" placeholder="Superficie">
                              <div class="input-group-append">
                                <span class="input-group-text">Mts<sup>2</sup></span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                    <div class="row">
                      <div class="col-12 col-sm-6">
                        <div class="card-body">
                          <dl class="row">

                            <dt class="col-sm-4">PLAN:</dt>
                            <dd class="col-sm-8">SEMI CONTADO</dd>

                            <dt class="col-sm-4">ASESOR DE VENTA:</dt>
                            <dd class="col-sm-8"><?php echo $nombre . " " . $ap_paterno . " " . $ap_materno ?></dd>

                            <dt class="col-sm-4">FECHA:</dt>
                            <dd class="col-sm-8"><?php echo date("Y-m-d H:i:s") ?></dd>

                            <input hidden name="fecha_registro" type="date" value="<?php echo date("Y-m-d") ?>">
                            <dt class="col-sm-4">NUMERO DEL RECIBO:</dt>
                            <dd class="col-sm-8">
                              <input type="text" name="numero_recibo" id="" class="form-control" placeholder="INGRESE EL NUMERO DEL RECIBO DE LA CUOTA INICIAL">
                            </dd>
                          </dl>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="card-header">
                          <h3 class="card-title">
                            <i class="fas fa-bullhorn"></i>
                            Aviso
                          </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                          <div class="callout callout-info">
                            <h5>¡Por favor, revisa todos los campos antes de enviar el formulario!</h5>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- <input type="submit" value="REGISTRAR" class="btn btn-danger"> -->
                    <button type="submit" class="btn btn-primary">REGISTRAR Venta</button>
                  </div>
                </div>
              </div>
            </form>
            <!-- /.card -->
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
<?php include('../../layout/admin/parte2.php'); ?>
<!-- Select2 -->
<script src="../../public/plugins/select2/js/select2.full.min.js"></script>

<script src="script.js"></script>
<script>
  $(function() {
    $('.select2').select2();
  });
</script>

<script>
  $(document).ready(function() {
    const $select = $('#selectCuotas');
    const totalCuotas = 100; // Total number of cuotas

    // Initialize Select2
    $select.select2();

    // Generate options
    function generateOptions() {
      $select.empty(); // Clear existing options
      for (let i = 1; i <= totalCuotas; i++) {
        $select.append(new Option(`${i}° Cuota`, `${i}° Cuota`));
      }
    }

    // Populate options initially
    generateOptions();

    // Set the selected options based on the input value
    function setSelectedOptions() {
      const inputValue = parseInt($('#cantidadCuotas').val(), 10);
      if (!isNaN(inputValue) && inputValue > 0 && inputValue <= totalCuotas) {
        const selectedValues = [];
        for (let i = 1; i <= inputValue; i++) {
          selectedValues.push(`${i}° Cuota`);
        }
        $select.val(selectedValues).trigger('change'); // Set and update Select2
      }
    }

    // Set selected options on page load
    setSelectedOptions();

    // Update select options when input changes
    $('#cantidadCuotas').on('input', function() {
      setSelectedOptions();
    });
  });
</script>

</script>