<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    
    if ($id === false || $id <= 0) {
        header("Location: actividades.php?error=3");
        exit();
    }

    // Eliminar actividad
    try {
        $stmt = $conn->prepare("DELETE FROM actividades WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            header("Location: actividades.php?success=2");
        } else {
            header("Location: actividades.php?error=2");
        }
    } catch (Exception $e) {
        header("Location: actividades.php?error=1");
    } finally {
        $stmt->close();
        $conn->close();
    }
    exit();
}

header("Location: actividades.php");
exit();
?>