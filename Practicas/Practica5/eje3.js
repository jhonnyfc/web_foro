num = Math.trunc(Math.random()*10)

res = prompt("Introduce el numero, a ver si aciertas")

while (num != res){
    res = prompt("Mal, Introduce el numero, a ver si aciertas")
}

if (res == num) {
    alert("El numero es correcto")
}