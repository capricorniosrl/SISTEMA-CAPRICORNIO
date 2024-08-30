$('#form_cierre_directo').submit(function(event){
    event.preventDefault();
    enviar();

});
function enviar(){
    var datos=$('#form_cierre_directo').serialize();

    $.ajax({
        type: "post",
        url: "controller_create.php",
        data: datos,
        dataType: "json",
        success: function(response) {
            if (response.error) {
                phperror(response.error);
            } else {
                // Maneja la redirección basada en el plan
                redirigir(response.plan, response.id_informe);
            }
        }

    })
}

function correcto(text){
    
    $('#mensajeerror2').addClass('d-none');

    console.log(text);

}

function phperror(text){
    $('#mensajeerror2').removeClass('d-none');
    $('#msjerror2').html(text);
}
function redirigir(plan, id_informe) {
    let url;

    if (plan === 'contado') {
        url = '../cierre/contado.php?id=' + id_informe;
    } else if (plan === 'semicontado') {
        url = '../cierre/semi-contado.php?id=' + id_informe;
    } else if (plan === 'credito') {
        url = '../cierre/credito.php?id=' + id_informe;
    } else {
        console.error('Opción no válida');
        return;
    }

    window.location.href = url;
}
