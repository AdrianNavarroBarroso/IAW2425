<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'includes/conexion.php';

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar y capturar datos
    $nombre = $conn->real_escape_string(trim($_POST['nombre']));
    $apellidos = $conn->real_escape_string(trim($_POST['apellidos']));
    $usuario = $conn->real_escape_string(trim($_POST['usuario']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validaciones
    $campos_requeridos = [
        'nombre' => 'Nombre',
        'apellidos' => 'Apellidos',
        'usuario' => 'Nombre de usuario',
        'email' => 'Correo electrónico',
        'password' => 'Contraseña'
    ];

    foreach ($campos_requeridos as $campo => $nombre_campo) {
        if (empty($_POST[$campo])) {
            $error = "El campo <strong>$nombre_campo</strong> es obligatorio";
            break;
        }
    }

    if (!$error) {
        if ($password !== $confirm_password) {
            $error = "Las contraseñas no coinciden";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Formato de email inválido";
        } elseif (strlen($password) < 8) {
            $error = "La contraseña debe tener al menos 8 caracteres";
        } else {
            // Verificar duplicados
            $stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? OR email = ?");
            $stmt_check->bind_param("ss", $usuario, $email);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if ($result->num_rows > 0) {
                $error = "El usuario o email ya están registrados";
            } else {
                // Registrar usuario
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO usuarios 
                    (nombre, apellidos, usuario, email, password) 
                    VALUES (?, ?, ?, ?, ?)");
                
                $stmt->bind_param("sssss", $nombre, $apellidos, $usuario, $email, $password_hash);

                if ($stmt->execute()) {
                    $exito = "Registro exitoso. Ahora puedes iniciar sesión";
                    $_POST = array(); // Limpiar formulario
                } else {
                    $error = "Error al registrar: " . $conn->error;
                }
                $stmt->close();
            }
            $stmt_check->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .grupo-nombre {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h3 class="text-center mb-0">Registro de Usuario</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($exito)): ?>
                            <div class="alert alert-success"><?= $exito ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="grupo-nombre mb-3">
                                <div>
                                    <label class="form-label">Nombre:</label>
                                    <input type="text" name="nombre" class="form-control" 
                                        value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" 
                                        required
                                        pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+"
                                        title="Solo letras y espacios">
                                </div>
                                <div>
                                    <label class="form-label">Apellidos:</label>
                                    <input type="text" name="apellidos" class="form-control" 
                                        value="<?= htmlspecialchars($_POST['apellidos'] ?? '') ?>" 
                                        required
                                        pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+"
                                        title="Solo letras y espacios">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre de usuario:</label>
                                    <input type="text" name="usuario" class="form-control" 
                                        value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>" 
                                        required
                                        minlength="4"
                                        pattern="[A-Za-z0-9_]+"
                                        title="Letras, números y guiones bajos">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Correo electrónico:</label>
                                    <input type="email" name="email" class="form-control" 
                                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                                        required>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Contraseña:</label>
                                    <input type="password" name="password" class="form-control" 
                                        required
                                        minlength="8"
                                        pattern="^(?=.*[A-Za-z])(?=.*\d).{8,}$"
                                        title="Mínimo 8 caracteres con al menos una letra y un número">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirmar contraseña:</label>
                                    <input type="password" name="confirm_password" class="form-control" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">Registrarse</button>
                                <a href="login.php" class="btn btn-outline-success">
                                    ¿Ya tienes cuenta? Inicia sesión
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>