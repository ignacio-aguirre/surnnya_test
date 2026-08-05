<?php
include("Funciones.php");
session_start();
$legajo=nget("legajo");
$rint=tget("rint");
$medi=tget("medi");
$reme=tget("reme");
$buzo=tget("buzo");
$camp=tget("camp");
$pant=tget("pant");
$zapa=tget("zapa");
$guar=tget("guar");
$pint=tget("pint");
$pech=tget("pech");
$id=un_campo("select id from sujetos_talles where legajo=".$legajo);
if(!$id>0) $id=inserte("insert into sujetos_talles(legajo) values(".$legajo.")");
ejecute("update sujetos_talles set rint=".$rint.
	",medi=".$medi.
	",reme=".$reme.
	",buzo=".$buzo.
	",camp=".$camp.
	",pant=".$pant.
	",zapa=".$zapa.
	",guar=".$guar.
	",pint=".$pint.
	",pech=".$pech." where id=".$id);

Redirect("admicons3");
?>