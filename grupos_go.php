<?php

include("Funciones.php");

session_start();

$fras=tget("frase");

$reg=registros("select * from grupos WHERE apellidos like concat('%',".$fras.",'%') order by apellidos"); 

$conta=1; 

while ($r = mysqli_fetch_assoc($reg)) {

   $conta=$conta+1;

   if($conta % 2==0) {echo "<tr bgcolor='white'>";} else echo "<tr bgcolor='#E6E6E6'>";

   echo "<td>".$r["idgrupos"]."</td><td>".$r['apellidos']."</td>".

   "<td>".si($r["categoria"]<2,"Hermanos","Materno")."</td><td>";

   if($_SESSION["gl_admi"]=="1") echo "<a href='javascript:elimina(".$r["idgrupos"].")'><img height='15' width='15' src='imagenes/eliminar.png'></a>";

   echo "&nbsp;<img height='15' width='15' src='imagenes/editar.png' onclick='edita(".$r["idgrupos"].")'>";

   echo "<a href='grupos2.php?id=".$r["idgrupos"]."'><img height='15' width='15' src='imagenes/piba.jpg'></a>";

   echo "</td></tr>";

 };

?>

