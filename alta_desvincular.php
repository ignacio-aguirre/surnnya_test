<?php
session_start();
include("Funciones.php");
$id=nget("id");
$tipo=$_GET["tipo"];
$lega=un_campo("select legajo from altasybajas where idaltasybajas=".$id);
$archivo=un_campo("select ".si($tipo=="NA","nota ","nota_derivacion ")."from altasybajas where idaltasybajas=".$id);
$todos="1";
if(isset($_GET["todos"])){$todos=$_GET["todos"];};
if($todos=="1"){ejecute("delete from archivos_vinculos where archivo=".$archivo);}
else{ejecute("delete from archivos_vinculos where tipo='A' and archivo=".$archivo);};
ejecute("update altasybajas set ".si($tipo=="NA","nota=0","nota_derivacion=0").", envio=null, email=null, intentos=0,mails_notaaltabaja=null,envio_notaaltabaja=null,intentos_notaaltabaja=0 where idaltasybajas=".$id);
Redirect("admiconsaltas");
?>