<?php 
include("func.php");
session_start();
$status="";
if(isset($_GET['status'])) $status=$_GET['status'];
$_SESSION["prestacion"]="Men&uacute;";
include("encabezado.php");?>
<div class="container">
<h5>Men&uacute; Dep&oacute;sito</h5>
<ul class="list-group list-group-numbered">
	<li class="list-group-item"  style="font-size:1.1em;margin-top:3px margin-bottom:2px;"><strong>Ingresos</strong></li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('ingreso_nuevo')"> Nuevo</li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('ingresos_consulta')"> Consultar</li>
</ul>
<ul class="list-group list-group-numbered">	
	<li class="list-group-item"  style="font-size:1.1em;margin-top:3px margin-bottom:2px;"><strong>Remitos</strong></li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('remitos_nuevo')"> Nuevo</li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('remitos_consulta')"> Consultar</li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('remitos_cns_ef')"> Consultar por efector</li>
	
</ul>
<ul class="list-group list-group-numbered">	
	<li class="list-group-item"  style="font-size:1.1em;margin-top:3px margin-bottom:2px;"><strong>Stocks</strong></li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('cons_stock_total')"> Consultar</li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('cons_stock_movimientos')"> Consultar movimientos de stock</li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('cons_stock_critico')"> Consultar stocks cr&iacute;ticos</li>
	
</ul>
<ul class="list-group list-group-numbered">	
	<li class="list-group-item"  style="font-size:1.1em;margin-top:3px margin-bottom:2px;"><strong>Ajustes</strong></li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('ajustes_nuevo')"> Nuevo ajuste bienes de consumo</li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('ajustes_consulta')"> Consultar</li>
</ul>
<ul class="list-group list-group-numbered">	
	<li class="list-group-item"  style="font-size:1.1em;margin-top:3px margin-bottom:2px;"><strong>Tablas</strong></li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('articulos')"> Art&iacute;culos</li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('rubros')"> Rubros de art&iacute;culos</li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('efectores')"> Efectores</li>
	
</ul>	
<ul class="list-group list-group-numbered">	
	<li class="list-group-item"  style="font-size:1.1em;margin-top:3px margin-bottom:2px;"><strong>Otros</strong></li>
	<li class="list-group-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('version_cambios')"> Cambios en las versiones del m&oacute;dulo</li>
</ul>
<?php include("timer.js");
include("footer.php")?>
</body>