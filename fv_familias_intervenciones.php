<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])){ header ("Location: salir");};
if(isset($_GET["efector"])) $efector=$_GET["efector"];
$desde="";
$hasta="";
if(isset($_GET["desde"])){$desde=$_GET["desde"];};
if(isset($_GET["hasta"])){$hasta=$_GET["hasta"];};
$frase="";
if(isset($_GET["frase"])){$frase=$_GET["frase"];};

?>
<div class="container">
<form class="form-inline" onsubmit="return valida()" action="fv_familias_intervenciones_excel">
 <div class='form-group has-warning'>
  <label class='label-form' for='desde'>Desde</label>
  <input class="form-control" size="10" maxlength="10" name="desde" id="desde" onblur="valida_fecha(this.id)" autofocus value="<?php echo $desde?>">
 </div>&nbsp;&nbsp;
 <div class='form-group has-warning'>
  <label class='label-form' for='hasta'>Hasta</label>
  <input class="form-control" size="10" maxlength="10" name="hasta" id="hasta" onblur="valida_fecha(this.id)" value="<?php echo $hasta?>">
 </div>
 <br><br> 
 <input class="btn-sm btn-success" name="excel" type="submit" value="Excel" />

</form>

<script type="text/javascript">
function valida(){
valida_fecha("desde");
valida_fecha("hasta");
if(document.getElementById("desde").value==""){status("completar fecha desde");return false;};
if(document.getElementById("hasta").value==""){status("completar fecha hasta");return false;};
if(fsql(document.getElementById("hasta").value)<fsql(document.getElementById("desde").value)){status("fecha desde debe ser menor o igual que hasta");return false;};
status("");
return true;
}
</script> 
</body>
</html>