<?php
session_start();
require '../includes/conexion.php';


if (!isset($_SESSION['usuario_id'])) {
   header("Location: login.php");
   exit();
}


$departamentos = [
   'matematicas' => 'Matemáticas',
   'ciencias' => 'Ciencias Naturales',
   'informatica' => 'Informática',
   'lengua' => 'Lengua y Literatura',
   'historia' => 'Historia'
];


$profesores = $conn->query("SELECT id, nombre, apellidos FROM profesores");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $campos = [
       'titulo' => $_POST['titulo'],
       'tipo' => $_POST['tipo'],
       'departamento' => $_POST['departamento'],
       'profesor' => $_POST['profesor'],
       'trimestre' => $_POST['trimestre'],
       'fecha_inicio' => $_POST['fecha_inicio'],
       'hora_inicio' => $_POST['hora_inicio'],
       'fecha_fin' => $_POST['fecha_fin'],
       'hora_fin' => $_POST['hora_fin'],
       'organizador' => $_POST['organizador'],
       'ubicacion' => $_POST['ubicacion'],
       'coste' => (float)$_POST['coste'],
       'total_alumnos' => (int)$_POST['total_alumnos'],
       'objetivo' => $_POST['objetivo'],
       'aprobada' => $_SESSION['es_admin'] ? (int)$_POST['aprobada'] : 0 // Nuevo campo
   ];


   $stmt = $conn->prepare("INSERT INTO actividades (
       titulo, tipo, profesor_responsable, departamento, trimestre,
       fecha_inicio, hora_inicio, fecha_fin, hora_fin, organizador,
       ubicacion, coste, total_alumnos, objetivo, aprobada
   ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


   $stmt->bind_param("ssissssssssdssi",
       $campos['titulo'],
       $campos['tipo'],
       $campos['profesor'],
       $campos['departamento'],
       $campos['trimestre'],
       $campos['fecha_inicio'],
       $campos['hora_inicio'],
       $campos['fecha_fin'],
       $campos['hora_fin'],
       $campos['organizador'],
       $campos['ubicacion'],
       $campos['coste'],
       $campos['total_alumnos'],
       $campos['objetivo'],
       $campos['aprobada']
   );


   if ($stmt->execute()) {
       header("Location: actividades.php");
       exit();
   } else {
       die("Error al crear actividad: " . $stmt->error);
   }
}
?>


<!DOCTYPE html>
<html>
<head>
   <title>Nueva Actividad</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
       .seccion { border-left: 3px solid #0d6efd; padding-left: 1rem; margin-bottom: 2rem; }
       h5 { color: #0d6efd; margin-bottom: 1rem; }
   </style>
</head>
<body class="bg-light">
   <div class="container mt-4">
       <div class="card shadow">
           <div class="card-header bg-primary text-white">
               <h3>Nueva Actividad</h3>
           </div>
           <div class="card-body">
               <form method="POST">
                   <div class="row g-3">
                       <!-- Sección 1: Información Básica -->
                       <div class="seccion col-12">
                           <h5>Información Básica</h5>
                           <div class="row">
                               <div class="col-md-8">
                                   <label class="form-label">Título</label>
                                   <input type="text" name="titulo" class="form-control" required>
                               </div>
                               <div class="col-md-4">
                                   <label class="form-label">Coste (€)</label>
                                   <input type="number" step="0.01" name="coste" class="form-control" required>
                               </div>
                           </div>
                       </div>


                       <!-- Sección 2: Clasificación -->
                       <div class="seccion col-12">
                           <h5>Clasificación</h5>
                           <div class="row">
                               <div class="col-md-4">
                                   <label class="form-label">Tipo</label>
                                   <select name="tipo" class="form-select" required>
                                       <option value="extraescolar">Extraescolar</option>
                                       <option value="complementaria">Complementaria</option>
                                   </select>
                               </div>
                               <div class="col-md-4">
                                   <label class="form-label">Departamento</label>
                                   <select name="departamento" class="form-select" required>
                                       <?php foreach ($departamentos as $key => $value): ?>
                                           <option value="<?= $key ?>"><?= $value ?></option>
                                       <?php endforeach; ?>
                                   </select>
                               </div>
                               <div class="col-md-4">
                                   <label class="form-label">Profesor</label>
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
                       <div class="seccion col-12">
                           <h5>Calendario</h5>
                           <div class="row">
                               <div class="col-md-3">
                                   <label class="form-label">Fecha inicio</label>
                                   <input type="date" name="fecha_inicio" class="form-control" required>
                               </div>
                               <div class="col-md-3">
                                   <label class="form-label">Hora inicio</label>
                                   <input type="time" name="hora_inicio" class="form-control" required>
                               </div>
                               <div class="col-md-3">
                                   <label class="form-label">Fecha fin</label>
                                   <input type="date" name="fecha_fin" class="form-control" required>
                               </div>
                               <div class="col-md-3">
                                   <label class="form-label">Hora fin</label>
                                   <input type="time" name="hora_fin" class="form-control" required>
                               </div>
                           </div>
                       </div>


                       <!-- Sección 4: Detalles -->
                       <div class="seccion col-12">
                           <h5>Detalles</h5>
                           <div class="row">
                               <div class="col-md-4">
                                   <label class="form-label">Trimestre</label>
                                   <select name="trimestre" class="form-select" required>
                                       <option value="1">Primero</option>
                                       <option value="2">Segundo</option>
                                       <option value="3">Tercero</option>
                                   </select>
                               </div>
                               <div class="col-md-4">
                                   <label class="form-label">Organizador</label>
                                   <input type="text" name="organizador" class="form-control" required>
                               </div>
                               <div class="col-md-4">
                                   <label class="form-label">Ubicación</label>
                                   <input type="text" name="ubicacion" class="form-control" required>
                               </div>
                           </div>
                       </div>


                       <!-- Sección 5: Participación -->
                       <div class="seccion col-12">
                           <h5>Participación</h5>
                           <div class="row">
                               <div class="col-md-6">
                                   <label class="form-label">Total de alumnos</label>
                                   <input type="number" name="total_alumnos" class="form-control" required>
                               </div>
                               <div class="col-12">
                                   <label class="form-label">Objetivo</label>
                                   <textarea name="objetivo" class="form-control" rows="3" required></textarea>
                               </div>
                           </div>
                       </div>


                       <!-- Sección 6: Aprobación (solo administradores) -->
                       <?php if ($_SESSION['es_admin']): ?>
                       <div class="seccion col-12">
                           <h5>Aprobación</h5>
                           <div class="row">
                               <div class="col-md-6">
                                   <label class="form-label">Aprobada</label>
                                   <select name="aprobada" class="form-select" required>
                                       <option value="0">No</option>
                                       <option value="1">Sí</option>
                                   </select>
                               </div>
                           </div>
                       </div>
                       <?php endif; ?>


                       <!-- Botones -->
                       <div class="col-12">
                           <button type="submit" class="btn btn-primary">Guardar</button>
                           <a href="actividades.php" class="btn btn-secondary">Cancelar</a>
                       </div>
                   </div>
               </form>
           </div>
       </div>
   </div>
</body>
</html>