function muestraOculta(v1,v2) {
    // Pendiente de implementar
    if (document.getElementById(v2).style.visibility == "hidden"){
        document.getElementById(v2).style.visibility = "visible" 
        document.getElementById(v1).innerHTML = "Ocultar contenidos"
    }
    else{
        document.getElementById(v2).style.visibility = "hidden"
        document.getElementById(v1).innerHTML = "Mostrar contenidos"
    }
}

  window.onload = function(){
// Pendiente de implementar
}