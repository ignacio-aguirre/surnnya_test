<?php
include('func.php');
session_start();
$rubro=nget('rubro');
$condrubro=" true and ";
if($rubro>"0") $condrubro=" rubro=".$rubro." and ";

ejecute("delete from temporal_pedidos where usuario=".$_SESSION["usuario"]);

ejecute("insert into temporal_pedidos(usuario,articulo,ficha_estante,cantidad) select ".$_SESSION["usuario"].", articulo,ficha_estante,0  from 
 unidades left join articulos on articulo=idarticulos where ".$condrubro." f_egreso is null");
$reg=registros("select temporal_pedidos.articulo,descripcion,ficha_estante from temporal_pedidos  left join articulos on articulo=idarticulos where usuario=".$_SESSION["usuario"]." order by descripcion");
while($r=mysqli_fetch_assoc($reg)){

echo "<tr><td>".$r["articulo"]."</td><td>".$r["descripcion"]."</td><td>".$r["ficha_estante"]."</td><td><input type='checkbox' onblur=valida_cantidad(this.checked,".$r["articulo"].",'".$r["ficha_estante"]."')></td></tr>";
};
?>