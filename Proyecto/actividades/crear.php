<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

$departamentos = [
    'matematicas' => 'Matemáticas',
    'ciencias' => 'Ciencias Naturales',
    'informatica' => 'Informática',
    'lengua' => 'Lengua y Literatura',
    'historia' => 'Historia'
];

$profesores = $conn->query("SELECT id, nombre, apellidos FROM profesores");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campos_requeridos = [
        'titulo', 'tipo', 'departamento', 'profesor', 'trimestre',
        'fecha_inicio', 'hora_inicio', 'fecha_fin', 'hora_fin',
        'organizador', 'ubicacion', 'coste', 'total_alumnos', 'objetivo'
    ];

    // Validación modificada para permitir 0
    foreach ($campos_requeridos as $campo) {
        if ($campo === 'coste' || $campo === 'total_alumnos') {
            if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
                die("Error: El campo <strong>$campo</strong> es obligatorio.");
            }
        } else {
            if (empty($_POST[$campo])) {
                die("Error: El campo <strong>$campo</strong> es obligatorio.");
            }
        }
    }

    // Validación numérica
    if (!is_numeric($_POST['coste']) || $_POST['coste'] < 0) {
        die("Error: El coste debe ser un número ≥ 0.");
    }

    if (!is_numeric($_POST['total_alumnos']) || $_POST['total_alumnos'] < 0) {
        die("Error: El total de alumnos debe ser un número ≥ 0.");
    }

    if (!array_key_exists($_POST['departamento'], $departamentos)) {
        die("Error: Departamento no válido.");
    }

    try {
        $conn->autocommit(FALSE);
        $coste = (float)$_POST['coste'];

        $stmt = $conn->prepare("
            INSERT INTO actividades (
                titulo, tipo, profesor_responsable, departamento, trimestre,
                fecha_inicio, hora_inicio, fecha_fin, hora_fin,
                organizador, ubicacion, coste, total_alumnos, objetivo
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssissssssssdss",
            $_POST['titulo'],
            $_POST['tipo'],
            $_POST['profesor'],
            $_POST['departamento'],
            $_POST['trimestre'],
            $_POST['fecha_inicio'],
            $_POST['hora_inicio'],
            $_POST['fecha_fin'],
            $_POST['hora_fin'],
            $_POST['organizador'],
            $_POST['ubicacion'],
            $coste,
            $_POST['total_alumnos'],
            $_POST['objetivo']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear actividad: " . $stmt->error);
        }

        $conn->commit();
        header("Location: actividades.php?success=1");
    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    } finally {
        $conn->close();
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Actividad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .required::after { content: "*"; color: #dc3545; }
        .seccion { border-left: 3px solid #0d6efd; padding-left: 1rem; margin-bottom: 2rem; }
        h5 { color: #0d6efd; margin-bottom: 1rem; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="h5 mb-0">Nueva Actividad</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <!-- Sección 1: Información Básica -->
                    <div class="seccion">
                        <h5>Información Básica</h5>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label required">Título</label>
                                <input type="text" name="titulo" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Coste (€)</label>
                                <input type="number" step="0.01" name="coste" class="form-control" value="0" min="0" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2: Clasificación -->
                    <div class="seccion">
                        <h5>Clasificación</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label required">Tipo</label>
                                <select name="tipo" class="form-select" required>
                                    <option value="extraescolar">Extraescolar</option>
                                    <option value="complementaria">Complementaria</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Departamento</label>
                                <select name="departamento" class="form-select" required>
                                    <option value="">Seleccione un departamento</option>
                                    <?php foreach ($departamentos as $clave => $nombre): ?>
                                        <option value="<?= $clave ?>"><?= htmlspecialchars($nombre) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Profesor</label>
                                <select name="profesor" class="form-select" required>
                                    <?php while ($prof = $profesores->fetch_assoc()): ?>
                                        <option value="<?= $prof['id'] ?>">
                                            <?= htmlspecialchars($prof['nombre'] . ' ' . $prof['apellidos']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 3: Calendario -->
                    <div class="seccion">
                        <h5>Calendario</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label required">Fecha inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Hora inicio</label>
                                <input type="time" name="hora_inicio" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Fecha fin</label>
                                <input type="date" name="fecha_fin" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Hora fin</label>
                                <input type="time" name="hora_fin" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 4: Detalles Adicionales -->
                    <div class="seccion">
                        <h5>Detalles Adicionales</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label required">Trimestre</label>
                                <select name="trimestre" class="form-select" required>
                                    <option value="1">Primero</option>
                                    <option value="2">Segundo</option>
                                    <option value="3">Tercero</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label required">Organizador</label>
                                <input type="text" name="organizador" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Ubicación</label>
                                <input type="text" name="ubicacion" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 5: Participación -->
                    <div class="seccion">
                        <h5>Participación</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">Total de alumnos</label>
                                <input type="number" name="total_alumnos" class="form-control" min="0" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label required">Objetivo</label>
                                <textarea name="objetivo" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="actividades.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Crear actividad</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>