<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Bloqueo 2";
include("encabezado.php");
$proc=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
$desde=fsql(ffec($proc["desde_ab"]));
$hasta=$proc["hasta"];
$desdev=$proc["desde_ab"];
$desdes=fsql(ffec($desdev));
$hastas=fsql(ffec($hasta));
$bandeja="6";
$cvia=un_campo("select count(*) from movil_viajes where bandeja=".$bandeja." and fecha between ".$desdes." and ".$hastas);
$crec=un_campo("select count(*) from movil_viajes where bandeja=".$bandeja." and fecha between ".$desdes." and ".$hastas." and  estado<>'APR'");

?>
</div>
<br><br>
<div class="container">
<div class="row">
<h8 class="col-md-12">Bloqueo a realizar:<strong>2</strong></h8>
<p class="text-primary">
El bloqueo 2 configura el cierre de viajes para emitir los documentos a las empresas<br>
Luego de efectuado no podr&aacute;n editarse, cancelarse ni agregar viajes, salvo por medio de una gesti&oacute;n<br>
Se est&aacute; descargando documento con todos los viajes
</p>
</div>
<div class="table-responsive" style="font-size: .9em;">
<table class="table table-striped">
<thead class="table-dark">
</thead>
<tbody>
<tr><td>Cantidad de viajes</td><td><?php echo $cvia?></td></tr>
<tr><td>Viajes NO en estado APROBADO no pasar&aacute;n</td><td><?php echo $crec?></td></tr>
</tbody>
</table>
</div> 
<p class="text-dark">Si no se desea bloquear volver atr&aacute;s o ir al men&uacute;</p>
<form class="form-inline" method="get" action="mv_bloqueo2_do">
<button class="btn-success">Bloquear</button>
</form>
</div>
<script>
naveganuevo("mv_generar_envio_do");	
</script>