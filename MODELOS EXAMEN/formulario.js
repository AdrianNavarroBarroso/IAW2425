function validar(elementos){
    let estanCorrectos = true;
    for (var i=0;i<elementos.length;i++){
        document.getElementById("campo"+(i+1).toString()).innerHTML = ""; // Por defecto el campo está OK       
        if (elementos[i].value == "" || (i==6 && !elementos[i].checked)){
            // Si el campo está vacío o (el campo es la casilla de verificación y no está marcada) entonces ...
            document.getElementById("campo"+(i+1).toString()).innerHTML = "El campo " + elementos[i].id + " está vacío";
            estanCorrectos = false;
        }
        
    }
    if (!validarEmail()){ // Si no es válido el correo
        document.getElementById("campo3").innerHTML = "Email no válido";        
        estanCorrectos = false;
    }
    if (!validaPasswords()){ // Si no son válidas las contraseñas
        document.getElementById("campo4").innerHTML = "La contraseña no cumple con requisitos de longitud o no coinciden";        
        document.getElementById("campo5").innerHTML = "La contraseña no cumple con requisitos de longitud o no coinciden";
        estanCorrectos = false;
    }
    if (!validarDNI()){
        document.getElementById("campo6").innerHTML = "DNI no válido (12345678X)";
        estanCorrectos = false;
    }
    return estanCorrectos;
}
/* Función validarEmail tomada de:
* https://www.coderbox.net/blog/validar-email-usando-javascript-y-expresiones-regulares/
*/
function validarEmail(){              
	var valido;
	var emailField = document.getElementById('email');
	var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
	if( validEmail.test(emailField.value) ){
		valido=true;
	}else{
        valido=false;
	}
    return valido;
} 
function validaPasswords(){
    // return (document.getElementById("password1").value == document.getElementById("password2").value) && document.getElementById("password2").value.length>=8;
    let clave1 = document.getElementById("password").value;
    let clave2 = document.getElementById("r_password").value;
    let passwordsOK = true; // Cumple con los requisitos establecidos
    if (clave1.length<8 || (clave1!=clave2))
        passwordsOK = false;
    return passwordsOK;
}

function validarDNI(){
    var letra=['T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E'];
    var cadena = document.getElementById("dni").value.toUpperCase(); // DNI Completo en mayúsculas
    var cadena2 = cadena.replace(/\s+/g, ''); // Elimina los espacios en la cadena
    var numero = parseInt(cadena2.substring(0,8)); // Parte numérica
    var letraUsuario = cadena2[8]; // Letra escrita por el usuario
    var letraReal = letra[numero%23]; // Letra "real" del DNI calculada según "fórmula"
    var dniValido =true;
    if (letraUsuario!=letraReal) // Si no coincide letras es falso
        dniValido = false;
    return dniValido;
}