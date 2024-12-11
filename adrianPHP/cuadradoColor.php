<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuadrado Color</title>
    <style>
        div{
            width: 300px;
            height: 300px;
        }
    </style>
</head>
<body>
    <?php
        $numero1 = rand(0, 255);
        $numero2 = rand(0, 255);
        $numero3 = rand(0, 255);

        echo "<div style='background-color: rgb(". $numero1. "," .$numero2. "," .$numero3  .");'> </div>";
    ?>
</body>
</html>