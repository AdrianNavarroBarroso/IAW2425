<?php

    $fotos = array('/Imagenes/betis.jpg', '/Imagenes/youtube.png','/Imagenes/instagram.jpeg','/Imagenes/Twitter.jpg','/Imagenes/Twitter.png');
	$random = array_rand($fotos, 1);

	?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja de Color Aleatorio</title>
</head>
<body>
<?php echo "<img src='" . $fotos[$random] . "' width='500px' height='500px' />"; ?>
</body>
</html>