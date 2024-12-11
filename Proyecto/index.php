<?php
$titulo_pagina = "Inicio";
include 'templates/header.php';
?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center align-items-center min-vh-50">
        <div class="col-12 col-md-8 col-lg-6 text-center">
            
            <div class="mb-5 pb-3">
                <i class="fas fa-graduation-cap text-primary fa-3x mb-4"></i>
                <h1 class="display-5 fw-bold mb-4">
                    Bienvenido a la Plataforma Educativa
                </h1>
                <p class="lead text-muted mb-5">
                    Gestión académica del IES Antonio Machado
                </p>
            </div>

            <div class="d-grid gap-4 mx-auto" style="max-width: 320px;">
                <a href="login.php" class="btn btn-primary btn-lg py-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                </a>
                <a href="registro.php" class="btn btn-outline-primary btn-lg py-3">
                    <i class="fas fa-user-plus me-2"></i>Registrarse
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>