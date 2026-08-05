<?php
include("Funciones.php");
session_start();
$tipo=$_GET["tipo"];
if($tipo=="DICCIONARIO"){
 echo "<table class='table'><tr class='bg-primary' style='font-size:.8em;'><th>C&oacute;digo</th><th>Descripci&oacute;n</th><th>Acciones</th></tr>";
 $reg=registros("select * from diccionario_tablas where baja is null order by  descripcion");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr style='font-size:.8em;'><td>".utf8_encode($r["codigo"])."</td><td>".utf8_encode($r["descripcion"])."</td><td>".
"<img src='imagenes/mas.png' height='15' width='15' onclick='tablas(".'"'.$r["codigo"].'"'.")' title='contenido'>&nbsp;
 <img src='imagenes/editar.png' height='15' width='15' onclick='editar(".$r["iddiccionario_tablas"].")' title='editar'>&nbsp;
 <img src='imagenes/eliminar.png' height='15' width='15' onclick='eliminar(".$r["iddiccionario_tablas"].")' title='baja'></td></tr>";
 };
 echo "</table>";
};
if($tipo=="TABLAS"){
 $tipo=tget("tipot");
 echo "<table class='table'><tr class='bg-primary' style='font-size:.8em;'><th>Valor</th><th>Descrripci&oacute;n</th><th>Acciones</th></tr>";
 $reg=registros("select * from tablas_semestrales where tipo=".$tipo." and baja is null order by  valor");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr style='font-size:.8em;'><td>".$r["valor"]."</td><td>".utf8_encode($r["descripcion"])."</td><td>".
 "<img src='imagenes/editar.png' height='15' width='15' onclick='editar(".$r["idtablas_semestrales"].")' title='editar'>&nbsp;
 <img src='imagenes/eliminar.png' height='15' width='15' onclick='eliminar(".$r["idtablas_semestrales"].")' title='baja'></td></tr>";
 };
 echo "</table>";
};
?>