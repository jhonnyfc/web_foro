function calEsta(){
    sols = ["blanco","nueve","esteban","todos","pera"]

    nota = 0

    val1 = document.getElementById("x1").value
    val2 = document.getElementById("x2").value
    val3 = document.getElementById("x3").value
    val4 = document.getElementById("x4").value
    val5 = document.getElementById("x5").value

    if (val1.toUpperCase() == sols[0].toUpperCase())
        nota++
    
    if (val2.toUpperCase() == sols[1].toUpperCase() || val2 == 9)
        nota++

    if (val3.toUpperCase() == sols[2].toUpperCase())
        nota++

    if (val4.toUpperCase() == sols[3].toUpperCase())
        nota++

    if (val5.toUpperCase() == sols[4].toUpperCase())
        nota++
    
    document.getElementById("resultados").style.visibility = "visible"
    document.getElementById("y1").value = nota
    document.getElementById("y2").value = nota / sols.length *100
}