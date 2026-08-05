<?php 
include("funciones.php");
session_start();
$status="";
$_SESSION["prestacion"]="Men&uacute;";
include("encabezado.php");
$r=un_registro("select * from parametros");
$fechas=un_campo("select case when curdate() between ".fsql(ffec($r["carga_desde"]))." and ".fsql(ffec($r["carga_hasta"]))." then 1 else 0 end from dual");
?>
</div>
<div class="container">
<br>
<div class="table-responsive col-lg-12 col-offset-6 centered">
<table class="table table-hover table-condensed">
<?php if($_SESSION["usuario"]=="0" || $fechas=="1")	{?>
<tr class="info" onclick=location.href="nomina"><td align="center">Cargar Datos</td></tr>
<?php }?>
<tr class="warning" onclick=location.href="informes"><td align="center">Ver Lista de Informes Trimestrales para consulta o firma</td></tr>
<tr class="success" onclick=location.href="vuelco"><td align="center">Vuelco de datos en Excel</td></tr>
</table>
</div>
<div class="table-responsive col-sm-4">
</div>
</div>
</body>