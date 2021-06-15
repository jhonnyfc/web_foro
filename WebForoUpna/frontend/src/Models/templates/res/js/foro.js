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
            });
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}
