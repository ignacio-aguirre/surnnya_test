<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Eliminaci&oacute;n de Acci&oacute;n";
include("encabezado-test.php");
$id=nget("id");
$a=un_registro("select * from es_acciones where id=".$id);
$solicitud=$a["solicitud"];
$fecha=ffec($a["fecha"]);
$cantenfecha=un_campo("select count(*) from es_acciones where solicitud=".$solicitud." and fecha=".fsql($fecha));
ejecute("delete from es_acciones where id=".$id);
$r="Acci&oacute;n dada de baja<br>";
if($solicitud>"0"){
  $s=un_registro("select * from es_participaciones where id=".$solicitud);
  if(ffec($s["fecha_inicio"])==$fecha && $cantenfecha==1){
    ejecute("update es_participaciones set fecha_inicio=(select min(fecha) from es_acciones where solicitud=es_participaciones.id) where id=".$solicitud);
    $r=$r."Cambi&oacute; la fecha de inicio de la solicitud<br>";
  };
  if(ffec($s["fecha_fin"])==$fecha && $cantenfecha==1){
    ejecute("update es_participaciones set fecha_fin=null where id=".$solicitud);
    $r=$r."Preventivamente se reabri&oacute; la solicitud<br>";
  };
};

echo $r;
?>
<button class="btn-primary" onclick="navega('informe_solicitud_es?id=<?php echo $solicitud?>')">Continuar</button>