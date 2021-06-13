function login() {
    $.ajax({
        type: "POST",
        // url: "http://localhost:1234/router.php/user/login",
        url: "http://localhost:8080/router.php/back/login",
        data: {username:$("#username").val(), password:$("#password").val()},
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            Swal.fire('Good job!',"Login correcto",'success');
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}

function checkUser() {
    $.ajax({
        type: "GET",
        url: "http://localhost:1234/router.php/user/getUser",
        dataType: "json",
        success: function(result) {
            Swal.fire('Good job!',"Login correcto",'success');
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}

function logout(){
    $.ajax({
        type: "GET",
        // url: "http://localhost:1234/router.php/user/logout",
        url: "http://localhost:8080/router.php/back/logOut",
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            Swal.fire('Good job!',result[0],'success');
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
}