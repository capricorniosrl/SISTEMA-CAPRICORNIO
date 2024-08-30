$('#formulario-pagos').submit(function(event){
    event.preventDefault(); //almacena los datos sin refrezcar la pagina
    // console.log("HOLA");
    enviar();

});

function enviar(){
    var datos=$('#formulario-pagos').serialize();
    $.ajax({
        type:"post",
        url:"pago_credito.php",
        data:datos,
        success:function(text){
            if (text=="exito") {
                correcto();               
            } else {
                phperror();
            }
        }

    })
}

function correcto(){
    
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      });
      Toast.fire({
        icon: "success",
        title: "REGISTRO CORRECTO"
      }).then(() => {
        // Esperar a que el Toast se cierre antes de recargar la página
        setTimeout(() => {
          location.reload();
        }, 500); // El tiempo debe coincidir con el del Toast
      });
}

function phperror(){
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      });
      Toast.fire({
        icon: "info",
        title: "FALTA INGRESAR EL NUMERO DE RECIBO"
      });
}
 