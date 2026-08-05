<?php
session_start();
require("funciones.php"); 
$id=nget("id");
$v=un_registro("select * from movil_viajes where id=".$id);
$texto=tget("texto");

if($v["dispositivo"]>"0"){$dispositivo=$v["dispositivo"];
  $tipo_dispositivo="Dispositivo";
   if($_SESSION["perfil_moviles"]=="1" && $dispositivo!=$v["dispositivo"]){    Redirect("salir");};
};
if($v["sector"]>"0"){$dispositivo=$v["sector"];
   $tipo_dispositivo="Sector";
   if($_SESSION["perfil_moviles"]=="1" && $dispositivo!=$v["sector"]){    Redirect("salir");};
};

$fecha=ffec($v['fecha']);
$hora=substr($v['hora'],0,5);
$ok=un_campo("select case when ".fsql($fecha)."=curdate() then case when curtime()<".tsql($hora)." then 'ok' else 'nook' end else 'ok' end from dual");
$idges=inserte("insert into movil_gestiones (dispositivo,viaje,tipo_gestion,estado,usuario,texto) values(".$dispositivo.", ".$id.",'Cancelar','SOL',".tsql($_SESSION['nusuario']).",".$texto.")");


if($ok=="ok"){

    if($v["bandeja"]<"7"){
        ejecute("update movil_viajes set estado='CAN', observaciones='Cancelado gestion ".$idges."',bandeja=90, valor_calculado=0, sg=0, gestion=".$idges." where id=".$v["id"]);
        ejecute("update movil_gestiones set estado='APR' where id=".$idges);
        $_SESSION["msg"]="Viaje cancelado";
        $_SESSION["retorno"]="menu_gestiones";
        Redirect("aviso");
    }

    // bandeja 7
    $okhora=un_campo("select case when ".fsql($fecha)."=curdate() then case when timediff(".tsql($hora).",curtime())>='02:00' then 'ok' else 'no' end else 'ok' end from dual");

    if($okhora=="ok'"){
        ejecute("update movil_viajes set estado='CAN', observaciones='Cancelado  gestion ".$idges."', bandeja=90, cancelado=0, valor_calculado=0, sg=0, gestion=".$idges." where id=".$id);
            ejecute("update movil_gestiones set estado='APR' where id=".$idges);
            Redirect("mv_notif_cancelar?id=".$id);
    }
    else{
        ejecute("update movil_viajes set gestion=".$idges." where id=".$id);
        $_SESSION["msg"]="Cancelación a autorizar";
        $_SESSION["retorno"]="mv_viajes_cancelar";
        Redirect("aviso");
    }

    }
    else{
        
        ejecute("update movil_gestiones set estado='REC' where id=".$idges);
        $_SESSION["msg"]="Viaje no pudo ser cancelado por haberse alcanzado fecha y hora de partida";    
        $_SESSION["retorno"]="mv_viajes_cancelar";
        Redirect("aviso");
    }
?>
