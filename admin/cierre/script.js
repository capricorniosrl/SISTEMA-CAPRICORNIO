$('#formulario_semicontado').submit(function(event){
    event.preventDefault(); //almacena los datos sin refrezcar la pagina
  

    enviar();

});



function enviar(){
    var datos=$('#formulario_semicontado').serialize();
    $.ajax({
        type:"post",
        url:"create_controller_semicontado.php",
        data:datos,
        success:function(text){
            if (text=="exito") {
                $('#nombre').val('');
                // console.log("EXITO");
                correcto();               
            } else {
                phperror(text);
                // console.log("ERROR");
            }
        }

    })
}

function correcto(){
    

    Swal.fire(
        'CORRECTO',
        'REGISTRO EXITOSO',
        'success'
    ).then((result) => {
        if (result.value) {
            window.location.href = '../reserva/index.php';
        }
    });

}

function phperror(text){
    $('#error').removeClass('d-none');
    $('#error_msj').html(text);
}
