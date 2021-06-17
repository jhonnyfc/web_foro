function comentarFun(){
    $.ajax({
        type: "POST",
        url: "http://localhost:8080/router.php/back/comentar",
        data: {comentario:$("#comentario").val(), id_foro:$("#id_foro").val()},
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            Swal.fire('Good job!',result[0],'success').then((res) => {
                $('#formComment')[0].reset();
                if ($("#selectebt").text() > 1)
                    toLoad = $("#selectebt").text()
                else
                    toLoad = 1
                cargaDatos($("#id_foro").val(),toLoad);
            });
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}

function cargaDatos(keyword,pagToloadNext){
    $.ajax({
        type: "POST",
        url: "http://localhost:8080/router.php/foro/loadComments",
        data: {id_foro:keyword, pagina:pagToloadNext},
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            $("#contCommentsId").html(result[0]);
            $("#pagindoID").html(result[1]);
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}