<?php
session_start();
include("Funciones.php");
$pais=npost("pais");
$nombre=tpost("nombre");
$listacampos="(pais,nombre";
$listavalo="(".$pais.",".$nombre;
$partido=npost("partido");
$provincia=npost("provincia");
$sentbus="select id from localidades_nueva where pais=".$pais." and nombre=".$nombre;
$nprov=strtoupper(un_campo("select descripcion from provincias where idprovincias=".$provincia));
if($pais=="9"){
  $listacampos=$listacampos.", provincia";
  $listavalo=$listavalo.", ".tsql($nprov);
  $sentbus=$sentbus." and provincia=".tsql($nprov);
  if($partido!="null"){
    $npart=un_campo("select nombre from partidos where id=".$partido);
    $listacampos=$listacampos.", partido";
    $listavalo=$listavalo.", ".tsql($npart);
    $sentbus=$sentbus." and partido=".tsql($npart);}; 	
};
$id=un_campo($sentbus);
if($id>0) {die("localidad existente");}
$sentins="insert into localidades_nueva ". $listacampos.") values".$listavalo.")";
inserte($sentins);
Redirect("localidades");
?>


