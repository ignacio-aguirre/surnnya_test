<?php
include("Funciones.php"); 
session_start();
$reg=registros("select idaltasybajas from altasybajas where nota>0 and envio_notaaltabaja is null and year(fecha_operacion)>=2024");
while ($r=mysqli_fetch_assoc($reg)) $a=envia_unanota($r["idaltasybajas"]);
ejecute("update procesos set ultimaejecucion=curdate() where proc_url='altasbajas_enviar'");
Redirect($_SESSION["menu"]."?id=1");
?>
</body>
</html>

