<?php
// logout.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Usar un nombre único de sesión para tu aplicación
session_name('myapp_session');  // Cambia 'myapp_session' por un nombre único

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destruir solo las variables de sesión de tu aplicación
$_SESSION = array();

// Borrar la cookie específica de tu aplicación
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),  // Usará el nombre único definido arriba
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destruir la sesión actual
session_destroy();

// Redireccionar al login
header("Location: login.php");
exit();
?>