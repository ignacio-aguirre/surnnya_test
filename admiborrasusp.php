<?php
include("Funciones.php");
session_start(); 
$_SESSION["prestacion"]="Eliminar Suspensi&oacute;n de Pedido de recurso";
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: .");
registre();
$iid=$_GET["iid"];
$sql="select Apellidos, Nombres, admi_susp, nombre as hogar from hogares_admision left join sujetos on legajo=admi_legajo left join dispositivos on dispositivos.id=admi_hogar where idhogares_admision=".$iid;
$da = un_registro($sql);

if (isset($_GET['submit'])) {

ejecute("update hogares_admision set admi_susp=null, admi_mots=null where idhogares_admision=".$iid);

Redirect("admiconssusp");}

?>

<div class="container">

<form method='get'>

<fieldset class='C400'>

Apellidos: <strong><?php echo $da["Apellidos"];?></strong><br>

Nombres: <strong><?php echo $da["Nombres"];?></strong><br>

Fecha Suspensi&oacute;n:<strong><?php echo ffec($da["admi_susp"]);?></strong><br>

Hogar: <strong><?php echo $da["hogar"];?></strong><br><br>

<input type="hidden" name='iid' value='<?php echo $iid;?>'/>

<input name="submit" id='sub' type="submit" value="Eliminar" />

</fieldset>

</form>

</div>

</body>

</html>