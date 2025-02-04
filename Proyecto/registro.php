<?php
session_start();
session_name('myapp_session');
require 'includes/conexion.php';

$departamentos = [
    'matematicas' => 'Matemáticas',
    'ciencias' => 'Ciencias Naturales', 
    'informatica' => 'Informática',
    'lengua' => 'Lengua y Literatura',
    'historia' => 'Historia'
];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; 
    $departamento = $_POST['departamento'];

    // Validación modificada: apellidos no es obligatorio
    if (empty($nombre) || empty($email) || empty($password)) {
        $error = "Nombre, email y contraseña son obligatorios";
    } elseif ($password !== $confirm_password) { 
        $error = "Las contraseñas no coinciden";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Formato de email inválido";
    } elseif (!preg_match("/@iesamachado\.org$/i", $email)) {
        $error = "Solo se permiten correos del dominio @iesamachado.org";
    } elseif (!array_key_exists($departamento, $departamentos)) {
        $error = "Departamento no válido";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id FROM profesores WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            
            if ($stmt->get_result()->num_rows > 0) {
                $error = "Este correo ya está registrado";
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $conn->prepare("INSERT INTO profesores 
                    (nombre, apellidos, email, password, departamento) 
                    VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nombre, $apellidos, $email, $password_hash, $departamento);
                
                if ($stmt->execute()) {
                    header("Location: login.php?registro=exito");
                    exit();
                } else {
                    $error = "Error al registrar: " . $stmt->error;
                }
            }
        } catch (Exception $e) {
            $error = "Error en el sistema: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 500px; margin-top: 50px; }
        .card { border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="card p-4">
            <h2 class="text-center mb-4">Registro de Profesor</h2>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required 
                               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control"
                               value="<?= htmlspecialchars($_POST['apellidos'] ?? '') ?>">
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Correo institucional</label>
                        <input type="email" name="email" class="form-control" required 
                               placeholder="usuario@iesamachado.org" 
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required 
                               minlength="8">
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="confirm_password" class="form-control" required 
                               minlength="8">
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Departamento</label>
                        <select name="departamento" class="form-select" required>
                            <?php foreach ($departamentos as $clave => $valor): ?>
                                <option value="<?= $clave ?>" 
                                    <?= ($_POST['departamento'] ?? '') === $clave ? 'selected' : '' ?>>
                                    <?= $valor ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                    </div>
                    
                    <div class="text-center">
                        <a href="login.php" class="text-decoration-none">¿Ya tienes cuenta? Inicia sesión</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>