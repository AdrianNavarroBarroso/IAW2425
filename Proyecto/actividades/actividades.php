<?php
session_start();
require '../includes/conexion.php';


if (!isset($_SESSION['usuario_id'])) {
   header("Location: login.php");
   exit();
}


// Verificar si es admin
$es_admin = $_SESSION['es_admin'];


// Ordenación
$sort = $_GET['sort'] ?? 'fecha_inicio';
$order = $_GET['order'] ?? 'DESC';
$allowed_sorts = ['titulo', 'tipo', 'departamento', 'total_alumnos', 'fecha_inicio', 'aprobada'];
$sort = in_array($sort, $allowed_sorts) ? $sort : 'fecha_inicio';


// Obtener actividades
$sql = "SELECT a.*, CONCAT(p.nombre, ' ', p.apellidos) AS profesor_nombre
       FROM actividades a
       JOIN profesores p ON a.profesor_responsable = p.id
       ORDER BY $sort $order";
$actividades = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
   <title>Actividades</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
       .sort-header { cursor: pointer; }
       .sort-header:hover { background-color: #f8f9fa; }
   </style>
</head>
<body class="bg-light">
   <div class="container mt-4">
       <div class="d-flex justify-content-between mb-4">
           <h2>Gestión de Actividades</h2>
           <div>
               <a href="crear.php" class="btn btn-success">Nueva Actividad</a>
               <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
           </div>
       </div>


       <table class="table table-hover table-bordered">
           <thead class="table-dark">
               <tr>
                   <th class="sort-header" onclick="sortTable('titulo')">Título <?= getSortIcon('titulo') ?></th>
                   <th class="sort-header" onclick="sortTable('tipo')">Tipo <?= getSortIcon('tipo') ?></th>
                   <th class="sort-header" onclick="sortTable('departamento')">Departamento <?= getSortIcon('departamento') ?></th>
                   <th>Alumnos</th>
                   <th>Profesor</th>
                   <th class="sort-header" onclick="sortTable('fecha_inicio')">Fecha <?= getSortIcon('fecha_inicio') ?></th>
                   <th>Coste</th>
                   <th class="sort-header" onclick="sortTable('aprobada')">Aprobada <?= getSortIcon('aprobada') ?></th>
                   <th>Acciones</th>
               </tr>
           </thead>
           <tbody>
               <?php while ($act = $actividades->fetch_assoc()): ?>
               <tr>
                   <td><?= htmlspecialchars($act['titulo']) ?></td>
                   <td><?= ucfirst($act['tipo']) ?></td>
                   <td><?= htmlspecialchars($act['departamento']) ?></td>
                   <td><?= $act['total_alumnos'] ?></td>
                   <td><?= htmlspecialchars($act['profesor_nombre']) ?></td>
                   <td><?= date('d/m/Y', strtotime($act['fecha_inicio'])) ?></td>
                   <td><?= number_format($act['coste'], 2) ?> €</td>
                   <td><?= $act['aprobada'] ? '✅' : '❌' ?></td>
                   <td>
                       <?php if ($es_admin): ?>
                           <a href="editar.php?id=<?= $act['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                           <a href="eliminar.php?id=<?= $act['id'] ?>" class="btn btn-sm btn-danger"
                              onclick="return confirm('¿Eliminar esta actividad?')">Eliminar</a>
                       <?php endif; ?>
                   </td>
               </tr>
               <?php endwhile; ?>
           </tbody>
       </table>
   </div>


   <script>
   function sortTable(column) {
       const urlParams = new URLSearchParams(window.location.search);
       let newOrder = 'ASC';
      
       if(urlParams.get('sort') === column && urlParams.get('order') === 'ASC') {
           newOrder = 'DESC';
       }
      
       window.location.href = `?sort=${column}&order=${newOrder}`;
   }
   </script>
</body>
</html>


<?php
function getSortIcon($column) {
   if(($_GET['sort'] ?? '') === $column) {
       return $_GET['order'] === 'ASC' ? '↑' : '↓';
   }
   return '';
}
?>