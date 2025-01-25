<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dias pa la feria</title>
    </head>
    <body> 
 <?php

   $refranes = array(
   "A caballo regalado no le mires el diente.",
   "Más vale tarde que nunca.",
   "No por mucho madrugar amanece más temprano.",
   "En casa del herrero, cuchillo de palo.",
   "Al mal tiempo, buena cara.",
   "Cría cuervos y te sacarán los ojos.",
   "El que mucho abarca, poco aprieta.",
   "Más vale pájaro en mano que ciento volando.",
   "Ojos que no ven, corazón que no siente.",
   "Cuando el río suena, agua lleva.");

   echo "<ul>";
    foreach ($refranes as $refran){
        echo "<li>$refran</li>";
    }
    echo "</ul>";
?>
</body>
</html>