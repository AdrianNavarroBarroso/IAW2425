<?php
$servername = "sql107.thsite.top";
$username = "thsi_38097545";
$password = "RHYq?oC!";
$bd = "thsi_38097545_proyecto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>