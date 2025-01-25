<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dias pa la feria</title>
    </head>
    <body> 
 <?php

   $diccionario = array(
   "Hola"=>"Hello",
   "Adios"=>"Bye",
   "mesa"=>"table");

   echo "<h1>Diccionario Español - Ingles </h1>";
   echo "<ul>";
    foreach ($diccionario as $palabraEspañol => $palabraIngles){
        echo "<li>$palabraEspañol se traduce como $palabraIngles</li>";
    }
    echo "</ul>";
?>
</body>
</html>