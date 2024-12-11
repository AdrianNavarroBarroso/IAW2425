<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

$profesores = $conn->query("SELECT id, nombre, apellidos FROM profesores");
$departamentos = $conn->query("SELECT id, nombre FROM departamentos");

$valores_formulario = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valores_formulario = $_POST;

    if (!isset($_POST['coste']) || $_POST['coste'] === '' || !is_numeric($_POST['coste'])) {
        $error = "El campo coste debe ser un número válido (0 para actividades gratuitas).";
    } else {
        try {
            $conn->autocommit(FALSE);
            $coste = (float)$_POST['coste'];

            $stmt = $conn->prepare("INSERT INTO actividades (
                titulo, tipo, departamento_id, profesor_responsable, trimestre,
                fecha_inicio, hora_inicio, fecha_fin, hora_fin, 
                organizador, ubicacion, coste, total_alumnos, objetivo
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param("ssiisssssssdis",
                $_POST['titulo'],
                $_POST['tipo'],
                $_POST['departamento'],
                $_POST['profesor'],
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
                throw new Exception("Error: " . $stmt->error);
            }

            $conn->commit();
            header("Location: actividades.php?success=1");
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $error = $e->getMessage();
        } finally {
            $conn->autocommit(TRUE);
            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Actividad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="h5 mb-0">Nueva Actividad</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Título:</label>
                            <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($valores_formulario['titulo'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label>Coste (€):</label>
                            <input type="number" step="0.01" name="coste" class="form-control" value="<?= htmlspecialchars($valores_formulario['coste'] ?? '0') ?>" required>
                            <small class="text-muted">0 para actividades gratuitas.</small>
                        </div>

                        <div class="col-md-6">
                            <label>Tipo:</label>
                            <select name="tipo" class="form-select" required>
                                <option value="extraescolar" <?= ($valores_formulario['tipo'] ?? '') === 'extraescolar' ? 'selected' : '' ?>>Extraescolar</option>
                                <option value="complementaria" <?= ($valores_formulario['tipo'] ?? '') === 'complementaria' ? 'selected' : '' ?>>Complementaria</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Departamento:</label>
                            <select name="departamento" class="form-select" required>
                                <?php while ($depto = $departamentos->fetch_assoc()): ?>
                                    <option value="<?= $depto['id'] ?>" <?= ($valores_formulario['departamento'] ?? '') == $depto['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($depto['nombre']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Profesor:</label>
                            <select name="profesor" class="form-select" required>
                                <?php while ($prof = $profesores->fetch_assoc()): ?>
                                    <option value="<?= $prof['id'] ?>" <?= ($valores_formulario['profesor'] ?? '') == $prof['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($prof['nombre'] . ' ' . $prof['apellidos']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Trimestre:</label>
                            <select name="trimestre" class="form-select" required>
                                <option value="1" <?= ($valores_formulario['trimestre'] ?? '') === '1' ? 'selected' : '' ?>>Primero</option>
                                <option value="2" <?= ($valores_formulario['trimestre'] ?? '') === '2' ? 'selected' : '' ?>>Segundo</option>
                                <option value="3" <?= ($valores_formulario['trimestre'] ?? '') === '3' ? 'selected' : '' ?>>Tercero</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Fecha Inicio:</label>
                            <input type="date" name="fecha_inicio" class="form-control" value="<?= htmlspecialchars($valores_formulario['fecha_inicio'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label>Hora Inicio:</label>
                            <input type="time" name="hora_inicio" class="form-control" value="<?= htmlspecialchars($valores_formulario['hora_inicio'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label>Fecha Fin:</label>
                            <input type="date" name="fecha_fin" class="form-control" value="<?= htmlspecialchars($valores_formulario['fecha_fin'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label>Hora Fin:</label>
                            <input type="time" name="hora_fin" class="form-control" value="<?= htmlspecialchars($valores_formulario['hora_fin'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label>Organizador:</label>
                            <input type="text" name="organizador" class="form-control" value="<?= htmlspecialchars($valores_formulario['organizador'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label>Ubicación:</label>
                            <input type="text" name="ubicacion" class="form-control" value="<?= htmlspecialchars($valores_formulario['ubicacion'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label>Total Alumnos:</label>
                            <input type="number" name="total_alumnos" class="form-control" value="<?= htmlspecialchars($valores_formulario['total_alumnos'] ?? '') ?>" required>
                        </div>

                        <div class="col-12">
                            <label>Objetivo:</label>
                            <textarea name="objetivo" class="form-control" rows="4" required><?= htmlspecialchars($valores_formulario['objetivo'] ?? '') ?></textarea>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Crear</button>
                        <a href="actividades.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>