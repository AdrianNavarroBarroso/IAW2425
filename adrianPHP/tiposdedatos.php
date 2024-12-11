<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos de Datos</title>
</head>
<body>
    <?php
        $a = 3;
        echo var_dump($a) . "<br>";

        $b = "Hola mundo";
        echo var_dump($b) . "<br>";

        $c = 3.5;
        echo var_dump($c) . "<br>";

        $d = ["rojo", "verde", "azul"];
        echo var_dump($d) . "<br>";

        $e = NULL;
        echo var_dump($e) . "<br>";

        echo var_dump($a, $b) . "<br>";
    ?> 
</body>
</html>