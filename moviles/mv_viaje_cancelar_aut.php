<?php
session_start();
require("funciones.php");
$idges=nget("idges");
$gest=un_registro("select * from movil_gestiones where id=".$idges);
$id=$gest["viaje"];
$v=un_registro("select * from movil_viajes where id=".$id);
$texto=$gest["texto"];


$fecha=ffec($v['fecha']);
$hora=substr($v['hora'],0,5);
$ok=un_campo("select case when ".fsql($fecha)."=curdate() then case when curtime()<".tsql($hora)." then 'ok' else 'nook' end else 'ok' end from dual");



if($ok=="ok"){
    ejecute("update movil_gestiones set usuario_control=".tsql($_SESSION["nusuario"]).",estado='APR' where id=".$idges);
}
else{
    ejecute("update movil_gestiones set usuario_control=".tsql($_SESSION["nusuario"]).",estado='REC' where id=".$idges);
    $_SESSION["msg"]="Viaje no pudo ser cancelado por haberse alcanzado fecha y hora de partida";
    $_SESSION["retorno"]="mv_gestiones";
    Redirect("aviso");
};

$vcan=un_campo("select case when ".fsql($fecha)."=curdate() then case when timediff(".tsql($hora).",curtime())>='02:00' then '0' else '1' end else '0' end from dual");
ejecute("update movil_viajes set estado='CAN', observaciones='Cancelado  gestion ".$idges."', cancelado=".$vcan." where id=".$id);
$cosa=valoriza($id);
Redirect("mv_notif_cancelar?id=".$id);
?>
