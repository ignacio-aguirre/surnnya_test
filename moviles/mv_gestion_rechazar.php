<?php
session_start();
require("funciones.php"); 
$idges=nget("idges");
$via=un_registro("select * from movil_viajes where gestion=".$idges);
ejecute("update movil_gestiones set estado='REC' where id=".$idges);
if($via["id"]>"0" && $via["bandeja"]=="80"){
	ejecute("update movil_viajes set bandeja=90 , estado='REC' where id=".$via["id"]);
}
Redirect("mv_gestiones");
?>