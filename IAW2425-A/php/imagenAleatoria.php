<?php

    $imagenes = [ //Creo un array con imágenes que he descargado y su ruta
        "southPark/1.jpg",
        "southPark/2.jpg",
        "southPark/3.jpg",
        "southPark/4.jpg",
        "southPark/5.jpg",
    ];

    $random = $imagenes[rand(0,4)]; //Creo una variable que elige una posición aleatoria del array creado

    echo "<img src=" . $random . " height="."500px width="."500px>" //Imprimo el resultado (concateno el resto de condiciones de la imagen ya que si lo hago con comillas simples no hace la misma función)

?>