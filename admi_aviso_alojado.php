<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Aviso de alojamiento previo";
include("encabezado-test.php");
$s=un_registro("select legajo,apellidos,nombres from sujetos where legajo=".$_GET["legajo"]);
$dispositivo=un_campo("select nombre from hogares_admision left join dispositivos on admi_hogar=dispositivos.id where admi_legajo=".$s["legajo"]." and admi_alta is not null and admi_baja is null");
?>
<div class="container">
<h2>Atenci&oacute;n</h2>
La suspensi&oacute;n del pedido de recurso ha sido procesada, pero se ha detectado que <?php echo $s["apellidos"].", ".$s["nombres"]." est&aacute; actualmente en el hogar ".$dispositivo;?>
<br>
Si corresponde, no olvides procesar el egreso de ese hogar.

</div>
</html>