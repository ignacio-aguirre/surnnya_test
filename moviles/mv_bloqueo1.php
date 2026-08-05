<?php
require("funciones.php"); 
session_start();
$_SESSION["prestacion"]="Bloqueo 1";
include("encabezado.php");
$proc=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
$desdes=fsql(ffec($proc["desde_ab"]));
$hastas=fsql(ffec(un_campo("select fecha from fechas where laborable=1 and fecha>=".$desdes." order by fecha asc limit 1")));
$desdev=ffec($proc["desde_ab"]);
$hastav=ffec(un_campo("select fecha from fechas where laborable=1 and fecha>=".$desdes." order by fecha asc limit 1"));
?>
</div>
<br><br>
<div class="container">
<div class="row">
<h8 class="col-md-12">Bloqueo a realizar:<strong>1</strong></h8>
<p class="text-primary" style="font-size:.9em">
El bloqueo 1 impide que los dispositivos editen viajes en el rango de fechas actual y actualiza la fecha habilitada como inicial para la carga de nuevos viajes. Los viajes en bandeja 'Solicitados' pasan a bandeja 'En revisi&oacute;n'<br>
</p>
</div>
<div class="table-responsive" style="font-size:.8em">
<table class="table  table-striped col-md-12">
<thead table-dark>
	<tr><th>Desde</th><th>Hasta</th></tr>
	<tr><th><?php echo $desdev?></th><th><?php echo $hastav?></th></tr>
	<tr><th>Bandeja</th><th>Cantidad</th><th>no Aprobados no Programados</th></tr>
</thead>
<tbody>
	<?php
	    
	    
		$v=un_registro("select bandeja, count(*) as cant,sum(case when estado<>'APR' and estado<>'PRO' then 1 else 0 end) as cant_na from movil_viajes where fecha between ".$desdes." and ".$hastas." and bandeja =1 group by bandeja");
		
		 echo "<tr><td>Solicitados</td><td>".$v["cant"]."</td><td>".$v["cant_na"]."</td></tr>";
				
			?>

</tbody>
</table>
</div> 
<p class="text-dark">Si no se desea bloquear volver atr&aacute;s o ir al men&uacute;</p>
<form class="form-inline" method="get" action="mv_bloqueo1_do">
	<div class="form-group has-warning col-md-4">
		<button class="btn-success">Bloquear</button>
	</div>	
</form>
</div>
