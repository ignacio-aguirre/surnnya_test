<?php 
include("funciones.php");
session_start();
tranca();
if(isset($_GET["status"])) {$_SESSION["status"]=$_GET["status"];Redirect("mn_stock");}
$_SESSION["prestacion"]="Consultas de Stock";
include("encabezado.php"); 
if(isset($_SESSION["status"])) {echo $_SESSION["status"];;$_SESSION["status"]="";};
?>
</div>
<div class="container">
<div class="table-responsive col-sm-6">
<table class="table table-hover">
<tr class="info" onclick=location.href='cons_stock_total'><td>Consultar Stocks</td></tr>
<tr class="info" onclick=location.href='cons_stock_movimientos'><td>Consultar Movimientos de un Art&iacuteculo</td></tr>
<tr class="info" onclick=location.href='cons_stock_critico'><td>Consultar Stocks Cr&iacute;ticos</td></tr>

<?php if($_SESSION["ajus"]==1){echo "<tr class='info' onclick=location.href='ajustes_nuevo'><td>Ajuste de Stock</td></tr>";};
if($_SESSION["ajus"]==1||$_SESSION["deposito"]=="0"){
echo "<tr class='info' onclick=location.href='ajustes_consulta'><td>Consultar Ajustes</td></tr>";};?>
</table>
</div>
</div>
<script src="bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<?php include("timer.js");?>
<input name="dispositivo">
<button>Consultar</button>
<var name="respuesta"></var>
</body>