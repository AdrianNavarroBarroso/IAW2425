<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulario</title>
</head>
<body>
<form action="formularioBernat.php" method="POST">
    <input type="number" name="numero" placeholder="Introduce numero > que 0">
    <input type="submit" value="Enviar">
    </form>
 <?php
if(isset($_POST["numero"])){
$n1= htmlspecialchars($_POST["numero"]);
$n2 = "Triangulos <br>";
   
for ($b=1;$b<=$n1;$b++)
{
    for ($a=1;$a<=$b;$a++)
        {$n2 .= "*";}
 $n2 .= "<br>";
} echo "$n2";
 } ?>

</body>
</html>