function registrar(){
    $.ajax({
        type: "POST",
        url: "http://localhost:8080/router.php/back/registrar",
        data: {username:$("#username").val(), password:$("#password").val(), email:$("#email").val()},
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            Swal.fire('Good job!',"Usuario creado correctamente.<br> Bienvenido: "+result["username"],'success').then((result) => {
                $('#fromRegistrar')[0].reset();
            });
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}