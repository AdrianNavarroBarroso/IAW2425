<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dias pa la feria</title>
    </head>
    <body> 
 <?php

    $numero = 1;
    $total = 10;
    echo "<table border='1'>";
    while ($numero <= $total){
            echo "<tr><td>" . $numero . "</tr></td>\n";
            $numero += 1;
    }
    echo "</table>";

?>
</body>
</html>