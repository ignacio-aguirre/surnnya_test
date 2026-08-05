<?php
include('func.php');
session_start();
$rubro=nget('rubro');

$sid=tsql(session_id());
ejecute("delete from temporal_ajustes where sesion=".$sid);
ejecute("insert into temporal_ajustes(sesion,articulo,stock,cantidad) select ".$sid.", idarticulos, case when existencias.cantidad is null then 0 else existencias.cantidad end, 0 from 
 articulos left join existencias on articulos.idarticulos=existencias.articulo where tipo_bien=1 and rubro=".$rubro." and articulos.baja is null order by articulos.descripcion");
$reg=registros("select temporal_ajustes.articulo,descripcion,stock,temporal_ajustes.cantidad from temporal_ajustes left join articulos on articulo=idarticulos left join existencias on articulos.idarticulos=existencias.articulo  where sesion=".$sid." order by articulos.descripcion");
while($r=mysqli_fetch_assoc($reg)){
echo "<tr><td>".$r["articulo"]."</td><td>".utf8_decode($r["descripcion"])."</td><td>".$r["stock"]."</td><td><input id='c".$r["articulo"]."' size='6' maxlength='6' onblur='valida_cantidad(this.id)'></td></tr>";
};
?>