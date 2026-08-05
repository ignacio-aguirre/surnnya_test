<?php 
include("funciones.php");
session_start();
$rto=un_registro("select * from remitos where numero=".nget("numero"));
$motivo="Anulacion remito ".nget("numero");
$id=inserte("insert into ajustes(fecha,motivo) values(curdate(),".tsql($motivo).")"); 
 reg_acc("NUEVO AJUSTE",$motivo,$id);
 
$arti=registros("select * from remitos_articulos left join articulos on articulo=idarticulos where remito=".$rto["idremitos"]);
while($art=mysqli_fetch_assoc($arti)){
  inserte("insert into ajustes_articulos(ajuste,articulo,cantidad) values(".$id.",".$art["articulo"].",".$art["cantidad"].")");
  inserte("insert into stock(origen_tipo,origen_id,origen_fecha,articulo,cantidad,observaciones) values('AJU',".$id.",curdate(),".$art["articulo"].",".$art["cantidad"].",".tsql($motivo).")");

}
ejecute("update remitos set anulado=1 where idremitos=".$rto["idremitos"]);
Redirect("mnu_dp");
?>
