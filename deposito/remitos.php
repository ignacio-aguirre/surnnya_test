<?php 
include("funciones.php");
session_start();
tranca();
$_SESSION["prestacion"]="Remitos de Entrega";
include("encabezado.php"); 
?>
</div>
<div class="container">
<div class="table-responsive col-sm-6">
<table class="table table-hover">
<tr class="info" onclick=location.href="remitos_consulta"><td>Consultar Remitos de Entrega</td></tr>
<?php if($_SESSION["remi"]==1) echo '<tr class="info" onclick=location.href="remitos_nuevo"><td>Remitos de Entrega:Nuevo</td></tr>';?>
<tr class="info" onclick=location.href="cons_entregas_efectores"><td>Consultar Entregas a Efectores</td></tr>
<tr class="info" onclick=location.href="cons_entregas_efectores_mensual"><td>Consultar Entregas Mensuales Puntual</td></tr>
<tr class="info" onclick=location.href="cons_entregas_efectores_mensual_global"><td>Consultar Entregas Mensuales Global </td></tr>
</table>
</div>
</div>
<?php include("timer_remitos.js");
echo "<script>";
$reg=registros("select numero from remitos left join comprobantes on comprobante=idcomprobantes where impreso=0 and deposito=".$_SESSION["deposito"]." limit 1");
while($r=mysqli_fetch_assoc($reg)){
 echo "navega('remito_imprimir?numero=".$r["numero"]."');";
};
echo "</script>";

?>
</body>