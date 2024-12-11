<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: actividades/index.php");
    exit();
}

$titulo_pagina = "Registro de Usuario";
include 'templates/header.php';
include 'includes/conexion.php';

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Validaciones básicas
    $errores = [];
    
    if (empty($nombre) || strlen($nombre) > 20) {
        $errores[] = "Nombre inválido (máx 20 caracteres)";
    }
    
    if (empty($apellido) || strlen($apellido) > 20) {
        $errores[] = "Apellido inválido (máx 20 caracteres)";
    }
    
    if (empty($usuario) || strlen($usuario) > 30) {
        $errores[] = "Usuario inválido (máx 30 caracteres)";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 50) {
        $errores[] = "Email inválido";
    }
    
    if (strlen($password) < 8) {
        $errores[] = "La contraseña debe tener mínimo 8 caracteres";
    }

    if (empty($errores)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nombre, apellido, usuario, email, password) 
                VALUES ('$nombre', '$apellido', '$usuario', '$email', '$hashed_password')";
        
        if ($conn->query($sql)) {
            $exito = "¡Registro exitoso! Ya puedes iniciar sesión";
        } else {
            $error = "Error: " . $conn->error;
        }
    } else {
        $error = implode("<br>", $errores);
    }
    $conn->close();
}
?>

<div class="contenedor-registro">
    <div class="login-box">
        <h2>Registro de Nuevo Usuario</h2>
        
        <?php if ($error): ?>
            <div class="error-msg"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($exito): ?>
            <div class="success-msg">
                <?= $exito ?><br>
                <a href="login.php">Ir al Login</a>
            </div>
        <?php else: ?>
            <form method="POST">
                <input class="input-field" type="text" name="nombre" 
                       placeholder="Nombre" required maxlength="20">
                
                <input class="input-field" type="text" name="apellido" 
                       placeholder="Apellido" required maxlength="20">
                
                <input class="input-field" type="text" name="usuario" 
                       placeholder="Usuario" required maxlength="30">
                
                <input class="input-field" type="email" name="email" 
                       placeholder="Email institucional" required maxlength="50">
                
                <input class="input-field" type="password" name="password" 
                       placeholder="Contraseña" required minlength="8">
                
                <button class="btn btn-registro" type="submit">Registrarse</button>
            </form>
            
            <div class="enlace-login">
                ¿Ya tienes cuenta? <a href="login.php">Inicia Sesión</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'templates/footer.php'; ?>