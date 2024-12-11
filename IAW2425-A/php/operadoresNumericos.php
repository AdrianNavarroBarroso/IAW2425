<?php

    $x = 7; //Variable 1
    $y = 2.15; //Variable 2
    $z = 2; //Variable creada únicamente para la operación de "Resto" ya que con números decimales salta un error

    echo "Suma = "; 
    echo $x + $y; //Sumamos los variables
    echo "<br>";

    echo "Resta = ";
    echo $x - $y; //Restamos las variables
    echo "<br>";

    echo "Multiplicación = ";
    echo $x * $y; //Multiplicamos las variables
    echo "<br>";

    echo "División = ";
    echo $x / $y; //Dividimos las variables
    echo "<br>";

    echo "Resto = ";
    echo $x % $z; //Nos devuelve el resto de la división entre la variable $x y la variable $y (7/1 nos da de resto 1)
    echo "<br>";

    echo "Potencia = ";
    echo $x ** $y; //Multiplicamos el valor de $x por el número de veces del valor $y (7^2.15 = 65.608602332415)
    echo "<br>";

?>