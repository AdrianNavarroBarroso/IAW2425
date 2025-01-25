<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Cuadrados</title>
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
    <h1>Generador de Cuadrados</h1>
    <form action="cuadrado.php" method="post">
        <label for="altura">Introduce la altura del cuadrado:</label>
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

    echo "<h1>Cuadrado de altura $altura</h1>";
    echo "<pre>";
    
    // Generar el cuadrado
    for ($i = 0; $i < $altura; $i++) {
        echo str_repeat("*", $altura) . "\n"; // Cada línea tiene 'altura' asteriscos
    }
    
    echo "</pre>";
    echo "<a href='index.php'>Volver</a>";
}
?>

 <?php
// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//    $altura = intval($_POST["altura"]);

//    if ($altura < 2) {
//        echo "<p>La altura debe ser mayor o igual a 2 para crear un cuadrado con bordes.</p>";
//        echo "<a href='index.php'>Volver</a>";
//        exit;
//    }

//    echo "<h1>Cuadrado de altura $altura con bordes</h1>";
//    echo "<pre>";
    
    // Generar el cuadrado con bordes
//    for ($i = 0; $i < $altura; $i++) {
//        if ($i === 0 || $i === $altura - 1) {
            // Primera y última línea: todo lleno de asteriscos
//            echo str_repeat("*", $altura) . "\n";
//        } else {
            // Líneas intermedias: un asterisco al inicio y otro al final
//            echo "*" . str_repeat(" ", $altura - 2) . "*\n";
//        }
//    }
//    
//    echo "</pre>";
//    echo "<a href='index.php'>Volver</a>";
//}
?>

</body>
</html>
