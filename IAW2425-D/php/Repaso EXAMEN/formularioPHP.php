<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Formulario de Registro</h1>
    <form action="registro.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>
        <br>
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" pattern="\d{8}[A-Z]" title="Debe contener 8 números y una letra mayúscula." required>
        <br>
        <label for="email">Correo electrónico (opcional):</label>
        <input type="email" id="email" name="email">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" pattern=".{8,}" title="Debe tener al menos 8 caracteres." required>
        <br>
        <label for="password2">Confirmar Contraseña:</label>
        <input type="password" id="password2" name="password2" pattern=".{8,}" title="Debe tener al menos 8 caracteres." required>
        <br>
        <label for="politicas">Aceptar políticas de privacidad:</label>
        <input type="checkbox" id="politicas" name="politicas" required>
        <br>
        <button type="submit">Registrar</button>
    </form>
    <?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validación del nombre
    if (empty($_POST["nombre"])) {
        $error_nombre = "El nombre es obligatorio.";
    } else {
        $nombre = htmlspecialchars($_POST["nombre"]);
    }

    // Validación de los apellidos
    if (empty($_POST["apellidos"])) {
        $error_apellidos = "Los apellidos son obligatorios.";
    } else {
        $apellidos = htmlspecialchars($_POST["apellidos"]);
    }

    // Validación del DNI
    $dni = $_POST["dni"];
    if (!preg_match("/^\d{8}[A-Z]$/", $dni)) {
        $error_dni = "DNI inválido. Debe contener 8 números y una letra mayúscula.";
    }

    // Validación del correo electrónico (opcional)
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    // Validación de las contraseñas
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    if ($password !== $password2) {
        $error_password = "Las contraseñas no coinciden.";
    }

    // Validación del consentimiento de políticas
    if (!isset($_POST["politicas"])) {
        $error_politicas = "Debes aceptar las políticas de privacidad.";
    }

    // Mostrar mensajes de error si existen
    if (isset($error_nombre) || isset($error_apellidos) || isset($error_dni) || isset($error_password) || isset($error_politicas)) {
        echo isset($error_nombre) ? "<p class='error'>$error_nombre</p>" : "";
        echo isset($error_apellidos) ? "<p class='error'>$error_apellidos</p>" : "";
        echo isset($error_dni) ? "<p class='error'>$error_dni</p>" : "";
        echo isset($error_password) ? "<p class='error'>$error_password</p>" : "";
        echo isset($error_politicas) ? "<p class='error'>$error_politicas</p>" : "";
        echo "<a href='index.php'>Volver</a>";
        exit;
    }

    // Procesar el formulario si no hay errores
    echo "<h1>Usuario Registrado</h1>";
    echo "<p>Nombre: $nombre</p>";
    echo "<p>Apellidos: $apellidos</p>";
    echo "<p>DNI: $dni</p>";
    echo "<p>Correo electrónico: $email</p>";
    echo "<a href='index.php'>Volver</a>";
}
?>

</body>
</html>
