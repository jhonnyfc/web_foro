function login() {
    $.ajax({
        type: "POST",
        url: "http://localhost:8080/router.php/back/login",
        data: {username:$("#username").val(), password:$("#password").val()},
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            Swal.fire('Good job!',"Login correcto",'success').then((result) => {
                    window.location.href = "perfil";
            });
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}

// function checkUser() {
//     $.ajax({
//         type: "GET",
//         url: "http://localhost:8080/router.php/back/checkUser",
//         dataType: "json",
//         success: function(result) {
//             // Swal.fire('Good job!',"Session correcta"+result["username"],'success');
            
//         },
//         error: function (request, status, error) {
//             Swal.fire('Error!',request.responseText,'error');
//         }
//     });
// }