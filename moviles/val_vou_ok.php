<?php
include("funciones.php"); 
session_start();
$id=nget("id");
$cv=nget("cv");
$kv=nget("kv");
$ev=tget("ev");
ejecute("update movil_viajes set conciliado=1, cumplido_voucher=".$cv.", km_voucher=".$kv.", espera_voucher=".$ev." where id=".$id);
echo compara($id);
exit();
?>