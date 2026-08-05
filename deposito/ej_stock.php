<?php
include('funciones.php');
session_start();
$tipo=$_GET['tipo'];
if($tipo=='STOCK_CONS'){
  $articulo=$_GET['articulo'];
  $st=un_campo('select sum(cantidad) from stock where articulo='. nulea($articulo));
  echo $st;	
};

if($tipo=='ACTUALIZA_MINIMO'){
  $articulo=nget('articulo');
  $minimo=nget('minimo');
  $id=un_campo("select idexistencias from existencias where articulo=".$articulo);
  if(!$id>"0"){$id=inserte("insert into existencias(articulo,cantidad,minimo) values(".$articulo.",0,0)");};
  ejecute('update existencias set minimo='.$minimo.' where idexistencias='.$id);
  exit;
};


if($tipo=='AJUSTES_NUEVO'){
 $sid=session_id();
 if(isset($_GET["fecha"])){
 $fecha=fget('fecha');
 $motivo=tget('motivo');
 } else{
   $fecha=fsql(ffec(un_campo("select fecha from temporal_ajustes where sesion=".tsql($sid)." and temporal_ajustes.cantidad<>0 limit 1")));
   $motivo=tsql("Ajuste por importacion documento");
};
 $id=inserte("insert into ajustes(fecha,motivo) values(".$fecha.",".$motivo.")"); 
 reg_acc("NUEVO AJUSTE",$motivo,$id);
 ejecute("insert into ajustes_articulos(ajuste,articulo,cantidad) select ".$id.",temporal_ajustes.articulo,temporal_ajustes.cantidad from temporal_ajustes where sesion=".tsql($sid)." and temporal_ajustes.cantidad<>0");
 $reg=registros("select * from ajustes_articulos where ajuste=".$id);
 while($r=mysqli_fetch_assoc($reg)){
   inserte("insert into stock(origen_tipo,origen_id,origen_fecha,articulo,cantidad,observaciones) values('AJU',".$id.",".$fecha.",".$r["articulo"].",".$r["cantidad"].",".$motivo.")");
 };
 if(isset($_SESSION["arch_temp"])){
  ejecute("delete from temporal_ajustes where numearch=".$_SESSION["arch_temp"]);
  
  unset($_SESSION["arch_temp"]);
 };
  Redirect("aviso?tipo=AJUSTE&id=".$id."&acc=generado");
};

if($tipo=='AJUSTESBU_NUEVO'){
 $u=$_SESSION["usuario"];
 $fecha=fget('fecha');
 $motivo=tget('motivo');

 $id=inserte("insert into ajustes(fecha,motivo) values(".$fecha.",".$motivo.")"); 
 reg_acc("NUEVO AJUSTE",$motivo,$id);
 ejecute("insert into ajustes_articulos(ajuste,articulo,ficha_estante,cantidad) select ".$id.",articulo,ficha_estante,cantidad from temporal_pedidos where usuario=".$u." and temporal_pedidos.cantidad<>0");
 $reg=registros("select * from ajustes_articulos where ajuste=".$id);
 
 while($r=mysqli_fetch_assoc($reg)){
   inserte("insert into stock(origen_tipo,origen_id,origen_fecha,articulo,cantidad,observaciones) values('AJU',".$id.",".$fecha.",".$r["articulo"].",".$r["cantidad"].",".$motivo.")");
   if($r["ficha_estante"]!=""){
     ejecute("update unidades set f_egreso=curdate() where articulo=".$r["articulo"]." and ficha_estante=".tsql($r["ficha_estante"]));
   };
 };
 Redirect("aviso?tipo=AJUSTE&id=".$id."&acc=generado");
};


if($tipo=='INVENTARIO_NUEVO'){
 $sid=session_id();
 $fecha=fsql(ffec(un_campo("select fecha from temporal_ajustes where sesion=".tsql($sid)." limit 1")));
 $motivo=tsql("Ajuste por importacion documento inventario");
 $id=inserte("insert into ajustes(fecha,motivo) values(".$fecha.",".$motivo.")"); 

 reg_acc("NUEVO INVENTARIO",$motivo,$id);
 ejecute("insert into ajustes_articulos(ajuste,articulo,cantidad) select ".$id.",temporal_ajustes.articulo,temporal_ajustes.cantidad-case when existencias.cantidad is null then 0 else existencias.cantidad end  from temporal_ajustes left join existencias on existencias.articulo=temporal_ajustes.articulo where sesion=".tsql($sid));
 $reg=registros("select * from ajustes_articulos where ajuste=".$id);
 while($r=mysqli_fetch_assoc($reg)){
   echo $r["articulo"]."*".$r["cantidad"]."<br>";
   inserte("insert into stock(origen_tipo,origen_id,origen_fecha,articulo,cantidad,observaciones) values('AJU',".$id.",".$fecha.",".$r["articulo"].",".$r["cantidad"].",".$motivo.")");
 };

 if(isset($_SESSION["arch_temp"])){
  ejecute("delete from temporal_ajustes where numearch=".$_SESSION["arch_temp"]);
  
  unset($_SESSION["arch_temp"]);
 };
  Redirect("aviso?tipo=AJUSTE&id=".$id."&acc=generado");
};

if($tipo=='AJUSTES_ARCH_ELIMINAR'){
 if(isset($_SESSION["arch_temp"])){
  ejecute("delete from temporal_ajustes where numearch=".$_SESSION["arch_temp"]);
  
  unset($_SESSION["arch_temp"]);
 };
 Redirect("ajustes_nuevo");

};
if($tipo=='AJUSTES_ELIMINAR'){

 $comprobante=nget('comprobante');

 reg_acc("ELIMINAR AJUSTE","",$comprobante);

 ejecute("delete from ajustes where comprobante=".$comprobante);

 ejecute("delete from ajustes_articulos where comprobante=".$comprobante);

 ejecute("delete from stock where comprobante=".$comprobante);

 ejecute("update comprobantes set baja=curdate() where idcomprobantes=".$comprobante);

 echo "1";

};

if($tipo=="VENCIMIENTOS_AGREGA"){
  $articulo=nget("articulo");
  $f_vencimiento=fget("f_vencimiento");
  $cantidad=nget("cantidad");
  inserte("insert into stock_vencimientos(articulo,f_vencimiento,cantidad) values(".$articulo.",".$f_vencimiento.",".$cantidad.")");
}


?>