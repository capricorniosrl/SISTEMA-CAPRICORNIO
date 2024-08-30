<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
?>
<?php
if (isset($_SESSION['session_cierre_directo'])) {
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
          <h1 class="m-0">Registrar Cierre Directo</h1>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-body">
                  <!-- ALERTA -->

                  <div style="background-color: #f8d7da; color: #721c76;" class="alert alert-dismissible d-none" id="mensajeerror2">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fas fa-ban"></i> <b> Se Registraron los Siguientes errores </b>
                    <p><span id="msjerror2"></span></p>
                  </div>
                  <!-- FIN DE ALERTA -->
                  <form id="form_cierre_directo">
                    <h5>Datos del Clientes</h5>
                    <div class="row">

                      <div class="col-4">
                        <div class="form-group">
                          <label for="">Nombre Completo</label>
                          <input type="text" class="form-control" name="nombre" id="">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="">Apellido Paterno</label>
                          <input type="text" class="form-control" name="paterno" id="">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="">Apellido Materno</label>
                          <input type="text" class="form-control" name="materno" id="">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="">Nro. C.I.</label>
                          <input type="number" class="form-control" name="ci" id="">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="">Exp.</label>
                          <select name="exp" id="" class="form-control">
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
                      <div class="col-4">
                        <div class="form-group">
                          <label for="">Celular</label>
                          <input type="number" class="form-control" name="celular" id="">
                        </div>
                      </div>
                    </div>


                    <h5>Datos de la Urbanizacion</h5>
                    <div class="row">
                      <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label>Tipo Urbanizacion</label>
                          <select class="form-control" name="urbanizacion" id="">
                            <?php
                            $query = $pdo->prepare("SELECT * FROM tb_urbanizacion");
                            $query->execute();
                            $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($usuarios as $usuario) {
                            ?>
                              <option value="<?php echo $usuario['nombre_urbanizacion']; ?>"><?php echo $usuario['nombre_urbanizacion']; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-xl-2 col-lg-3 col-md-3">
                        <div class="form-group">
                          <label for="">Lote</label>

                          <input type="text" class="form-control" name="lote" id="">
                        </div>
                      </div>
                      <div class="col-xl-2 col-lg-3 col-md-3">
                        <div class="form-group">
                          <label for="">Manzano</label>

                          <input type="text" class="form-control" name="manzano" id="">
                        </div>
                      </div>
                      <div class="col-xl-2 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label for="">Superficie</label>
                          <input type="number" class="form-control" name="superficie" id="">
                        </div>
                      </div>

                      <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label>FECHA REGISTRO </label>
                          <input type="date" id="agenda" name="fecha_registro" class="form-control" readonly>
                        </div>
                      </div>

                      <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12" id="precio_acordado">
                        <label for="">PRECIO ACORDADO DEL TERRENO EN DOLARES:</label>
                        <div class="input-group mb-3">
                          <input type="number" name="precio_acordado" id="precio_acor" class="form-control" placeholder="PRECIO EN DOLARES">
                          <div class="input-group-append">
                            <span class="input-group-text">Dólares</span>
                          </div>
                        </div>
                      </div>

                      <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
                        <label for="">LITERAL:</label>
                        <div class="form-group">
                          <input type="text" name="precio_acordado_literal" id="precio_acordado_literal" class="form-control" placeholder="MONTO LITERAL">
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
                    </div>
                    <h5>SELECCIONE A QUE PLAN QUIERE IR</h5>
                    <div class="row justify-content-around">
                      <div class="col-3">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="plan" id="contado" value="contado">
                          <label class="form-check-label" for="contado">CONTADO</label>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="plan" id="semicontado" value="semicontado">
                          <label class="form-check-label" for="semicontado">SEMICONTADO</label>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="plan" id="credito" value="credito">
                          <label class="form-check-label" for="credito">CREDITO</label>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-outline-danger btn-block mt-3">REGISTRAR </button>
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


<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0]; // YYYY-MM-DD
    document.getElementById('agenda').value = formattedDate;
  });
</script>

<script src="script.js"></script>

<?php include('../../layout/admin/parte2.php'); ?>