data =  ["Gandalf", "Frodo", "Sam", "Legolas", "Aragorn"]

perso = prompt("Introduce un personaje de El señor de los anillos")

var regex = new RegExp( data.join( "|" ), "i");

if (regex.test( perso ) == true) {
    alert("El personaje pertenece a la peli")
} else {
    alert("Quien es ese????")
}