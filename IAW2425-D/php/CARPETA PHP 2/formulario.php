<form action="formulario.php">
    <input type="text" name="caja" placeholder="Escribe aqui">
    <input type="submit" value="Enviar">
    <?php
    if (isset($_GET["caja"])){
        echo 'Hola ' . htmlspecialchars($_GET["caja"]) . '!';
    }
    ?>
</form>