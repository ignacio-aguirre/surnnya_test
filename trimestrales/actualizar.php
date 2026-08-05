<?php 
include("funciones.php");
session_start();
if(!isset($_SESSION["hogar"])){Redirect(".");};
if(!isset($_SESSION["trimestre"])){Redirect(".");};
if(!isset($_SESSION["anio"])){Redirect(".");};
if(!$_SESSION["hogar"]>"0"){Redirect(".");};
$hogar=$_SESSION["hogar"];

if(isset($_GET["nnya"])) {
 $_SESSION["nnnya_actual"]=nget("nnya");
 Redirect("actualizar");
};
$nnya=$_SESSION["nnnya_actual"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$id=un_campo("select id from trimestrales where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya);
 $legajo_surnnya=un_campo("select idsurnnya from alojados where idalojados=".$nnya);
$m_fin=$trimestre*3;
if($m_fin==6 || $m_fin==9){$d_fin="30";} else {$d_fin="31";};
$m_fin=(string) $m_fin;
$fact=$anio.substr("0".$m_fin,-2).substr("0".$d_fin,-2);
$edad=un_campo("select edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,".$fact.") from sujetos where legajo=".$legajo_surnnya);
$_SESSION["edad"]=$edad;
if(!$id>"0"){

 $id=inserte("insert into trimestrales(anio,trimestre,hogar,legajo,legajo_surnnya) values(".$anio.",".$trimestre.",".$hogar.",".$nnya.",".$legajo_surnnya.")");
};
$_SESSION["prestacion"]="Conjuntos de Datos de ".un_campo("select concat(apellidos,', ',nombres) from alojados where idalojados=".$nnya);
include("encabezado.php");
?>
</div>
<div class="container" align="center">
<p class="text-warning">El objetivo de este informe es poder dar cuenta del proceso que realiz&oacute; el ni&ntilde;o/a o adolescente alojado durante un per&iacute;odo
 de 3 meses y de las acciones que se llevaron a cabo desde el equipo del dispositivo de cuidado en pos de garantizar la restituci&oacute;n de los derechos.
 En este se debe detallar los cambios producidos en cada uno de los &iacute;tems especificados en el Trimestre</p>
<ul class="list-group">
<li class="list-group-item"><a href='identidad'>Identidad y Datos Generales</a>&nbsp;<?php echo carga("IDE",$anio,$trimestre,$nnya,$hogar);?></li>
<li class="list-group-item"><a href='juridicos'>Situaci&oacute;n Administrativa / Legal</a>&nbsp;<?php echo carga("JUR",$anio,$trimestre,$nnya,$hogar);?></li>
<li class="list-group-item"><a href='ingreso'>Situaci&oacute;n al Ingreso</a>&nbsp;<?php echo carga("ING",$anio,$trimestre,$nnya,$hogar);?></li>
<li class="list-group-item"><a href='convivencial'>Situaci&oacute;n de la Vida Cotidiana / Aspectos convivenciales</a>&nbsp;<?php echo carga("CON",$anio,$trimestre,$nnya,$hogar);?></li>
<li class="list-group-item"><a href='salud_fisica'>Salud F&iacute;sica</a>&nbsp;<?php echo carga("SAF",$anio,$trimestre,$nnya,$hogar);?></li>
<li class="list-group-item"><a href='salud_mental'>Salud Mental</a>&nbsp;<?php echo carga("SAM",$anio,$trimestre,$nnya,$hogar);?></li>
<li class="list-group-item"><a href='discapacidad'>Necesidades de Apoyo por Discapacidades</a>&nbsp;<?php echo carga("DIS",$anio,$trimestre,$nnya,$hogar);?></li>
<li class="list-group-item"><a href='educacion'>Educaci&oacute;n</a>&nbsp;<?php echo carga("EDU",$anio,$trimestre,$nnya,$hogar);?></li>
<?php if($edad>=16){?>
<li class="list-group-item"><a href='trayectos'>Espacios Socioformativos y Laborales</a>&nbsp;<?php echo carga("TRA",$anio,$trimestre,$nnya,$hogar);?></li><?php }?>
<li class="list-group-item"><a href='actividades'>Actividades Recreativas, Deportivas y Culturales</a>&nbsp;<?php echo carga("ACT",$anio,$trimestre,$nnya,$hogar);?></li>

<li class="list-group-item"><a href='vinculaciones'>Vinculaciones Familiares o Comunitarias</a>&nbsp;<?php echo carga("VIN",$anio,$trimestre,$nnya,$hogar);?></li>
<li class="list-group-item"><a href='egreso'>Proceso de Egreso</a>&nbsp;<?php echo carga("EGR",$anio,$trimestre,$nnya,$hogar);?></li>
<li class="list-group-item"><a href='estrategias'>Estrategias y Acciones</a>&nbsp;<?php echo carga("EST",$anio,$trimestre,$nnya,$hogar);?></li>
</ul>
</div>
<?php
function carga($con,$a,$t,$l,$h){
 if($con=="IDE") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_identidad left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_identidad.hogar=".$h);};
 if($con=="JUR") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_juridicos left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_juridicos.hogar=".$h);};
 if($con=="ING") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_ingreso left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_ingreso.hogar=".$h);};
 if($con=="CON") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_convivencial left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_convivencial.hogar=".$h);};
 if($con=="SAF") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_salud_fisica left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_salud_fisica.hogar=".$h);};
 if($con=="SAM") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_salud_mental left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_salud_mental.hogar=".$h);};
 if($con=="DIS") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_discapacidad left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_discapacidad.hogar=".$h);};
 if($con=="EDU") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_educacion left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_educacion.hogar=".$h);};
 if($con=="TRA") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_trayectos left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_trayectos.hogar=".$h);};
 if($con=="ACT") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_actividades left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_actividades.hogar=".$h);};
 if($con=="VIN") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_vinculaciones left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_vinculaciones.hogar=".$h);};
 if($con=="EGR") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_egreso left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_egreso.hogar=".$h);};
 if($con=="EST") {$c=un_registro("select usuarios_hogares.descripcion, fecha from trim_estrategias left join usuarios_hogares on usuario=usuarios_hogares.id where anio=".$a." and trimestre=".$t." and legajo=".$l." and trim_estrategias.hogar=".$h);};
 return $c["descripcion"]." ".ffec($c["fecha"]);

}
?>
</body>