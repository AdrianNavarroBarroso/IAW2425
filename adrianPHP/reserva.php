<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <title>Reserva</title>
    <style>
        body{
            display: flex;
            justify-content:center;
            align-items :center;
            min-height: 100vh;
        }
        form div{
            display:flex;
            width: max-content;
            flex-direction:column;
            margin: 1rem;
        }
        #espaciado{margin-top:1rem;}
    </style>
</head>
<body>
    <form action="reserva.php" method="post">
        <div class="estructurado">
            <label for="">*Nombre:</label>
            <input type="text" name="nombre" id="nombre" placeholder="nombre">
        </div>
        <div class="estructurado">
            <label for="">*Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" placeholder="apellidos">
        </div>
        <div class="estructurado">
            <label for="">*Email:</label>
            <input type="email" name="email" id="email" placeholder="email">
        </div>
        <div class="estructurado">
            <label for="">*DNI:</label>
            <input type="text" name="dni" id="dni" placeholder="dni">
        </div>
        <div class="estructurado">
            <label for="">*Día Entrada:</label>
            <input type="date" name="dia_e" id="dia_e" placeholder="dia entrada">
        </div>
        <div class="estructurado">
            <label for="">*Número de días:</label>
            <input type="number" name="dias" id="dias" placeholder="dias">
        </div>
        <div class="estructurado">
            <label for="tipo_hab">*Tipo Habitación:</label>
            <select name="tipo_hab" id="tipo_hab">
                <option value="30">Simple</option>
                <option value="50">Doble</option>
                <option value="80">Triple</option>
                <option value="100">Suite</option>
            </select>
        </div>
        <input type="submit" value="Enviar">
        <?php
            
                if(empty($_POST["nombre"]) || empty($_POST["apellidos"]) || empty($_POST["email"]) || empty($_POST["dni"]) || empty($_POST["dia_e"]) || empty($_POST["dias"]) || empty($_POST["tipo_hab"]))
                    echo"<div class='estructurado'>Debes de rellenar los campos obligatorios</div>";
                else{
                        echo"<p>Los datos se enviaron exitosamente:</p>";
                        echo"<p>Nombre: " . htmlspecialchars($_POST["nombre"]) . "</p>";
                        echo"<p>Apellidos: " . htmlspecialchars($_POST["apellidos"]) . "</p>";
                        echo"<p>Email: " . htmlspecialchars($_POST["email"]) . "</p>";
                        echo"<p>DNI: " . htmlspecialchars($_POST["dni"]) . "</p>";
                        echo"<p>Día de entrada: " . htmlspecialchars($_POST["dia_e"]) ."</p>";
                        echo"<p>Días: " . htmlspecialchars($_POST["dias"]) ."</p>";
                        echo"<p>Tipo de habitación: " . htmlspecialchars($_POST["tipo_hab"]) ."</p>";
                        echo"<p>Importe Total: " . htmlspecialchars($_POST["tipo_hab"]) * htmlspecialchars($_POST["dias"]) ." €</p>";
                        echo"<p>Imagen: <img src='" . htmlspecialchars($_POST["tipo_hab"]) . ".png' </img></p>";
                }
            
        ?>
    </form>
</body>
</html>