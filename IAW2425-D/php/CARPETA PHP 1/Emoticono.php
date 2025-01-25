<?php

    $caracter = '&#';
	$emoji = rand(128512, 128586);

    $emojifinal = $caracter . $emoji;

	?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja de Color Aleatorio</title>
</head>
<body>
<?php echo  "<p> $emojifinal; </p>" ?>
</body>
</html>