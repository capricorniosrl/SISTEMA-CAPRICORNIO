<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

if (isset($_POST['usuario_id'])) {
    $usuario_id = $_POST['usuario_id'];

    $query = $pdo->prepare("SELECT ag.detalle_agenda, ag.id_agenda, ag.asistio, ag.fecha_visita, ag.visitantes, ag.detalle, cli.tipo_urbanizacion, cli.nombres, cli.apellidos, con.celular FROM tb_contactos con INNER JOIN tb_clientes cli INNER JOIN tb_agendas ag WHERE (ag.estado=1 AND (ag.id_cliente_fk = cli.id_cliente) AND (cli.id_contacto_fk = con.id_contacto))AND ag.id_usuario_fk='$usuario_id' ORDER BY fecha_visita DESC");

    $query->execute();

    $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

    $contador = 0;

    foreach ($usuarios as $usuario) {

        $contador++;
?>
        <tr>
            <td><?php echo $contador; ?></td>
            <td><?php echo $usuario['nombres'] . " " . $usuario['apellidos']; ?></td>
            <td><?php echo $usuario['celular'] ?></td>
            <td><?php echo date('d-m-Y', strtotime($usuario['fecha_visita'])); ?></td>
            <td><?php echo $usuario['visitantes'] . " "; ?><i class="fas fa-user-check" style="color: #007bff;"></i></td>
            <td><i class="fas fa-map-marked-alt" style="color: #007bff;"></i><?php echo " " . $usuario['tipo_urbanizacion']; ?></td>
            <?php
            if (substr($usuario['detalle_agenda'], 0, 2) == "SE") {
            ?>
                <td class="text-danger"><?php echo $usuario['detalle_agenda']; ?></td>
                <td>
                    <label class="custom-checkbox" hidden>
                        <input name="check" type="checkbox" autocomplete="off" data-id="<?php echo $usuario['id_agenda']; ?>" <?php echo $usuario['asistio'] == 'SI' ? 'checked' : ''; ?>>
                        <div class="checkbox-container">
                            <div class="checkbox-slider"></div>
                        </div>
                        <span class="checkbox-text"><?php echo $usuario['asistio'] == 'SI' ? 'ASISTIÓ' : 'NO ASISTIÓ'; ?></span>
                    </label>
                </td>
                <td>

                    <a href="designar.php?id=<?php echo $usuario['id_agenda']; ?>" type="button" class="btn btn-outline-primary disabled" disabled hidden> <i class="fas fa-user"></i> DESIGNAR</a>
                </td>

            <?php
            } else {
            ?>
                <td><strong><?php echo $usuario['detalle_agenda']; ?></strong></td>
                <td>
                    <!-- ESTILOS PARA EL CHECKBOX -->
                    <style>
                        .custom-checkbox {
                            display: flex;
                            align-items: center;
                            cursor: pointer;
                        }

                        .custom-checkbox input[type=checkbox] {
                            position: absolute;
                            opacity: 0;
                        }

                        .custom-checkbox .checkbox-container {
                            display: flex;
                            align-items: center;
                            width: 40px;
                            height: 20px;
                            border-radius: 15px;
                            background-color: #dee2e6;
                            position: relative;
                            transition: background-color 0.3s;
                        }

                        .custom-checkbox input[type=checkbox]:checked+.checkbox-container {
                            background-color: #28a745;
                            /* Verde cuando asistió */
                        }

                        .custom-checkbox input[type=checkbox]:not(:checked)+.checkbox-container {
                            background-color: #dc3545;
                            /* Rojo cuando no asistió */
                        }

                        .custom-checkbox .checkbox-slider {
                            position: absolute;
                            width: 24px;
                            height: 24px;
                            border-radius: 50%;
                            background: white;
                            top: -2px;
                            left: -2px;
                            transition: transform 0.3s;
                        }

                        .custom-checkbox input[type=checkbox]:checked+.checkbox-container .checkbox-slider {
                            transform: translateX(20px);
                        }

                        .custom-checkbox .checkbox-text {
                            margin-left: 10px;
                            color: red;
                            font-size: 14px;
                            font-weight: bold;
                        }

                        .custom-checkbox input[type=checkbox]:checked~.checkbox-text {
                            color: black;
                        }

                        .custom-checkbox input[type=checkbox]:not(:checked)~.checkbox-text {
                            color: red;
                        }

                        .custom-checkbox input[type=checkbox]:disabled~.checkbox-container {
                            background-color: #b6b4b4;
                        }
                    </style>
                    <label class="custom-checkbox">
                        <input name="check" type="checkbox" autocomplete="off" data-id="<?php echo $usuario['id_agenda']; ?>" <?php echo $usuario['asistio'] == 'SI' ? 'checked' : ''; ?>>
                        <div class="checkbox-container">
                            <div class="checkbox-slider"></div>
                        </div>
                        <span class="checkbox-text"><?php echo $usuario['asistio'] == 'SI' ? 'ASISTIÓ' : 'NO ASISTIÓ'; ?></span>
                    </label>
                </td>
                <td>

                    <a href="designar.php?id=<?php echo $usuario['id_agenda']; ?>" type="button" class="btn btn-outline-primary"> <i class="fas fa-user"></i> DESIGNAR</a>
                </td>
            <?php
            }
            ?>
        </tr>

<?php


    }
}
?>