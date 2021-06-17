function busca(){
    $.ajax({
        type: "POST",
        url: "http://localhost:8080/router.php/buscador/find",
        data: {titulo:$("#titulo").val(), pagina:1},
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            $("#resultadosBusqueda").html(result[0]);
            $("#pagindoID").html(result[1]);
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}

function cargaDatos(titulo,pagToloadNext) {
    $.ajax({
        type: "POST",
        url: "http://localhost:8080/router.php/buscador/find",
        data: {titulo:titulo, pagina:pagToloadNext},
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            $("#resultadosBusqueda").html(result[0]);
            $("#pagindoID").html(result[1]);
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}