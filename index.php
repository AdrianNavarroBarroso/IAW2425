<?php
$titulo_pagina = "Plataforma Educativa";
include 'templates/header.php';
?>

<section class="portada-institucional">
    <div class="contenedor-portada">
        <h2 class="titulo-portada">Bienvenido a la Plataforma Educativa</h2>
        <div class="botones-portada">
            <a href="login.php" class="boton-accion">
                <i class="fas fa-sign-in-alt"></i>
                Iniciar Sesión
            </a>
            <a href="registro.php" class="boton-accion secundario">
                <i class="fas fa-user-plus"></i>
                Registrarse
            </a>
        </div>
    </div>
</section>

<?php include 'templates/footer.php'; ?>