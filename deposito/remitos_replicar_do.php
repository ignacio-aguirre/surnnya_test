<?php 
include("funciones.php");
session_start();

$rto=un_registro("select * from remitos where idremitos=".nget("id"));
$mxn=un_campo("select max(numero) from remitos");
$efector=nget("efector");
$efe=un_registro("select * from efectores where idefectores=".$efector);
if(!$mxn>"0"){$numero="1";}
else{ $numero=(string)($mxn+1);};
$id=inserte("insert into remitos(numero,fecha,efector,impreso,nombre,domicilio,localidad,barrio,comuna,telefonos) values(".$numero.",curdate(),".$efector.",0,".tsql($efe["descripcion"]).
   ",".tsql($efe["domicilio"]).",".tsql($efe["localidad"]).",".tsql($efe["barrio"]).
   ",".tsql($efe["comuna"]).",".tsql($efe["telefonos"]).")");

 
$arti=registros("select * from remitos_articulos left join articulos on articulo=idarticulos where remito=".$rto["idremitos"]);
while($art=mysqli_fetch_assoc($arti)){
  inserte("insert into remitos_articulos(remito,articulo,cantidad) values(".$id.",".$art["articulo"].",".$art["cantidad"].")");

  
}
reg_acc("NUEVO RME",$numero,$id);
Redirect("aviso?tipo=REMITO&id=".$id."&acc=generado en estado borrador");
Redirect("mnu_dp");
?>
