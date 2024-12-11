<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Rombos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        pre {
            font-family: monospace;
            line-height: 1.2;
        }
    </style>
</head>
<body>
    <h1>Generador de Rombos</h1>
    <form action="rombo.php" method="post">
        <label for="altura">Introduce la altura máxima del rombo:</label>
        <input type="number" id="altura" name="altura" min="1" required>
        <button type="submit">Generar</button>
    </form>
    <?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $altura = intval($_POST["altura"]);

    if ($altura < 1) {
        echo "<p>La altura debe ser mayor o igual a 1.</p>";
        exit;
    }

    echo "<h1>Rombo de altura $altura</h1>";
    echo "<pre>";
    // Parte superior del rombo
    for ($i = 1; $i <= $altura; $i++) {
        echo str_repeat(" ", $altura - $i); // Espacios iniciales
        echo str_repeat("*", 2 * $i - 1);  // Asteriscos
        echo "\n";
    }

    // Parte inferior del rombo
    for ($i = $altura - 1; $i >= 1; $i--) {
        echo str_repeat(" ", $altura - $i); // Espacios iniciales
        echo str_repeat("*", 2 * $i - 1);  // Asteriscos
        echo "\n";
    }
    echo "</pre>";

    echo "<a href='index.php'>Volver</a>";
}
?>

</body>
</html>
