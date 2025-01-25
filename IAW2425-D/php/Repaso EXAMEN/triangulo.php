<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Triángulos</title>
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
    <h1>Generador de Triángulos de Asteriscos</h1>
    <form action="triangulo.php" method="post">
        <label for="altura">Introduce la altura del triángulo:</label>
        <input type="number" id="altura" name="altura" min="1" required>
        <button type="submit">Generar</button>
    </form>
    <?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $altura = intval($_POST["altura"]);

    if ($altura < 1) {
        echo "<p>La altura debe ser mayor o igual a 1.</p>";
        echo "<a href='index.php'>Volver</a>";
        exit;
    }

    echo "<h1>Triángulo de altura $altura</h1>";
    echo "<pre>";
    
    // Generar el triángulo
    for ($i = 1; $i <= $altura; $i++) {
        echo str_repeat("*", $i) . "\n"; // Cada línea tiene 'i' asteriscos
    }
    
    echo "</pre>";
    echo "<a href='index.php'>Volver</a>";
}
?>

<?php
//if ($_SERVER["REQUEST_METHOD"] === "POST") {
//    $altura = intval($_POST["altura"]);

//    if ($altura < 2) {
//        echo "<p>La altura debe ser mayor o igual a 2 para crear un triángulo con bordes.</p>";
//        echo "<a href='index.php'>Volver</a>";
//        exit;
//    }

//    echo "<h1>Triángulo de altura $altura con bordes</h1>";
//    echo "<pre>";

    // Generar el triángulo con bordes
//    for ($i = 1; $i <= $altura; $i++) {
//        if ($i === 1) {
//            // Primera línea: un solo asterisco
//            echo "*\n";
//        } elseif ($i === $altura) {
//            // Última línea: llena de asteriscos
//            echo str_repeat("*", $i) . "\n";
//        } else {
//            // Líneas intermedias: asterisco al principio y al final, espacios en el medio
//            echo "*" . str_repeat(" ", $i - 2) . "*\n";
//        }
//    }

//    echo "</pre>";
//    echo "<a href='index.php'>Volver</a>";
//}
?>


</body>
</html>
