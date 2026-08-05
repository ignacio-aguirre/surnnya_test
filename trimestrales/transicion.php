<?php
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Continuar";
include("encabezado.php");
$trimestral=$_GET["id"];
ejecute("delete from trim_firmas where trimestral=".$trimestral);
$proximo=$_GET["proximo"];
$descripcion="";
if($proximo=="juridicos") $descripcion="Situaci&oacute;n Administrativa / Legal";
if($proximo=="ingreso") $descripcion="Situaci&oacute;n al Ingreso";
if($proximo=="convivencial") $descripcion="Situaci&oacute;n de la Vida Cotidiana / Aspectos Convivenciales";
if($proximo=="salud_fisica") $descripcion="Salud (F&iacute;sica)";
if($proximo=="salud_mental") $descripcion="Salud Mental";
if($proximo=="educacion") $descripcion="Educaci&oacute;n";
if($proximo=="vinculaciones") $descripcion="Vinculaciones Familiares y Comunitarias";
if($proximo=="trayectos") $descripcion="Espacios Socioformativos y Laborales";
if($proximo=="actividades") $descripcion="Actividades Deportivas, Recreativas y Culturales";
if($proximo=="profesional") $descripcion="Apreciaci&oacute;n Profesional";
if($proximo=="discapacidad") $descripcion="Necesidades de Apoyo por Discapacidades";
if($proximo=="estrategias") $descripcion="Estrategias / Acciones a Desarrollar / Plan de Trabajo";
if($proximo=="egreso") $descripcion="Proceso de Egreso";
if($proximo=="firma") $descripcion="Firmar el informe";
?>
</div>
<div class="container">
<h3>Los datos fueron  guardados. Si el informe hab&iacute;a sido firmado, deber&aacute; volver a ser firmado. Presion&aacute; alguno de los botones para continuar</h3>
<br>
<?php if($proximo!=""){?>
<button class="btn-success" onclick='navega("<?php echo $proximo?>")'>Pr&oacute;ximo Conjunto de Datos :<?php echo $descripcion?></button>
<br><br><br>
<?php };?>
<button class="btn-primary" onclick='navega("actualizar")'>Seleccionar otro Conjunto de Datos</button>
<br><br><br>
<button class="btn-primary" onclick='navega("nomina")'>Volver a la N&oacute;mina de Alojados</button>

</div>
