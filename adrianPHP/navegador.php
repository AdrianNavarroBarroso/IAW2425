<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navegador</title>
</head>
<body>
    <?php
        echo "<P>Estas usando el navegador:<br>" . $_SERVER['HTTP_USER_AGENT'] . "<br><br> Con la IP:<br>" . $_SERVER['REMOTE_ADDR'] ;
    ?>
</body>
</html>