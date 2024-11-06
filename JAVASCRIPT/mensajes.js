let mensajesArray = [];

function agregarMensaje() {
    let mensaje = document.getElementById("mensajeNuevo").value;

    if (mensaje.trim() !== "") {
        mensajesArray.push(mensaje);

        document.getElementById("mensajeNuevo").value = "";

        mostrarMensajes();
    } else {
        alert("Por favor, introduce un mensaje.");
    }
}

function mostrarMensajes() {
    let divMensajes = document.getElementById('verMensajes');

    divMensajes.innerHTML = "";

    for (let i = 0; i < mensajesArray.length; i++) {
        divMensajes.innerHTML += `<p>${mensajesArray[i]} <button onclick='borrarMensaje(${i});'>Borrar</button></p>`;
    }
    
}

function ordenar(){
    mensajesArray.sort();
    mostrarMensajes();
}

function borrarMensaje(elemento){
    let pos = mensajesArray.indexOf(elemento);
    mensajesArray.splice(pos, 1);
    mostrarMensajes();
}