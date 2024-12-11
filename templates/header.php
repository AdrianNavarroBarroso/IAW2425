<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?> - IES Antonio Machado</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header-institucional">
        <div class="contenedor-header">
            <div class="logo-titulo">
                <img src="img/logo-instituto.png" alt="Logo IES Antonio Machado" class="logo-header">
                <div class="textos-header">
                    <h1 class="titulo-principal">IES Antonio Machado</h1>
                    <p class="subtitulo-header">Formación y Excelencia Académica</p>
                </div>
            </div>
            <nav class="navegacion-principal">
                <?php if(isset($_SESSION['usuario_id'])): ?>
                    <a href="actividades/" class="nav-enlace"><i class="fas fa-home"></i> Panel</a>
                <?php else: ?>
                    <a href="login.php" class="nav-enlace"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
                    <a href="registro.php" class="nav-enlace"><i class="fas fa-user-plus"></i> Registrarse</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="contenido-principal">