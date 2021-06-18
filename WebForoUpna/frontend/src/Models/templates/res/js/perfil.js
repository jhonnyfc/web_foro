function updata() {
    $.ajax({
        type: "POST",
        url: "##ORIGIN_NAME##/router.php/back/updateperfil",
        data: {username:$("#username").val(), email:$("#email").val()},
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            if ($('#foto')[0].files.length === 0)
                Swal.fire('Good job!',"Datos actualizados correctamente",'success').then((result) => {
                    window.location.href = "../perfil";
                });
            else{
                subeFoto(result[0]);
            }
        },
        error: function (request, status, error) {
            Swal.fire('Error! data',request.responseText,'error');
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
        url: "http://localhost:1234/router.php/user/upfoto",
        data: form_data,
        withCredentials: true,
        contentType: false,
        processData: false,
        success: function(result) {
            Swal.fire('Good job!',"Datos actualizados correctamente, con foto",'success').then((res) => {
                // ir a perfil
                window.location.href = "../perfil";
            });
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}