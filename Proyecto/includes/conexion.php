<?php
$servername = "sql107.thsite.top";
$username = "thsi_38097545";
$password = "RHYq?oC!";
$bd = "thsi_38097545_proyecto";

$conn = new mysqli($servername, $username, $password, $bd);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>