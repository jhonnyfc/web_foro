function creaForo() {
    $.ajax({
        type: "POST",
        url: "##ORIGIN_NAME##/router.php/back/makeforo",
        data: {titulo:$("#titulo").val(), descripcion:$("#descripcion").val()},
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            // Swal.fire('Good job!'," all right "+result[0],'success');
            subeFoto(result[0]);
        },
        error: function (request, status, error) {
            Swal.fire('Error!!',request.responseText,'error');
        }
    });
}

function subeFoto(fotname) {
    var file_data = $("#foto").prop("files")[0];
    var form_data = new FormData();
    form_data.append('file',file_data);
    form_data.append('fotoname',fotname);
    $.ajax({
        type: "POST",
        url: "http://localhost:1234/router.php/foro/upfoto",
        data: form_data,
        withCredentials: true,
        contentType: false,
        processData: false,
        success: function(result) {
            Swal.fire('Good job!',"Foto subida bien",'success').then((res) => {
                $('#fromMakeforo')[0].reset();
            });
        },
        error: function (request, status, error) {
            Swal.fire('Error!!!',request.responseText,'error');
        }
    });
}