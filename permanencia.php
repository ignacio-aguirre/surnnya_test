<?php
include("Funciones.php");
session_start();
?>
<script type="text/javascript"> 
function valida_datos() {
valida_fecha("desde");
valida_fecha("hasta");
return true;
}

</script>

<?php
if (!isset($_SESSION['gldispo'])) header ("Location: index.php");
registre();
include("encabezado.php");
$hasta="";
$desde="";
if(isset($_GET['hasta'])) {$hasta=$_GET['hasta'];$desde=$_GET['desde'];};
?>
</div>
<div class="container">
<form class="form-inline" method="GET" action="permanencia_excel" onsubmit='return valida_datos()'>
 <div class="form-group has-warning">
  <label class="label-form" for="desde">Fecha Desde</label>
  <input class="form-control" name='desde' id='desde' maxlength='10' size='8' onblur='valida_fecha(this.id)' value='<?php echo $desde;?>'>
  <label class="label-form" for="hasta">Fecha Hasta</label>
  <input class="form-control" name='hasta' id='hasta' maxlength='10' size='8' onblur='valida_fecha(this.id)' value='<?php echo $hasta;?>'>
 <div>  
 <input class="btn-success" type="submit" value="Excel">
</form>

<script type="text/javascript">
enfoca("desde");
</script> 
</div>
</body>
</html>

