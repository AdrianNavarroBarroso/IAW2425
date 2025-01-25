<?php
	$red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);

    $color="rgb($red, $green, $blue)";

	?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja de Color Aleatorio</title>
    <style>
        .caja {
            width: 300px;
            height: 300px;
            background-color: <?php echo $color; ?>;
        }
    </style>
</head>
<body>
    <div class="caja"></div>
</body>
</html>