<?php 
include("funciones.php");
session_start();
if(!$_SESSION["hogar"]>"0"){Redirect(".");};
$pais=npost("pais");
$prov=tpost("provincia");
$part=tpost("partido");
$nomb=tpost("nombre");
$sent="select id from localidades_nueva where nombre=".$nomb." and pais=".$pais;
if($prov<>"''"){$sent=$sent." and provincia=".$prov;};
if($part<>"''"){$sent=$sent." and partido=".$part;};
$id=un_campo($sent);
if(!($id>"0")) {$id=inserte("insert into localidades_nueva(nombre,pais) values(".strtoupper($nomb).",".$pais.")");};
if($prov<>"''"){registros("update localidades_nueva set provincia=".strtoupper($prov)." where id=".$id);};
if($part<>"''"){registros("update localidades_nueva set partido=".strtoupper($part)." where id=".$id);}; 
?>
<script>
 window.close();
</script>
