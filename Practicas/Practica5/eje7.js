function clearS(){
    document.getElementById("pantalla1").value = ""
    document.getElementById("pantalla2").value = "?"
    document.getElementById("pantalla3").value = ""
    document.getElementById("pantalla4").value = ""
}

function masS(){
    document.getElementById("pantalla2").value = "+"
}

function restaS(){
    document.getElementById("pantalla2").value = "-"
}

function multS(){
    document.getElementById("pantalla2").value = "*"
}

function divS(){
    document.getElementById("pantalla2").value = "/"
}

function potnS(){
    document.getElementById("pantalla2").value = "^"
}

function maxS(){
    document.getElementById("pantalla2").value = "max"
}

function minS(){
    document.getElementById("pantalla2").value = "min"
}

function resulS(){
    switch (document.getElementById("pantalla2").value) {
        case "+":
            document.getElementById("pantalla4").value = parseFloat(document.getElementById("pantalla1").value) + parseFloat(document.getElementById("pantalla3").value)
        break;
        case "-":
            document.getElementById("pantalla4").value = parseFloat(document.getElementById("pantalla1").value) - parseFloat(document.getElementById("pantalla3").value)
        break;
        case "*":
            document.getElementById("pantalla4").value = parseFloat(document.getElementById("pantalla1").value) * parseFloat(document.getElementById("pantalla3").value)
        break;
        case "/":
            document.getElementById("pantalla4").value = parseFloat(document.getElementById("pantalla1").value) / parseFloat(document.getElementById("pantalla3").value)
        break;
        case "^":
            document.getElementById("pantalla4").value = parseFloat(document.getElementById("pantalla1").value) ** parseFloat(document.getElementById("pantalla3").value)
        break;
        case "max":
            document.getElementById("pantalla4").value = Math.max(parseFloat(document.getElementById("pantalla1").value),parseFloat(document.getElementById("pantalla3").value))
        break;
        case "min":
            document.getElementById("pantalla4").value = Math.min(parseFloat(document.getElementById("pantalla1").value),parseFloat(document.getElementById("pantalla3").value))
        break;
        default:
        break;
    }
}