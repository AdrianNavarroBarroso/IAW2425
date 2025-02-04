<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_name('myapp_session');
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo_pagina ?> - IES Antonio Machado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="bg-white shadow-sm fixed-top">
        <nav class="navbar navbar-expand-lg py-2">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                    <img src="img/logo-instituto.jpg" alt="Logo" height="50" class="me-3">
                    <div>
                        <h1 class="h5 mb-0 text-primary">IES Antonio Machado</h1>
                        <p class="text-muted small mb-0">Formación y Excelencia Académica</p>
                    </div>
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="ms-auto d-flex align-items-center">
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <a href="logout.php" class="btn btn-danger btn-sm">
                                <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>
    <main class="flex-grow-1" style="padding-top: 80px;">