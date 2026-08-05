<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Replicar Remito de Entrega";
include("encabezado.php"); 
$rto=un_registro("select * from remitos where numero=".nget("numero"));
$opc_efe=str_replace("'0'","''",opciones('efectores'));
?>
<div class="container">
<form class="form-inline" method="get" action="remitos_replicar_do">
  <input hidden name="id" value="<?php echo $rto['idremitos']?>">
 <div class="form-group has-warning">
  <label class="label-form" for="efector">Efector</label>
  <select class="form-control" id="efector" name="efector" required autofocus>
        <?php echo $opc_efe;?></select>
  <script>seleccionar("efector",'<?php echo $rto["efector"]?>')</script>
  &nbsp;&nbsp;
  <button >Replicar</button>
 </div>   

</form>
</div>

