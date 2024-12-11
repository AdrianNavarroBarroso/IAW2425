<?php
include 'db.php';

// Función para hashear contraseñas
function hash_passwords() {
    global $conn;
    $stmt = $conn->prepare("SELECT id, password FROM login");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $password = $row['password'];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $update_stmt = $conn->prepare("UPDATE login SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $hashed_password, $id);
        $update_stmt->execute();
    }
}

// Llamar a la función para hashear las contraseñas
hash_passwords();
echo "Contraseñas hasheadas correctamente.";
?>