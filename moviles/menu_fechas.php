<?php 
session_start();
include("funciones.php");

$status="";
$_SESSION["prestacion"]="Men&uacute; fechas";
include("encabezado.php");

$ult_fecha=un_campo("select max(fecha) from fechas");

$f_laborables=un_campo("select count(*) from fechas where laborable=1 and month(fecha)=month(curdate()) and year(fecha)=year(curdate())");
$f_no_laborables=un_campo("select count(*) from fechas where laborable=0 and fecha>curdate()");
$mesanio=un_campo("select concat(month(curdate()),'/',year(curdate())) from dual");
?>
</div>
<div class="container">
<div class="table-responsive col-md-6">
	<h4>Situaci&oacute;n</h4>
	<table class="table col-md-6">
		<tr><td>&Uacute;ltima fecha generada</td><td><?php echo ffec($ult_fecha)?></td></tr>
		
		<tr><td>Próximas fechas no laborables</td><td><?php echo $f_no_laborables?></td>
    <tr onclick=location.href="mv_fechas_generar"><td>Generar nuevas 30 fechas</td></tr>
    <tr onclick=location.href="mv_fechas"><td>Revisar fechas futuras (laborables y no)</td></tr>

		
	</table>	
</div>	
</div>
</div>
</body>