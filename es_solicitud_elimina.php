<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Eliminaci&oacute;n de Solicitud";
include("encabezado-test.php");
$id=nget("id");
$cnt=un_campo("select count(*) from es_acciones where solicitud=".$id);
if($cnt=="0"){
ejecute("delete from es_participaciones where id=".$id);
$r="Solicitud dada de baja<br>";
}
else{
$r="Solicitud no dada de baja, tiene acciones. Alerta contra destrucci&oacute;n de datos<br>";
};
echo $r;
?>
<button class="btn-primary" onclick="navega('<?php echo $_SESSION["menu"]?>')">Continuar</button>