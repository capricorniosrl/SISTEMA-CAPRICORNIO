let celu = 0;
$('#formulario-Contacto').submit(function(event){
    event.preventDefault();
    enviar();
});


function enviar(){
    var datos=$('#formulario-Contacto').serialize();
    $.ajax({
        type:"post",
        url:"controller_create_contaco.php",
        data:datos,
        success:function(text){
            if (text=="exito") {
                correcto_contacto()
            } else {
                phperror_contacto(text)
            }
        }

    })
}

function correcto_contacto(){
    $('#mensaje_contacto').addClass('d-none');
 

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
function phperror_contacto(text){
    // console.log(text);
    $('#mensaje_contacto').removeClass('d-none');
    $('#msjerror').html(text);
}


//mostrar datos en la ventana modal
function modal_agenda(datos_contacto) {
    datoscontacto = datos_contacto.split("||");
    $("#id_contacto").val(datoscontacto[0]);   
    $("#celular_modal").val(datoscontacto[1]); 
    $("#id_usuario").val(datoscontacto[2]);   
}


//mostrar datos en la ventana modal
function modal_agenda_reprogramar(datos_contacto_reprogramar) {
    datoscontacto = datos_contacto_reprogramar.split("||");
    $("#id_contacto_reprogramar").val(datoscontacto[0]);   
    $("#celular_modal_reprogramar").val(datoscontacto[1]); 
    $("#id_usuario_reprogramar").val(datoscontacto[2]);
    $("#id_cliente_reprogramar").val(datoscontacto[3]); 
    $("#nombres").val(datoscontacto[4]); 
    $("#apellidos").val(datoscontacto[5]);  
    $("#detalle").val( datoscontacto[6]);
}

//mostrar datos en la ventana modal
function modal_actualizar_contacto(datos_contacto) {
    datoscontacto_update = datos_contacto.split("||");
    $("#id_contacto_actualizar").val(datoscontacto_update[0]);   
    $("#celular_modal_actualizar").val(datoscontacto_update[1]); 
    $("#id_usuario_actualizar").val(datoscontacto_update[2]); 
    console.log(datos_contacto);
    let cel = datos_contacto.split('||');         
    console.log(cel[1]); 
    celu = cel[1];
}

$('#formulario-Contacto_update').submit(function(evento){
    evento.preventDefault();

    let datos=$('#formulario-Contacto_update').serialize();
    //datos.push({name: 'celular_obtenido', value: celu});
    datos += '&celular_obtenido=' + encodeURIComponent(celu);
    //datos += '&celular_obtenido' + encodeURIComponent(celu);
    $.ajax({
        type:"post",
        url:"controller_update_contacto.php",
        //data:datos,
        data: datos,
        success:function(text){
            //console.log("Respuesta del servidor:", response);
            if (text=="exito") {
                console.log("correcto compañero");
                correcto_update()
            } else{
                console.log("mal compañero");
                phperror_update(text)
            }
        }
    })
    
    
});

document.getElementById('cierra_newreg_cli').addEventListener('click', function() {
    location.reload();
});

document.getElementById('cierra_newreg_contac').addEventListener('click', function() {
    location.reload();
});

document.getElementById('cierraact').addEventListener('click', function() {
    location.reload();
});



function correcto_update(){ 

    Swal.fire(
        'ACTUALIZACION CORRECTA',
        'Se Actualizo el Contacto con Exito',
        'success'
      ).then((result) => {
        if (result.value) {
            window.location.reload();
        }
      });

}

function phperror_update(text){
    console.log(text);
    $('#mensaje2').removeClass('d-none');
    $('#mensaje2').html(text);
}


