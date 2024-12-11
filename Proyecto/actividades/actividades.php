<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php"); // Ruta corregida
    exit();
}

include '../includes/conexion.php';

$actividades = [];
$stmt = $conn->prepare("SELECT * FROM actividades");
$stmt->execute();
$result = $stmt->get_result();

while ($actividad = $result->fetch_assoc()) {
    $stmt_prof = $conn->prepare("SELECT nombre, apellidos FROM profesores WHERE id = ?");
    $stmt_prof->bind_param("i", $actividad['profesor_responsable']);
    $stmt_prof->execute();
    $profesor = $stmt_prof->get_result()->fetch_assoc();
    
    $actividad['profesor_nombre'] = $profesor['nombre'] . ' ' . $profesor['apellidos'];
    $actividades[] = $actividad;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Actividades - IES Antonio Machado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Actividades Registradas</h1>
            <div>
                <a href="crear.php" class="btn btn-success">Nueva Actividad</a>
                <a href="../logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th>Departamento</th>
                                <th>Profesor</th>
                                <th>Fecha Inicio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($actividades as $act): ?>
                            <tr>
                                <td><?= htmlspecialchars($act['titulo']) ?></td>
                                <td><?= ucfirst($act['tipo']) ?></td>
                                <td><?= htmlspecialchars($act['departamento']) ?></td>
                                <td><?= htmlspecialchars($act['profesor_nombre']) ?></td>
                                <td><?= date('d/m/Y', strtotime($act['fecha_inicio'])) ?></td>
                                <td>
                                    <a href="editar.php?id=<?= $act['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="eliminar.php?id=<?= $act['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Eliminar esta actividad?')">Eliminar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>