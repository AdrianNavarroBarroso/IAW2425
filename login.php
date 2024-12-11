<?php
session_start();

// Redirigir si ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    header("Location: actividades/index.php");
    exit();
}

$titulo_pagina = "Iniciar Sesión";
require_once 'includes/conexion.php';
include 'templates/header.php';

// Procesar formulario
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $password = $_POST['password'];

    $sql = "SELECT id, password, usuario FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nombre'] = $user['usuario'];
            header("Location: actividades/index.php");
            exit();
        }
    }
    
    $error = "Credenciales incorrectas";
    $stmt->close();
    $conn->close();
}
?>

<main class="contenido-principal">
    <div class="contenedor-formulario">
        <div class="formulario-login">
            <h2 class="titulo-formulario">Acceso a la Plataforma</h2>
            
            <?php if ($error): ?>
                <div class="mensaje-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="formulario">
                <div class="grupo-formulario">
                    <label for="usuario">Usuario:</label>
                    <input type="text" 
                           id="usuario" 
                           name="usuario" 
                           required
                           maxlength="30"
                           class="campo-formulario">
                </div>
                
                <div class="grupo-formulario">
                    <label for="password">Contraseña:</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           minlength="8"
                           class="campo-formulario">
                </div>
                
                <button type="submit" class="boton-primario">Ingresar</button>
                
                <div class="enlace-registro">
                    ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'templates/footer.php'; ?>