<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
?>
<?php
if (isset($_SESSION['legal'])) {
  // echo "existe session y paso por el login";
} else {
  // echo "no existe session por que no ha pasado por el login";
  header('Location:' . $URL . '/admin');
}
?>


<?php include('../../layout/admin/parte1.php'); ?>
<!-- summernote -->
<link rel="stylesheet" href="<?php echo $URL ?>/public/plugins/summernote/summernote-bs4.min.css">
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
  .note-editor .note-toolbar {
    position: sticky;
    top: 0;
    width: 100%;
    z-index: 1000;
    /* Asegúrate de que esté sobre otros elementos */
    background-color: white;
    /* Añade un fondo blanco si es necesario para mejorar la visibilidad */
    border-bottom: 1px solid #ddd;
    /* Opcional: añade una línea inferior para separarla del contenido */
    background-color: #343a40;
  }

  .note-editor .note-editable {
    margin-top: 20px;
    /* Ajusta según el tamaño de la barra de herramientas */
  }

  .summernote {
    height: 500px;
    /* A
    justa la altura según tus necesidades */
  }
</style>

<?php
$id_comp = $_GET['id_comp'];
$id_info = $_GET['id_info'];
$sql = $pdo->prepare("SELECT info.*, comp.*, semi.* 
FROM tb_informe info
INNER JOIN tb_agendas ag
INNER JOIN tb_clientes cli
INNER JOIN tb_usuarios us
INNER JOIN tb_comprador comp
INNER JOIN tb_semicontado semi
WHERE (((((info.id_agenda_fk=ag.id_agenda) AND ag.id_cliente_fk=cli.id_cliente) AND ag.id_usuario_fk=us.id_usuario) AND US.id_usuario=comp.id_usuario_fk) AND semi.id_comprador_fk=comp.id_comprador) AND (info.id_informe='$id_info' AND comp.id_comprador='$id_comp')");
$sql->execute();
$datos = $sql->fetch(PDO::FETCH_ASSOC);


$meses = [
  1 => 'Enero',
  2 => 'Febrero',
  3 => 'Marzo',
  4 => 'Abril',
  5 => 'Mayo',
  6 => 'Junio',
  7 => 'Julio',
  8 => 'Agosto',
  9 => 'Septiembre',
  10 => 'Octubre',
  11 => 'Noviembre',
  12 => 'Diciembre'
];
// Obtiene la fecha actual
$fechaActual = getdate(); // Obtiene un array con información sobre la fecha actual

// Extrae el día, el mes y el año
$dia = $fechaActual['mday']; // Día del mes
$mesNumero = $fechaActual['mon']; // Número del mes
$ano = $fechaActual['year']; // Año

// Obtiene el nombre del mes en español usando el número del mes
$mesLiteral = $meses[$mesNumero];


?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">REDACCIÓN DE DOCUMENTOS</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Plantilla Base del Documento
          </h3>
        </div>
        <div class="card-body">
          <form action="controller_contrato.php" method="post">
            <input type="text" name="id_comprador" value="<?php echo $id_comp ?>" id="" hidden>
            <textarea name="contato" id="summernote"><h3 style="text-align: center;" class=""><b>DOCUMENTO PRIVADO DE INTERMEDIACIÓN DE LA VENTA DE UN LOTE DE TERRENO</b></h3><p style="text-align: justify;">Conste por el presente documento privado de compra y venta de un Lote de Terreno, que a solo reconocimiento de firmas y rubricas, tendrá efecto legal como documento público, suscrito bajo las siguientes clausulas:</p><p style="text-align: justify; "><b>PRIMERO.– (DE LAS PARTES):</b> Son partes del presente documento: <b>1.- LILIAN LORENA MACHICADO BUSTILLOS</b> con <b>C.I. 4894713 L.P.</b>, representante legal de la inmobiliaria ¨Inversiones Machicado Bustillos SRL.¨ quien se encuentra como agente inmobiliario para la venta del lote de terreno en cuestión, mayor de edad, hábil por derecho que para efectos del presente se denominara <b>AGENTE INMOBILIARIO</b>. <b>2.- <?php echo $datos['nombre_1'] . " " . $datos['ap_paterno_1'] . " " . $datos['ap_materno_1'] ?></b> con <b>C.I. <?php echo $datos['ci_1'] . " " . $datos['exp_1'] ?></b>, mayor de edad, hábil por derecho <?php if ($datos['ap_paterno_2']) echo "y <b>" . $datos['nombre_2'] . " " . $datos['ap_paterno_2'] . " " . $datos['ap_materno_2'] . "</b> con <b>C.I. " . $datos['ci_2'] . " " . $datos['exp_2'] . "</b>" ?>, que para efectos del presente se <?php echo ($datos['ap_paterno_2']) ? 'denominaran <b>COMPRADORES(a)</b>.' : 'denominara el/la <b>COMPRADOR(a)</b>.'; ?></p><p style="text-align: justify;"><b>SEGUNDA.- (ANTECEDENTES):</b> La Sra. <b>LILIAN LORENA MACHICADO BUSTILLOS</b> con <b>C.I. 4894713 L.P.</b> como su <b>AGENTE INMOBILIARIO</b> para la venta de un lote de terreno con ubicación en Urbanización <b><?php echo $datos['urbanizacion'] ?></b>, Provincia Murillo, Municipio de Achocalla, departamento de La Paz, con una superficie total de <b>250.00 Mts2</b>. Del cual se transfiere el <b>Lote <?php echo $datos['lote'] ?>, Manzano <?php echo $datos['manzano'] ?>, de <?php echo $datos['superficie'] ?> Mts2</b>, debidamente registrado en las oficinas de Derechos Reales bajo el número de <b>Folio Real con Matrícula No. 2.01.3.01.00XXXX.</b></p><p style="text-align: justify;"><b>TERCERA.- (DEL OBJETO):</b> Al presente, de manera libre y voluntario, por así <b>convenir</b> a mis intereses como AGENTE INMOBILIARIO, sin que exista vicios de consentimiento, doy en calidad de venta real, uso y goce perpetua del lote de terreno descrito en la cláusula segunda, a favor del Señor o Señora: <b><?php echo  $datos['nombre_1'] . " " . $datos['ap_paterno_1'] . " " . $datos['ap_materno_1'] ?></b> con <b>C.I. <?php echo $datos['ci_1'] . " " . $datos['exp_1'] ?> L.P.</b>, por el precio total libremente convenido entre partes de la suma de <b>$ <?php echo $datos['precio_acordado'] ?> - (<?php echo $datos['precio_acordado_literal'] ?>)</b>, suma de dinero que será terminada de cancelar en la modalidad de <b>“SEMI CONTADO”</b> A fecha <?php echo date('j', strtotime($datos['fecha_registro'])) ?> de cada mes donde se cancelara la suma de <b>$US XXXXX. (XXXXXXX 00/100 DOLARES AMERICANOS)</b>. en el plazo establecido de mutuo acuerdo. Siendo que a la fecha de suscripción habría cancelado el monto de <b>$US <?php echo $datos['cuota_inicial'] ?> (<?php echo $datos['cuota_inicial_literal'] ?>)</b> por concepto de cuota inicial.</p><p style="text-align: justify;"><b>CUARTA.- (EVICCIÓN Y SANEAMIENTO):</b> El Lote de terreno materia de la presente transferencia, no reconoce gravamen ni hipoteca, sin embargo, de ser necesario como vendedora de buena fe, me obligo a salir a las garantías de evicción y saneamiento conforme a ley garantizando la pacifica posesión lote de terreno a los compradores.</p><p style="text-align: justify;"><b>QUINTA.- (RESPONSABILIDADES Y OBLIGACIONES):</b> La <b>INMOBILIARIA Y CONTRUCCION CAPRICORNIO S.R.L.</b> se compromete de mutuo acuerdo a dar las GARANTÍAS hasta la entrega del documento privado Notariado con el respectivo reconocimiento de firmas y rubricas. La inmobiliaria como intermediaria entre vendedor y comprador se compromete a que no exista ninguna clase de gastos, costos, impuestos o algún monto económico, fuera de lo acordado al momento de la venta; así mismo la inmobiliaria se compromete a cuidar, resguardar los intereses de las partes interesadas.</p><p style="text-align: justify;"><b>SEXTA.- (PENALIDADES Y RESOLUCION CONTRACTUAL):</b> Las penalidades aplicables al presente acuerdo contractual corresponden al incumplimiento a las cuotas mensuales establecidas por parte de la <b>COMPRADORA</b> de lo que se conviene que el incumplimiento de 3 (Tres) cuotas seguidas acarreara la <b>RESOLUCION DE HECHO</b> del presente acuerdo, asimismo la aplicación de una penalización del <b>50% (cincuenta por ciento)</b> del monto de dinero acotado hasta el momento del incumplimiento. De igual manera se realizará la misma penalización en caso de ser solicitada la devolución por parte del comprador.</p><p style="text-align: justify;"><b>SÉPTIMA.- (ALODIALIDAD):</b> Se hace constar que sobre el objeto de la presente transferencia no presenta ningún gravamen ni hipoteca.</p><p style="text-align: justify;"><b>OCTAVA.- (DE LA CALIDAD DEL DOCUMENTO):</b> El presente documento tendrá el carácter de documento privado y el valor establecido por el artículo 519 del Código Civil Boliviano, en caso de no ser elevado a Escritura Pública por cualquier motivo o circunstancia, así mismo ambas partes recíprocamente autorizan, que, si este documento fuera reconocido en sus firmas y rubricas, cualquiera de las partes la podrá protocolizar ante cualquier Notario de Fe Publica.</p><p style="text-align: justify;"><b>NOVENA.- (DE LA CONFORMIDAD):</b> Nosotros <b>INMOBILIARIA &amp; CONSTRUCCION CAPRICORNIO S.R.L.</b> por una parte y por la otra la/el señor(a) <b><?php echo $datos['nombre_1'] . " " . $datos['ap_paterno_1'] . " " . $datos['ap_materno_1'] ?></b> con <b>C.I. <?php echo $datos['ci_1'] . " " . $datos['exp_1'] ?> </b><?php if ($datos['ap_paterno_2']) echo "y <b>" . $datos['nombre_2'] . " " . $datos['ap_paterno_2'] . " " . $datos['ap_materno_2'] . "</b> con <b>C.I. " . $datos['ci_2'] . " " . $datos['exp_2'] . "</b>" ?>, como <?php echo ($datos['ap_paterno_2']) ? '<b>COMPRADORES</b>.' : 'denominara el/la <b>COMPRADOR(a)</b>'; ?>, por la otra, declaramos nuestra conformidad con lo establecido en el presente documento de transferencia de lote de terreno, en señal de aceptación firmamos en doble ejemplar.</p><p style="text-align: right;">La Paz, <?php echo $dia ?> de <?php echo $mesLiteral ?> de <?php echo $ano ?></textarea>
            <button type="submit" class="btn btn-success">REGISTRAR</button>
          </form>

        </div>



      </div><!-- /.container-fluid -->
    </div>
  </div>
</div>
<!-- Summernote -->
<script src="<?php echo $URL ?>/public/plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function() {
    // Summernote
    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>


<?php include('../../layout/admin/parte2.php'); ?>