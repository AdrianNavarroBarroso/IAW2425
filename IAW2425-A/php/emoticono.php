<?php

    $emoji = "&#" . rand(128512, 128567) . ";"; //Variable que genera un código aleatorio dentro de los valores especificados que corresponde a la codificación de un emoji

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emoji aleatorio</title>
    <style>

        #emoji {
            font-size: 100px; /*Limito el tamaño del emoji*/
        }

    </style>
</head>
<body>
    
    <div id="emoji"><?php echo $emoji; ?></div> /*Imprimo la variable*/

</body>
</html>