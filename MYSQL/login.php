<?php
// Conexión a la base de datos
$servername = "sql107.thsite.top";
$username = "thsi_38097545";
$password = "";
$database = "thsi_38097545_proyecto";
$enlace = mysqli_connect($servername, $username, $password, $database);

// Verificar conexión
if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Procesar formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que los campos no estén vacíos
    if (empty($_POST['usuario']) || empty($_POST['password'])) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Saneamiento de las entradas
    $usuario = htmlspecialchars(trim($_POST['usuario']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Consultar el usuario por usuario
    $query = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultado = mysqli_query($enlace, $query);

    if (mysqli_num_rows($resultado) === 1) {
        // Recuperar los datos del usuario
        $usuario = mysqli_fetch_assoc($resultado);

        // Usar el hash almacenado como el salt para cifrar la contraseña ingresada
        $password_hashed = crypt($password, $usuario['password']);

        // Verificar la contraseña (comparación estricta)
        //if ($usuario['password'] === $password){ // CASO 1 (GRAN ERROR)
        if (hash_equals($usuario['password'], $password_hashed)) {
            echo "Inicio de sesión exitoso. Bienvenido, " . $usuario['usuario'] . "!";
        } else {
            echo "Error: Contraseña incorrecta." . $password_hashed . " es diferente de " . $usuario['password'];
        }
    } else {
        echo "Error: Usuario no encontrado.";
    }
}

mysqli_close($enlace);
?>

<!-- Formulario de inicio de sesión -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>