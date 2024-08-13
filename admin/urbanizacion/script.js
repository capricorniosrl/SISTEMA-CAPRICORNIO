$('#formulario').submit(function(event){
    event.preventDefault(); //almacena los datos sin refrezcar la pagina
    
    enviar();

});

function enviar(){
    var datos=$('#formulario').serialize();
    $.ajax({
        type:"post",
        url:"controller_create.php",
        data:datos,
        success:function(text){
            if (text=="exito") {
                $('#nombre').val('');
                correcto();               
            } else {
                phperror(text);
            }
        }

    })
}

function correcto(){
    $('#mensajeerror').addClass('d-none');
 

    Swal.fire(
        'CORRECTO',
        'REGISTRO EXITOSO',
        'success'
      ).then((result) => {
        if (result.value) {
            window.location.reload();
        }
      });

}

function phperror(text){
    console.log("error");
    $('#mensajeerror').removeClass('d-none');
    $('#msjerror').html(text);
}



//mostrar datos en la ventana modal
function modal_tarjeta(datos_cargo) {
    datoscargo = datos_cargo.split("||");
    $("#input_id").val(datoscargo[0]);   
    $("#input_nombre").val(datoscargo[1]);   
}


// actualizar datos de cargo
$('#formulario2').submit(function (event) 
{
    event.preventDefault(); //almacena los datos sin refrezcar la pagina
    enviar_actualizacion();
});

function enviar_actualizacion(){
    var datos=$('#formulario2').serialize();
    $.ajax({
        type:"POST",
        url:"controller_update.php",
        data:datos,
        success:function(text){
            if (text=="exito") {
                correcto_update();               
            } else {
                phperror2(text);
            }
        }

    })
}

function correcto_update(){
    $('#mensajeerror2').addClass('d-none');
 

    Swal.fire(
        'CORRECTO',
        'SE ACTUALIZO EL DATO CON EXITOSO',
        'success'
      ).then((result) => {
        if (result.value) {
            window.location.reload();
        }
      });

}

function phperror2(text){
    console.log("error");
    $('#mensajeerror2').removeClass('d-none');
    $('#msjerror2').html(text);
}


