<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operadores Cadena</title>
</head>
<body>
    <?php
        $cadena1 = "Esto es un";
        $cadena2 = " mensaje de prueba";
        $mensaje = $cadena1 . $cadena2;

        print "<h1>$mensaje</h1>";

        $mensaje1 = $cadena1;
        $mensaje1 .= $cadena2;
        
        print "<h1>$mensaje1</h1>";

    ?>
</body>
</html>