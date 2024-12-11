<?php
include 'conexion1.php';

$usuarios = [
    ['id' => 1, 'password' => 'contraseña1'],
    ['id' => 2, 'password' => 'contraseña2'],
    ['id' => 3, 'password' => 'contraseña3']
];

foreach ($usuarios as $user) {
    $hash = password_hash($user['password'], PASSWORD_BCRYPT);
    $conn->query("UPDATE usuarios SET password = '$hash' WHERE id = {$user['id']}");
}

echo "Contraseñas actualizadas correctamente!";
?>