<?php
include('funciones.php');
session_start();
$tipo=$_GET['tipo'];


if($tipo=='RUBRO_CONS'){
  $descr=$_GET['descripcion'];
  $id=un_campo('select idarticulos_rubros from articulos_rubros where baja is null and descripcion='. tsql($descr));
  echo $id;	
};
// falta hacer una similar cuando es editar

if($tipo=='RUBRO_BAJA'){
 $id=nget('id');
 ejecute('update articulos_rubros set baja=curdate() where idarticulos_rubros='.$id);
 Redirect("aviso?tipo=RUBRO&id=".$id."&acc=dado de baja");
};


if($tipo=='ARTICULO_CONS'){
  $descr=$_GET['descripcion'];
  $id=un_campo('select idarticulos from articulos where baja is null and descripcion='. tsql($descr));
  echo $id;	
};

if($tipo=='ARTICULO_BAJA'){
 $id=nget('id');
 $stk=un_campo("select cantidad from existencias where articulo=".$id);
 if(intval($stk)>0){
  die("no puede darse de baja un bien con stock");
 }; 
 ejecute('update articulos set baja=curdate() where idarticulos='.$id);
 Redirect("aviso?tipo=ARTICULO&id=".$id."&acc=dado de baja");
};

if($tipo=='ARTICULO_SELECT'){
 $rubro=nget('rubro');
 $reg=registros("select * from articulos where baja is null and rubro=".$rubro." order by descripcion");
 $s="";
 while($r=mysqli_fetch_assoc($reg)){
   $s=$s."<option value=".$r["idarticulos"].">".utf8_encode($r["descripcion"])."</option>";
 };
 echo $s;
};

if($tipo=='EFECTOR_CONS'){
  $descr=$_GET['descripcion'];
  $id=un_campo('select idefectores from efectores where baja is null and descripcion='. tsql($descr));
  echo $id;	
};

if($tipo=='EFECTOR_CONS_ED'){
  $descr=tget('descripcion');
  $id=nget("id");
  $id=un_campo("select idefectores from efectores where idefectores<>".$id." and baja is null and descripcion=".$descr);
  echo $id;	
};

if($tipo=='EFECTOR_BAJA'){
 $id=nget('id');
 ejecute('update efectores set baja=curdate() where idefectores='.$id);
 Redirect("aviso?tipo=EFECTOR&id=".$id."&acc=dado de baja");
};


if($tipo=='USUARIOS_BAJA'){
 $id=nget('id');
 ejecute('update usuarios set baja=curdate() where idusuarios='.$id);
 Redirect("aviso?tipo=USUARIO&acc=eliminado&id=".$id);
};

if($tipo=='ART_SEL'){
 $fras=$_GET["frase"];
 echo opciones_cond("articulos","articulos.descripcion like '%".$fras."%'"); 
};
?>