<?php
session_start();
include("Funciones.php");
$dni=nget("dni");
$apellidos=tget("apel");
$nombres=tget("nomb");
$lega=un_campo("select max(legajo)+1 from sujetos");
inserte("insert into sujetos(legajo,apellidos,nombres,sujetosdni,tipodni) values(".$lega.",".$apellidos.",".$nombres.",".$dni.",1)");
ejecute("update sujetos set sonidos=concat(lex_sonido(apellidos),' ',lex_sonido(nombres)) where legajo=".$lega);
echo $lega;
exit;
?>