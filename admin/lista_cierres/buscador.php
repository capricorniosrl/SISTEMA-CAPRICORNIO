<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

if (isset($_SESSION['busqueda_cierres'])) {
    // echo "existe session y paso por el login";
} else {
    // echo "no existe session por que no ha pasado por el login";
    header('Location:' . $URL . '/admin');
}

header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");
?>
<?php include('../../layout/admin/parte1.php'); ?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Buscador General</h1>
                </div>
            </div>

            <section class="content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card card-primary animate_animated animate_flipInX">
                                <div class="card-body">
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="form-group">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="input-group mb-3">

                                                                <div class="input-group-text">
                                                                    <input type="checkbox" aria-label="Checkbox for following text input" id="checkurba" name="checkurba" onclick="deshabilitainput()" required>
                                                                </div>


                                                            </div>
                                                        </td>
                                                        <td>Urbanizacion</td>
                                                        <td>

                                                            <select class="form-control" name="subcategoriaTerrenos" id="subcategoriaTerrenos">
                                                                <option value=""></option>
                                                            </select>
                                                            <script>
                                                                //const categoriaSelect = document.getElementById('categoria');
                                                                const subcategoriaTerrenosSelect = document.getElementById('subcategoriaTerrenos');

                                                                // Limpiar las opciones del segundo select
                                                                subcategoriaTerrenosSelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';

                                                                // Habilitar el segundo select


                                                                // Obtener el valor seleccionado en el primer select
                                                                //const categoriaSeleccionada = categoriaSelect.value;

                                                                // Aquí puedes agregar la lógica para obtener las subcategorías
                                                                // dependiendo de la categoría seleccionada, por ejemplo:
                                                                //if (categoriaSeleccionada === '1') {
                                                                //$('#subcategoriaTerrenosSelect').removeClass('d-none');
                                                                //buscar.disabled = true;
                                                                //$('#subcategoriaopt').removeClass('d-none');
                                                                //subcategorialbl.hidden = false;
                                                                //subcategoriaSelect.hidden = false;
                                                                //consultarDatos(idUrbanizacion)
                                                                <?php
                                                                // Asegúrate de que esta sección de código PHP esté dentro de un archivo PHP
                                                                $sql = $pdo->prepare("SELECT * FROM tb_urbanizacion");
                                                                $sql->execute();
                                                                $datos = $sql->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach ($datos as $valor) {
                                                                    // Escribe el valor de la opción en el JavaScript como una cadena de texto
                                                                    //echo "subcategoriaSelect.add(new Option('{$valor['nombre_urbanizacion']}', '{$valor['id_urbanizacion']}'));";
                                                                    echo "subcategoriaTerrenosSelect.add(new Option('{$valor['nombre_urbanizacion']}', '{$valor['nombre_urbanizacion']}'));";
                                                                    //echo "subcategoriaTerrenosSelect.value='"."hola"."'";

                                                                    //echo "subcategoriaSelect.add(new Option('{$valor['nombre_urbanizacion']}', '{$valor['id_urbanizacion']}'));";
                                                                }
                                                                ?>
                                                            </script>



                                                        </td>


                                                        </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="input-group mb-3">

                                                                <div class="input-group-text">
                                                                    <input type="checkbox" aria-label="Checkbox for following text input" id="checklote" name="checklote" onclick="deshabilitainput2()" required>
                                                                </div>


                                                            </div>
                                                        </td>
                                                        <td>Lote</td>
                                                        <td>
                                                            <input class="form-control" type="text" id="buscarlote" name="buscarlote" required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="input-group mb-3">

                                                                <div class="input-group-text">
                                                                    <input type="checkbox" aria-label="Checkbox for following text input" id="checkmanzano" name="checkmanzano" onclick="deshabilitainput3()" required>
                                                                </div>


                                                            </div>
                                                        </td>
                                                        <td>Manzano</td>
                                                        <td>
                                                            <input class="form-control" type="text" id="buscarmanzano" name="buscarmanzano" required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="input-group mb-3">

                                                                <div class="input-group-text">
                                                                    <input type="checkbox" aria-label="Checkbox for following text input" id="checkci" name="checkci" onclick="deshabilitainput4()" required>
                                                                </div>


                                                            </div>
                                                        </td>
                                                        <td>CI</td>
                                                        <td>
                                                            <input class="form-control" type="text" id="buscarci" name="buscarci" required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="input-group mb-3">

                                                                <div class="input-group-text">
                                                                    <input type="checkbox" aria-label="Checkbox for following text input" id="checkcelular" name="checkcelular" onclick="deshabilitainput5()" required>
                                                                </div>


                                                            </div>
                                                        </td>
                                                        <td>Celular</td>
                                                        <td>
                                                            <input class="form-control" type="text" id="buscarcelular" name="buscarcelular" required>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!--
                                            <label for="buscar">Seleccione el tipo de Busqueda</label>
                                            <input class="form-control" type="text" id="buscar" name="buscar" required>
                                            <label id="categorialbl" name="categorialbl">Categoria<span class="text-danger">*</span> </label>
                                            <select class="form-control" id="categoria" name="categoria" onchange="mostrarSubcategorias(this.value)">
                                                <option selected="true" disabled="disabled">SELECCIONE UNA CATEGORIA</option>
                                                <option id="1" value="1">URBANIZACION</option>
                                                <option value="2">MANZANO</option>
                                                <option value="3">LOTE</option>
                                                <option value="4">CI</option>
                                                <option value="5">CELULAR</option>
                                            </select>

                                            <div id="resultado"></div>

                                            <label for="subcategoria" id="subcategorialbl" name="subcategorialbl" hidden>Tipo de Urbanizacion:</label>
                                             <select class="form-control" id="subcategoria" name="subcategoria" hidden>
                                                <option value="">Seleccione una subcategoría</option>
                                            </select>

                                            <?php
                                            $sql = $pdo->prepare("SELECT * FROM tb_urbanizacion");
                                            $sql->execute();
                                            $datos = $sql->fetchAll(PDO::FETCH_ASSOC);

                                            ?>
                                            <select class="form-control d-none" id="subcategoria" name="subcategoria">
                                                <option value="">Seleccione una subcategoría</option>

                                                ?>

                                            </select>-->

                                        </div>
                                        <input type="submit" value="Buscar" class="form-control">
                                    </form>


                                    <script>
                                        function muestramensaje() {
                                            $('#mensaje_vacio').removeClass('d-none');

                                        }

                                        function ocultamensaje() {
                                            $('#mensaje_vacio').addClass('d-none');
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <script>
        $('#checkurba').click(function() {
            // Si esta seleccionado (si la propiedad checked es igual a true)
            if ($(this).prop('checked')) {
                console.log("presionado");
                // Selecciona cada input que tenga la clase .checar
                $('#checkci').prop('disabled', true);
                $('#checkcelular').prop('disabled', true);
            } else {
                $('#checkci').prop('disabled', false);
                $('#checkcelular').prop('disabled', false);
            }



        });

        function deshabilitainput() {
            var checkurba = document.getElementById('checkurba');
            var ci = document.getElementById('buscarci');
            var celular = document.getElementById('buscarcelular');
            var checklote = document.getElementById('checklote');
            var checkmanzano = document.getElementById('checkmanzano');

            if (checkurba.checked) {
                ci.disabled = true;
                ci.removeAttribute('required');
                celular.disabled = true;
                celular.removeAttribute('required')
                checklote.removeAttribute('required')
                checkmanzano.removeAttribute('required')
            } else {
                ci.disabled = false;
                ci.setAttribute('required', true);
                celular.disabled = false;
                celular.setAttribute('required', true);
                checklote.setAttribute('required', true);
                checkmanzano.setAttribute('required', true);
            }
        }

        function deshabilitainput2() {
            var checklote = document.getElementById('checklote');
            var ci = document.getElementById('buscarci');
            var celular = document.getElementById('buscarcelular');

            if (checklote.checked) {
                ci.disabled = true;
                ci.removeAttribute('required');
                celular.disabled = true;
                celular.removeAttribute('required');
            } else {
                ci.disabled = false;
                ci.setAttribute('required', true);
                celular.disabled = false;
                celular.setAttribute('required', true);
            }
        }

        function deshabilitainput3() {
            var checkmanzano = document.getElementById('checkmanzano');
            var ci = document.getElementById('buscarci');
            var celular = document.getElementById('buscarcelular');

            if (checkmanzano.checked) {
                ci.disabled = true;
                ci.removeAttribute('required');
                celular.disabled = true;
                celular.removeAttribute('required');
            } else {
                ci.disabled = false;
                ci.setAttribute('required', true);
                celular.disabled = false;
                celu.setAttribute('required', true);
            }
        }

        function deshabilitainput4() {
            var checkurba = document.getElementById('checkurba');
            var checklote = document.getElementById('checklote');
            var checkmanzano = document.getElementById('checkmanzano');
            var lote = document.getElementById('buscarlote');
            var manzano = document.getElementById('buscarmanzano');
            var checkci = document.getElementById('checkci');
            var urbanizacion = document.getElementById('subcategoriaTerrenos');
            var celular = document.getElementById('buscarcelular');

            if (checkci.checked) {
                checkurba.disabled = true;
                checkurba.removeAttribute('required')
                checklote.disabled = true;
                checklote.removeAttribute('required')
                checkmanzano.disabled = true;
                checkmanzano.removeAttribute('required')
                celular.disabled = true;
                celular.removeAttribute('required')
                urbanizacion.disabled = true;
                urbanizacion.removeAttribute('required')
                lote.disabled = true;
                lote.removeAttribute('required')
                manzano.disabled = true;
                manzano.removeAttribute('required')
            } else {
                checkurba.disabled = false;
                checkurba.setAttribute('required', true);
                checklote.disabled = false;
                checklote.setAttribute('required', true);
                checkmanzano.disabled = false;
                checkmanzano.setAttribute('required', true);
                celular.disabled = false;
                celular.setAttribute('required', true);
                urbanizacion.disabled = false;
                urbanizacion.setAttribute('required', true);
                lote.disabled = false;
                lote.setAttribute('required', true);
                manzano.disabled = false;
                manzano.setAttribute('required', true);
            }
        }


        function deshabilitainput5() {
            var checkurba = document.getElementById('checkurba');
            var checkcelular = document.getElementById('checkcelular');
            var checklote = document.getElementById('checklote');
            var checkmanzano = document.getElementById('checkmanzano');
            var lote = document.getElementById('buscarlote');
            var manzano = document.getElementById('buscarmanzano');
            var checkci = document.getElementById('checkci');
            var urbanizacion = document.getElementById('subcategoriaTerrenos');
            var ci = document.getElementById('buscarci');

            if (checkcelular.checked) {
                checkurba.disabled = true;
                checkurba.removeAttribute('required')
                checklote.disabled = true;
                checklote.removeAttribute('required')
                checkmanzano.disabled = true;
                checkmanzano.removeAttribute('required')
                ci.disabled = true;
                ci.removeAttribute('required')
                urbanizacion.disabled = true;
                urbanizacion.removeAttribute('required')
                lote.disabled = true;
                lote.removeAttribute('required')
                manzano.disabled = true;
                manzano.removeAttribute('required')
                checkci.disabled = true;
                checkci.removeAttribute('required')
            } else {
                checkurba.disabled = false;
                checkurba.setAttribute('required', true);
                checklote.disabled = false;
                checklote.setAttribute('required', true);
                checkmanzano.disabled = false;
                checkmanzano.setAttribute('required', true);
                ci.disabled = false;
                ci.setAttribute('required', true);
                urbanizacion.disabled = false;
                urbanizacion.setAttribute('required', true);
                lote.disabled = false;
                lote.setAttribute('required', true);
                manzano.disabled = false;
                manzano.setAttribute('required', true);
                checkci.disabled = false;
                checkci.setAttribute('required', true);
            }
        }


        $('#checklote').click(function() {
            // Si esta seleccionado (si la propiedad checked es igual a true)
            if ($(this).prop('checked')) {
                console.log("presionado");
                // Selecciona cada input que tenga la clase .checar
                $('#checkci').prop('disabled', true);
                $('#checkcelular').prop('disabled', true);
            } else {
                $('#checkci').prop('disabled', false);
                $('#checkcelular').prop('disabled', false);
            }
        });

        $('#checkmanzano').click(function() {
            // Si esta seleccionado (si la propiedad checked es igual a true)
            if ($(this).prop('checked')) {
                console.log("presionado");
                // Selecciona cada input que tenga la clase .checar
                $('#checkci').prop('disabled', true);
                $('#checkcelular').prop('disabled', true);
            } else {
                $('#checkci').prop('disabled', false);
                $('#checkcelular').prop('disabled', false);
            }
        });

        $('#checkci').click(function() {
            if ($(this).prop('checked')) {
                console.log("presionado");
                // Selecciona cada input que tenga la clase .checar
                $('#checkurba').prop('disabled', true);
                $('#checklote').prop('disabled', true);
                $('#checkmanzano').prop('disabled', true);
                $('#checkcelular').prop('disabled', true);
            } else {
                $('#checkurba').prop('disabled', false);
                $('#checklote').prop('disabled', false);
                $('#checkmanzano').prop('disabled', false);
                $('#checkcelular').prop('disabled', false);
            }
        });
        $('#checkcelular').click(function() {
            if ($(this).prop('checked')) {
                console.log("presionado");
                // Selecciona cada input que tenga la clase .checar
                $('#checkurba').prop('disabled', true);
                $('#checklote').prop('disabled', true);
                $('#checkmanzano').prop('disabled', true);
            } else {
                $('#checkurba').prop('disabled', false);
                $('#checklote').prop('disabled', false);
                $('#checkmanzano').prop('disabled', false);
            }
        });
    </script>


    <!--aqui empieza la tabla y la busqueda-->

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary animate_animated animate_flipInX">
                <div class="card-body">
                    <style>
                        .table-responsive_1 {
                            width: 100%;
                            /* O un valor fijo como 800px si prefieres */
                            overflow-x: auto;
                            /* Habilita el desplazamiento horizontal */
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                            /* Opcional, para mejorar el diseño */
                        }

                        th,
                        td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }

                        th {
                            background-color: #f4f4f4;
                        }
                    </style>
                    <div class="table-responsive_1">
                        <table class="table" id="example" class="display " style="width:100%">
                            <thead class="d-none" id="titulos_tabla" name="titulos_tabla">
                                <tr>
                                    <th>LOTE</th>
                                    <th>MANZANO</th>
                                    <th>TIPO URBANIZACION</th>
                                    <th>SUPERFICIE</th>
                                    <th>NOMBRES</th>
                                    <th>APELLIDO PATERNO</th>
                                    <th>APELLIDO MATERNO</th>
                                    <th>CI</th>
                                    <th>EXP</th>
                                    <th>CELULAR</th>
                                    <th>PAGOS</th>
                                </tr>
                            </thead>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $subcategoriaTerreno = $_POST['subcategoriaTerrenos'] ?? '';
                                $lote = $_POST['buscarlote'] ?? '';
                                $manzano = $_POST['buscarmanzano'] ?? '';
                                $ci = $_POST['buscarci'] ?? '';
                                $celular = $_POST['buscarcelular'] ?? '';
                                $urbanizacion = $_POST['checkurba'] ?? '';
                                $checkci = $_POST['checkci'] ?? '';
                                $checkcelular = $_POST['checkcelular'] ?? '';
                                echo "lote: " . $lote;
                                echo "id_terreno: " . $subcategoriaTerreno;
                                echo "manzano: " . $manzano;
                                echo "ci: " . $ci;
                                echo "celular: " . $celular;

                                if (isset($urbanizacion)) {
                                    echo "<script>ocultamensaje();</script>";
                                    $query = $pdo->prepare("SELECT 
                                        com.id_comprador,
                                        info.lote, 
                                        info.manzano,
                                        cli.tipo_urbanizacion,
                                        info.superficie,
                                        com.nombre_1,
                                        com.ap_paterno_1,
                                        com.ap_materno_1,
                                        com.ci_1,
                                        com.exp_1,
                                        com.celular_1
                                        FROM 
                                        tb_agendas ag
                                        INNER JOIN 
                                        tb_clientes cli ON ag.id_cliente_fk = cli.id_cliente
                                        INNER JOIN 
                                        tb_contactos contac ON cli.id_contacto_fk = contac.id_contacto
                                        INNER JOIN 
                                        tb_comprador com ON contac.celular = com.celular_1
                                        LEFT JOIN 
                                        tb_informe info ON info.id_agenda_fk = ag.id_agenda
                                        LEFT JOIN 
                                        tb_semicontado sem ON sem.id_comprador_fk = com.id_comprador
                                        LEFT JOIN 
                                        tb_credito cre ON cre.id_comprador_fk = com.id_comprador
                                        LEFT JOIN 
                                        tb_contado cont ON cont.id_comprador_fk = com.id_comprador
                                        WHERE 
                                        cli.tipo_urbanizacion = :subcategoria AND info.lote = :lote AND info.manzano = :manzano
                                        AND 
                                        (cont.id_comprador_fk = com.id_comprador 
                                        OR sem.id_comprador_fk = com.id_comprador 
                                        OR cre.id_comprador_fk = com.id_comprador)
                                        GROUP BY 
                                        com.ci_1
                                        ORDER BY 
                                        com.ci_1 DESC;");

                                    $query->bindParam(':subcategoria', $subcategoriaTerreno);
                                    $query->bindParam(':lote', $lote);
                                    $query->bindParam(':manzano', $manzano);
                                    $query->execute();

                                    // Mostramos los resultados
                                    $resultados = $query->fetchAll();
                                    $nro_filas = is_array($resultados) ? count($resultados) : 0;
                                    if ($nro_filas > 0) {

                            ?>
                                        <script>
                                            $('#titulos_tabla').removeClass('d-none');
                                        </script>
                                        <?php
                                        echo '<h2>Resultados de la búsqueda</h2>';
                                        foreach ($resultados as $resultado) {
                                            $id_com = $resultado['id_comprador'];
                                            $carnet = $resultado['ci_1'];
                                            //$resul = $resultado['id_comprador'];

                                        ?>
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        <p> <?php echo $resultado['lote'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['manzano'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['tipo_urbanizacion'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['superficie'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['nombre_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['ap_paterno_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['ap_materno_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['ci_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['exp_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['celular_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#actualizar_contacto"
                                                            onclick="mostrarmensaje('<?php echo $id_com; ?>','<?php echo $carnet; ?>')"><i class="fas fa-wallet"></i></a>
                                                        <script>
                                                            function mostrarmensaje(a, b) {
                                                                //localStorage.setItem('id_c', a);
                                                                //console.log("carnet: "+b);
                                                                window.location.href = 'controller_buscador.php?variable=' + a + '&carnet=' + b;
                                                            }
                                                        </script>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        <?php
                                        }
                                    } else {
                                        //echo "<script>alert("."no hay datos".");</script>";
                                    }
                                }

                                if (isset($ci)) {
                                    $query = $pdo->prepare("SELECT 
                                            com.id_comprador,
                                            info.lote, 
                                            info.manzano,
                                            cli.tipo_urbanizacion,
                                            info.superficie,
                                            com.nombre_1,
                                            com.ap_paterno_1,
                                            com.ap_materno_1,
                                            com.ci_1,
                                            com.exp_1,
                                            com.celular_1
                                        FROM 
                                            tb_agendas ag
                                        INNER JOIN 
                                            tb_clientes cli ON ag.id_cliente_fk = cli.id_cliente
                                        INNER JOIN 
                                            tb_contactos contac ON cli.id_contacto_fk = contac.id_contacto
                                        INNER JOIN 
                                            tb_comprador com ON contac.celular = com.celular_1
                                        LEFT JOIN 
                                            tb_informe info ON info.id_agenda_fk = ag.id_agenda
                                        LEFT JOIN 
                                            tb_semicontado sem ON sem.id_comprador_fk = com.id_comprador
                                        LEFT JOIN 
                                            tb_credito cre ON cre.id_comprador_fk = com.id_comprador
                                        LEFT JOIN 
                                            tb_contado cont ON cont.id_comprador_fk = com.id_comprador
                                        WHERE 
                                            com.ci_1 = :buscar 
                                        AND 
                                            (cont.id_comprador_fk = com.id_comprador 
                                            OR sem.id_comprador_fk = com.id_comprador 
                                            OR cre.id_comprador_fk = com.id_comprador)
                                        GROUP BY 
                                            com.ci_1
                                        ORDER BY 
                                            com.ci_1 DESC;
                                        ");

                                    $query->bindParam(':buscar', $ci);
                                    $query->execute();

                                    // Mostramos los resultados
                                    $resultados = $query->fetchAll();
                                    $nro_filas = is_array($resultados) ? count($resultados) : 0;
                                    if ($nro_filas > 0) {
                                        //echo "hola hola";
                                        //echo "<script>ocultamensaje()</script>";
                                        //echo '<h2>Resultados de la búsqueda</h2>';
                                        foreach ($resultados as $resultado) {
                                            //$resul = $resultado['id_comprador'];
                                            $id_com = $resultado['id_comprador'];
                                            $carnet = $resultado['ci_1'];
                                        ?>
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        <p> <?php echo $resultado['lote'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['manzano'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['tipo_urbanizacion'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['superficie'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['nombre_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['ap_paterno_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['ap_materno_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['ci_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['exp_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['celular_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#actualizar_contacto"
                                                            onclick="mostrarmensaje('<?php echo $id_com; ?>','<?php echo $carnet; ?>')"><i class="fas fa-wallet"></i></a>

                                                        <script>
                                                            function mostrarmensaje(a, b) {
                                                                //localStorage.setItem('id_c', a);
                                                                //console.log("carnet: "+b);
                                                                window.location.href = 'controller_buscador.php?variable=' + a + '&carnet=' + b;
                                                            }
                                                        </script>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        <?php
                                        }
                                    } else {
                                        echo "<script>
                                                $('#titulos_tabla').addClass('d-none');
                                                muestramensaje();
                                                </script>";
                                    }
                                }

                                if (isset($celular)) {
                                    echo "<script>ocultamensaje();</script>";
                                    $query = $pdo->prepare("SELECT 
                                            com.id_comprador,
                                            info.lote, 
                                            info.manzano,
                                            cli.tipo_urbanizacion,
                                            info.superficie,
                                            com.nombre_1,
                                            com.ap_paterno_1,
                                            com.ap_materno_1,
                                            com.ci_1,
                                            com.exp_1,
                                            com.celular_1
                                        FROM 
                                            tb_agendas ag
                                        INNER JOIN 
                                            tb_clientes cli ON ag.id_cliente_fk = cli.id_cliente
                                        INNER JOIN 
                                            tb_contactos contac ON cli.id_contacto_fk = contac.id_contacto
                                        INNER JOIN 
                                            tb_comprador com ON contac.celular = com.celular_1
                                        LEFT JOIN 
                                            tb_informe info ON info.id_agenda_fk = ag.id_agenda
                                        LEFT JOIN 
                                            tb_semicontado sem ON sem.id_comprador_fk = com.id_comprador
                                        LEFT JOIN 
                                            tb_credito cre ON cre.id_comprador_fk = com.id_comprador
                                        LEFT JOIN 
                                            tb_contado cont ON cont.id_comprador_fk = com.id_comprador
                                        WHERE 
                                            com.celular_1 = :buscar
                                        AND 
                                            (cont.id_comprador_fk = com.id_comprador 
                                            OR sem.id_comprador_fk = com.id_comprador 
                                            OR cre.id_comprador_fk = com.id_comprador)
                                        GROUP BY 
                                            com.ci_1
                                        ORDER BY 
                                            com.ci_1 DESC;");

                                    $query->bindParam(':buscar', $celular);
                                    $query->execute();

                                    // Mostramos los resultados
                                    $resultados = $query->fetchAll();
                                    $nro_filas = is_array($resultados) ? count($resultados) : 0;
                                    if ($nro_filas > 0) {
                                        echo "<script>ocultamensaje()</script>";
                                        echo '<h2>Resultados de la búsqueda</h2>';
                                        foreach ($resultados as $resultado) {
                                            //echo "resultados: ".$resultado;
                                            $id_com = $resultado['id_comprador'];
                                            $carnet = $resultado['ci_1'];
                                            //$resul = $resultado['id_comprador'];

                                        ?>
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        <p> <?php echo $resultado['lote'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['manzano'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['tipo_urbanizacion'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['superficie'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['nombre_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['ap_paterno_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['ap_materno_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['ci_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['exp_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <p> <?php echo $resultado['celular_1'] ?> </p>
                                                    </th>
                                                    <th>
                                                        <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#actualizar_contacto"
                                                            onclick="mostrarmensaje('<?php echo $id_com; ?>','<?php echo $carnet; ?>')"><i class="fas fa-wallet"></i></a>

                                                        <script>
                                                            function mostrarmensaje(a, b) {
                                                                //localStorage.setItem('id_c', a);
                                                                //console.log("carnet: "+b);
                                                                window.location.href = 'controller_buscador.php?variable=' + a + '&carnet=' + b;
                                                            }
                                                        </script>
                                                    </th>
                                                </tr>
                                            </tbody>
                                    <?php
                                        }
                                    } else {
                                        echo "<script>
                                            $('#titulos_tabla').addClass('d-none');
                                            muestramensaje();
                                            </script>";
                                    }
                                    ?>
                                    <script>
                                        $('#titulos_tabla').addClass('d-none');
                                    </script>
                            <?php
                                }
                            }

                            ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('../../layout/admin/parte2.php'); ?>