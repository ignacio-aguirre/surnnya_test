<?php
include("Funciones.php"); 
session_start();
$reg=registros("select idsujetos_medidas from sujetos_medidas where envio is null and suspendido=0");
while ($r=mysqli_fetch_assoc($reg)) $a=envia_unamedida($r["idsujetos_medidas"]);
$reg=registros("select idaltasybajas from altasybajas where operacion='A' and nota_derivacion>0 and envio is null and suspendido=0");
while ($r=mysqli_fetch_assoc($reg)) $a=envia_unaderivacion($r["idaltasybajas"]);
ejecute("update procesos set ultimaejecucion=curdate() where proc_url='medidas_enviar'");
Redirect($_SESSION["menu"]."?id=1");
?>
</body>
</html>

