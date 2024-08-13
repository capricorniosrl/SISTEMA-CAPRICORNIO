$('#login').submit(function(event){
    event.preventDefault(); //almacena los datos sin refrezcar la pagina

    enviar();

}); 

function enviar(){
    
    var datos=$('#login').serialize();
    $.ajax({
        type:"post",
        url:"controller_login.php",
        data:datos,        
        success:function(text){
            if (text=="exito") {
                correcto();
            } else {
                phperror(text);
            }
        }

    })
}

function correcto(){

    $('#mensajeerror').addClass('d-none');
    console.log("datos con exito");

    Swal.fire({
        icon: 'success',
        title: 'Inicio de sesión exitoso 2024',
        text: '¡Bienvenido!',
        showConfirmButton: false,
        timer: 1500
    }).then(function() {
        window.location.href = URL+'/admin/';
    });

    
}

function phperror(text){
    console.log("error");
    $('#mensajeerror').removeClass('d-none');
    $('#msjerror').html(text);

}
