<?php
include('funciones.php');
session_start();
$tipo=$_GET['tipo'];
if($tipo=="NUEVO"){
 $mxn=un_campo("select max(numero) from remitos");
 $fecha=fget("fecha");
 $efector=nget("efector");
 $efe=un_registro("select * from efectores where idefectores=".$efector);
 
 if(!$mxn>"0"){$numero="1";}
 else{ $numero=(string)($mxn+1);};

 $id=inserte("insert into remitos(numero,fecha,efector,impreso,nombre,domicilio,localidad,barrio,comuna,telefonos) values(".$numero.",".$fecha.",".$efector.",0,".tsql($efe["descripcion"]).
   ",".tsql($efe["domicilio"]).",".tsql($efe["localidad"]).",".tsql($efe["barrio"]).
   ",".tsql($efe["comuna"]).",".tsql($efe["telefonos"]).")");

 $reg=registros("select * from temporal_pedidos where usuario=".$_SESSION["usuario"]." order by idtemporal_pedidos");
 while($r=mysqli_fetch_assoc($reg)){
  if($r["cantidad"]>0){
    inserte("insert into remitos_articulos(remito,articulo,cantidad) values(".$id.",".$r["articulo"].",".$r["cantidad"].")");
  };
 };
 reg_acc("NUEVO RME",$numero,$id);
 Redirect("aviso?tipo=REMITO&id=".$id."&acc=generado en estado borrador");
};
if($tipo=="EDITAR"){
 $id=nget("id");
 $rto=un_registro("select * from remitos where idremitos=".$id);
 $fecha=fget("fecha");
 $efector=nget("efector");
 $efe=un_registro("select * from efectores where idefectores=".$efector);
 // nuevo control
  $ok=1;
  
  $reg=registros("select temporal_pedidos.*,existencias.cantidad,
    articulos.descripcion 
    from temporal_pedidos 
    left join articulos on temporal_pedidos.articulo=articulos.idarticulos 
    left join existencias on temporal_pedidos.articulo=existencias.articulo 
    where usuario=".$_SESSION["usuario"]." and temporal_pedidos.cantidad>existencias.cantidad order by idtemporal_pedidos");
    
  $lista="";
  while($r=mysqli_fetch_assoc($reg)){
    $ok=0;
    $lista=$lista.",".$r["descripcion"];
  };
  if($ok==1){
   ejecute("update remitos set efector=".$efector.
    ", nombre=".tsql($efe["descripcion"]).
    ", domicilio=".tsql($efe["domicilio"]).
    ", localidad=".tsql($efe["localidad"]).
    ", barrio=".tsql($efe["barrio"]).
    ", comuna=".nulea($efe["comuna"]).
    ", telefonos=".tsql($efe["telefonos"]).
    " where idremitos=".$id);
   ejecute("delete from remitos_articulos where remito=".$id);
   $reg=registros("select articulo,cantidad from temporal_pedidos where usuario=".$_SESSION["usuario"]);
   while($r=mysqli_fetch_assoc($reg)){
     if($r["cantidad"]>0){
       inserte("insert into remitos_articulos(remito,articulo,cantidad) values(".$id.",".$r["articulo"].",".$r["cantidad"].")");
     };
    };
    reg_acc("EDITAR RME",$rto["numero"],$id);
    echo $ok;
  }
  else{echo $lista;};

};

if($tipo=="CERRAR"){ 
  $id=nget("id");
  $rto=un_registro("select * from remitos where idremitos=".$id);
  // nuevo control
  $ok=1;
  $lista=""; 
  $reg=registros("select articulos.descripcion
    from remitos_articulos 
    left join articulos on remitos_articulos.articulo=idarticulos 
    left join existencias on remitos_articulos.articulo=existencias.articulo
    where remito=".$id." and remitos_articulos.cantidad>existencias.cantidad 
    order by idremitos_articulos");
  while($r=mysqli_fetch_assoc($reg)){
    $ok=0;
    $lista=$lista.",".$r["descripcion"];
  };
  if($ok==1){
  $reg=registros("select * from remitos_articulos where remito=".$id." order by idremitos_articulos");
  while($r=mysqli_fetch_assoc($reg)){
    if($r["cantidad"]>0){
      inserte("insert into stock(origen_tipo,origen_id,origen_fecha,articulo,cantidad,observaciones) values('RME',".$id.",".fsql(ffec($rto["fecha"])).",".$r["articulo"].",-".$r["cantidad"].",".tsql($rto["nombre"]).")");
      
    };
  };
  registros("update remitos set impreso=1 where idremitos=".$id);	echo $ok;}
  else{echo $lista;};
  
};

?>