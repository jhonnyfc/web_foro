num = Math.trunc(Math.random()*10)

alert("Esperamos "+num+" segundos")



setTimeout(
    function(){
        window.open("https://www.w3schools.com"); 
    }, 
    num*1000
);