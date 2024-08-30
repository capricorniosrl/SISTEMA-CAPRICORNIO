<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
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
        /* Ajusta la altura según tus necesidades */
    }
</style>

<?php
$id_comp = $_GET['id_comp'];

$sql = $pdo->prepare("SELECT * FROM tb_documento WHERE id_comprador_fk='$id_comp'");
$sql->execute();
$datos = $sql->fetch(PDO::FETCH_ASSOC);
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
                    <form action="controller_update_contrato.php" method="post">
                        <input type="text" name="id_documento" value="<?php echo $datos['id_documento'] ?>" hidden>
                        <textarea name="texto" id="summernote"><?php echo $datos['texto'] ?></textarea>
                        <button type="submit" class="btn btn-success">EDITAR DOCUMENTO</button>
                    </form>
                </div>


            </div><!-- /.container-fluid -->
        </div>
    </div>
</div>
<script src="https://cdn.tiny.cloud/1/t2537jv6fs00yo0ry56l6ry7mb53wmv1bydm5ruxsslormaa/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea#descripcion',
        plugins: 'image code',
        toolbar: 'undo redo | link image | code',
        /* enable title field in the Image dialog*/
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        automatic_uploads: true,

        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: (cb, value, meta) => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    /*
                      Note: Now we need to register the blob in TinyMCEs image blob
                      registry. In the next release this part hopefully won't be
                      necessary, as we are looking to handle it internally.
                    */
                    const id = 'blobid' + (new Date()).getTime();
                    const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(',')[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), {
                        title: file.name
                    });
                });
                reader.readAsDataURL(file);
            });

            input.click();
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });
</script>
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