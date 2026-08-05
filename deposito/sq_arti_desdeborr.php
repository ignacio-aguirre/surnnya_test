<?php
include('func.php');
session_start();
$id=nget('id');
$reg=registros("select * from remitos_articulos left join articulos on articulo=idarticulos where remito=".$id);
while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["articulo"]."</td><td>".$r["descripcion"]."</td><td>".$r["cantidad"].
"<td><img src='imagenes/eliminar.png' height='17' width='17' onclick='elimina(".arti.")'>&nbsp;
<img src='imagenes/editar.png' height='17' width='17' onclick='edita(".arti.")'></td></tr>";

};
exit();
?>