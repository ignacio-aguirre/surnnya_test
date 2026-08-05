<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Eliminar Pedido de Recurso";
include("encabezado-test.php");?>

<script type="text/javascript">

function valida_campos() {

return confirm("Estas segur@?");

}

</script>

<?php

registre();

if (isset($_GET["retorno"])) {$retorno=$_GET["retorno"];} else $retorno=$_SERVER["HTTP_REFERER"];

$iid=$_GET["iid"];

$sql="select Apellidos, Nombres, admi_fderiv, nombre as hogar from hogares_admision left join sujetos on legajo=admi_legajo left join dispositivos on dispositivos.id=admi_hogar where idhogares_admision=".$iid;

$da = un_registro($sql);

if (isset($_GET['submit'])&&gettype($da['admi_fderiv'])=="NULL"&&gettype($da['admi_alta'])=="NULL") {

ejecute("delete from hogares_admision where idhogares_admision=".$iid);

Redirect($retorno);}

?>

<div class="container">
<h3>Eliminar Pedido de Recurso</h3>
<form method='get' onsubmit='return valida_campos()'>

<fieldset'>

Apellidos: <strong><?php echo $da["Apellidos"];?></strong><br>

Nombres: <strong><?php echo $da["Nombres"];?></strong><br>

Fecha Derivaci&oacute;n:<strong><?php echo ffec($da["admi_fderiv"]);?></strong><br>

Hogar: <strong><?php echo $da["hogar"];?></strong><br><br>

<input type="hidden" name='iid' value='<?php echo $iid;?>'/>

<input type="hidden" name='retorno' value='<?php echo $retorno;?>'/>

<input class="btn-danger" name="submit" id='sub' type="submit" value="Eliminar" />

</fieldset>

</form>

</div>

</body>

</html>