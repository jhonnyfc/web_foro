function logout(nav = ""){
    $.ajax({
        type: "GET",
        url: "##ORIGIN_NAME##/router.php/back/logOut",
        withCredentials: true,
        dataType: "json",
        success: function(result) {
            Swal.fire('Good job!',result[0],'success').then((result) => {
                window.location.href = nav+"home";
            });
        },
        error: function (request, status, error) {
            Swal.fire('Error!',request.responseText,'error');
        }
    });
   
}