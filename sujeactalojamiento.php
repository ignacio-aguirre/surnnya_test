<?php
include("Funciones.php");
session_start();
$min1=nulea($_GET["min1"]);
$min2=nulea($_GET["min2"]);
$min3=nulea($_GET["min3"]);
$ctx1=nulea($_GET["ctx1"]);
$ctx2=nulea($_GET["ctx2"]);
$ctx3=nulea($_GET["ctx3"]);
$lega=nulea($_GET["legajo"]);
ejecute("update sujetos set ming1=".$min1.", ming2=".$min2.", ming3=".$min3.", ctex1=".$ctx1.", ctex2=".$ctx2.", ctex3=".$ctx3." where legajo=".$lega);
Redirect("suje_cons_alojamiento?legajo=".$lega);
?>