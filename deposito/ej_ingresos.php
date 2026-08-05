<?php
include('funciones.php');
session_start();
$tipo=$_GET['tipo'];

if($tipo=='NUEVO'){
 $fecha=fget("fecha");
 $origen=tget("origen");
 $observaciones=tget("observaciones");
 $id=inserte("insert into ingresos(fecha,origen,observaciones) values(".$fecha.",".$origen.",".$observaciones.")");
 reg_acc("NUEVO INGRESO",$observaciones,$id);
 ejecute("insert into ingresos_articulos(ingreso,articulo,cantidad) select ".$id.",temporal_rprov.articulo,temporal_rprov.cantidad from temporal_rprov where usuario=".$_SESSION["usuario"]." and temporal_rprov.cantidad>0 order by idtemporal_rprov ");
 $reg=registros("select * from ingresos_articulos where ingreso=".$id." order by idingresos_articulos");
 
 while($r=mysqli_fetch_assoc($reg)){
   ejecute("insert into stock(origen_tipo,origen_id,origen_fecha,articulo,cantidad,observaciones) values('ING',".$id.",".$fecha.",".$r["articulo"].",".$r["cantidad"].",".$observaciones.")");
 };
Redirect("aviso?tipo=INGRESO&id=".$id."&acc=generado");
}


// ver si esta ultima se usa
if($tipo=='CONS_ARTICULOS'){
 $comprobante=nget("comprobante");
 $reg=registros("select articulo,descripcion,cantidad as recibido from rprov_articulos left join articulos on articulo=idarticulos where  comprobante=".$comprobante."  order by renglon");
 echo "<th>id</th><th>Art&iacuteculo</th><th>Recibido</th><th>Acciones</th>";
while($r=mysqli_fetch_assoc($reg)){
 echo "<tr><td>".$r["articulo"]."</td><td>".utf8_encode($r["descripcion"])."</td><td>".$r["recibido"].
 "</td><td>0</td><td><img src='imagenes/eliminar.png' height='20' width='20' onclick='elimina(".$r["articulo"].")'>&nbsp;<img src='imagenes/editar.png' height='20' width='20' onclick='edita(".$r["articulo"].")'></td></tr>";
 };
};
?>