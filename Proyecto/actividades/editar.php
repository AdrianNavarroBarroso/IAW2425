<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !$_SESSION['es_admin']) {
   header("Location: ../login.php");
   exit();
}
include '../includes/conexion.php';


// Obtener ID de la actividad a editar
$id_actividad = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_actividad == 0) {
   die("ID de actividad no válido");
}


// Obtener datos de la actividad existente
$actividad = [];
$stmt = $conn->prepare("SELECT * FROM actividades WHERE id = ?");
$stmt->bind_param("i", $id_actividad);
$stmt->execute();
$result = $stmt->get_result();
$actividad = $result->fetch_assoc();
if (!$actividad) {
   die("Actividad no encontrada");
}


$departamentos = [
   'matemáticas' => 'Matemáticas',
   'ciencias' => 'Ciencias Naturales',
   'informatica' => 'Informática',
   'lengua' => 'Lengua y Literatura',
   'historia' => 'Historia'
];


$profesores = $conn->query("SELECT id, nombre, apellidos FROM profesores");
$error = '';


// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $valores_formulario = $_POST;
   // Validación (similar a crear.php)
   $campos_requeridos = [
       'titulo', 'tipo', 'departamento', 'profesor', 'trimestre',
       'fecha_inicio', 'hora_inicio', 'fecha_fin', 'hora_fin',
       'organizador', 'ubicacion', 'coste', 'total_alumnos', 'objetivo'
   ];
   foreach ($campos_requeridos as $campo) {
       if (empty(trim($_POST[$campo]))) {
           $error = "El campo <strong>$campo</strong> es obligatorio.";
           break;
       }
   }
   if (!$error && (!is_numeric(trim($_POST['coste'])) || trim($_POST['coste']) < 0)) {
       $error = "El coste debe ser un número >= 0.";
   }
   if (!$error && (!is_numeric(trim($_POST['total_alumnos'])) || trim($_POST['total_alumnos']) < 0)) {
       $error = "El total de alumnos debe ser un número >= 0.";
   }
   if (!$error && !array_key_exists(trim($_POST['departamento']), $departamentos)) {
       $error = "Departamento no válido.";
   }
   if (!$error) {
   try {
       $conn->autocommit(FALSE);
       $coste = (float)trim($_POST['coste']);
      
       // Línea corregida:
       $aprobada = $_SESSION['es_admin'] ? (int)trim($_POST['aprobada']) : $actividad['aprobada'];
      
       // Query UPDATE
       $stmt = $conn->prepare("UPDATE actividades SET titulo = ?, tipo = ?, profesor_responsable = ?, departamento = ?, trimestre = ?, fecha_inicio = ?, hora_inicio = ?, fecha_fin = ?, hora_fin = ?, organizador = ?, ubicacion = ?, coste = ?, total_alumnos = ?, objetivo = ?, aprobada = ? WHERE id = ?");
      
           $stmt->bind_param("sssisssssssddsii",
               trim($_POST['titulo']),
               trim($_POST['tipo']),
               trim($_POST['profesor']),
               trim($_POST['departamento']),
               trim($_POST['trimestre']),
               trim($_POST['fecha_inicio']),
               trim($_POST['hora_inicio']),
               trim($_POST['fecha_fin']),
               trim($_POST['hora_fin']),
               trim($_POST['organizador']),
               trim($_POST['ubicacion']),
               $coste,
               trim($_POST['total_alumnos']),
               trim($_POST['objetivo']),
               $aprobada,
               $id_actividad
           );
           if (!$stmt->execute()) {
               throw new Exception("Error al actualizar: " . $stmt->error);
           }
           $conn->commit();
           header("Location: actividades.php?success=1");
           exit();
       } catch (Exception $e) {
           $conn->rollback();
           $error = $e->getMessage();
       }
   }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <title>Editar Actividad</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
               <h2 class="h5 mb-0">Editar Actividad</h2>
           </div>
           <div class="card-body">
               <?php if ($error): ?>
                   <div class="alert alert-danger"><?php echo $error; ?></div>
               <?php endif; ?>
               <form method="POST">
                   <!-- Sección 1: Información Básica -->
                   <div class="seccion">
                       <h5>Información Básica</h5>
                       <div class="row g-3">
                           <div class="col-md-8">
                               <label class="form-label required">Título</label>
                               <input type="text" name="titulo" class="form-control" value="<?php echo htmlspecialchars($actividad['titulo']); ?>" required>
                           </div>
                           <div class="col-md-4">
                               <label class="form-label required">Coste (€)</label>
                               <input type="number" step="0.01" name="coste" class="form-control" value="<?php echo htmlspecialchars($actividad['coste']); ?>" min="0" required>
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
                                   <option value="extraescolar" <?php echo $actividad['tipo'] === 'extraescolar' ? 'selected' : ''; ?>>Extraescolar</option>
                                   <option value="complementaria" <?php echo $actividad['tipo'] === 'complementaria' ? 'selected' : ''; ?>>Complementaria</option>
                               </select>
                           </div>
                           <div class="col-md-4">
                               <label class="form-label required">Departamento</label>
                               <select name="departamento" class="form-select" required>
                                   <?php foreach ($departamentos as $clave => $nombre): ?>
                                       <option value="<?php echo $clave; ?>" <?php echo $actividad['departamento'] === $clave ? 'selected' : ''; ?>><?php echo htmlspecialchars($nombre); ?></option>
                                   <?php endforeach; ?>
                               </select>
                           </div>
                           <div class="col-md-4">
                               <label class="form-label required">Profesor</label>
                               <select name="profesor" class="form-select" required>
                                   <?php while ($prof = $profesores->fetch_assoc()): ?>
                                       <option value="<?php echo $prof['id']; ?>" <?php echo $actividad['profesor_responsable'] == $prof['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($prof['nombre'] . ' ' . $prof['apellidos']); ?></option>
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
                               <input type="date" name="fecha_inicio" class="form-control" value="<?php echo htmlspecialchars($actividad['fecha_inicio']); ?>" required>
                           </div>
                           <div class="col-md-3">
                               <label class="form-label required">Hora inicio</label>
                               <input type="time" name="hora_inicio" class="form-control" value="<?php echo htmlspecialchars($actividad['hora_inicio']); ?>" required>
                           </div>
                           <div class="col-md-3">
                               <label class="form-label required">Fecha fin</label>
                               <input type="date" name="fecha_fin" class="form-control" value="<?php echo htmlspecialchars($actividad['fecha_fin']); ?>" required>
                           </div>
                           <div class="col-md-3">
                               <label class="form-label required">Hora fin</label>
                               <input type="time" name="hora_fin" class="form-control" value="<?php echo htmlspecialchars($actividad['hora_fin']); ?>" required>
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
                                   <option value="1" <?php echo $actividad['trimestre'] == 1 ? 'selected' : ''; ?>>Primero</option>
                                   <option value="2" <?php echo $actividad['trimestre'] == 2 ? 'selected' : ''; ?>>Segundo</option>
                                   <option value="3" <?php echo $actividad['trimestre'] == 3 ? 'selected' : ''; ?>>Tercero</option>
                               </select>
                           </div>
                           <div class="col-md-5">
                               <label class="form-label required">Organizador</label>
                               <input type="text" name="organizador" class="form-control" value="<?php echo htmlspecialchars($actividad['organizador']); ?>" required>
                           </div>
                           <div class="col-md-4">
                               <label class="form-label required">Ubicación</label>
                               <input type="text" name="ubicacion" class="form-control" value="<?php echo htmlspecialchars($actividad['ubicacion']); ?>" required>
                           </div>
                       </div>
                   </div>
                   <!-- Sección 5: Participación -->
                   <div class="seccion">
                       <h5>Participación</h5>
                       <div class="row g-3">
                           <div class="col-md-6">
                               <label class="form-label required">Total de alumnos</label>
                               <input type="number" name="total_alumnos" class="form-control" value="<?php echo htmlspecialchars($actividad['total_alumnos']); ?>" min="0" required>
                           </div>
                           <div class="col-12">
                               <label class="form-label required">Objetivo</label>
                               <textarea name="objetivo" class="form-control" rows="4" required><?php echo htmlspecialchars($actividad['objetivo']); ?></textarea>
                           </div>
                       </div>
                   </div>
                   <!-- Sección 6: Aprobación (solo administradores) -->
                   <?php if ($_SESSION['es_admin']): ?>
                       <div class="seccion">
                           <h5>Aprobación</h5>
                           <div class="row g-3">
                               <div class="col-md-6">
                                   <label class="form-label required">Aprobada</label>
                                   <select name="aprobada" class="form-select" required>
                                       <option value="0" <?php echo $actividad['aprobada'] == 0 ? 'selected' : ''; ?>>No</option>
                                       <option value="1" <?php echo $actividad['aprobada'] == 1 ? 'selected' : ''; ?>>Sí</option>
                                   </select>
                               </div>
                           </div>
                       </div>
                   <?php endif; ?>
                   <!-- Botones -->
                   <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                       <a href="actividades.php" class="btn btn-secondary">Cancelar</a>
                       <button type="submit" class="btn btn-success">Guardar cambios</button>
                   </div>
               </form>
           </div>
       </div>
   </div>
</body>
</html>