<?php 
include("funciones.php");
session_start();
tranca();
$id=$_POST["id"];
$apel=tsql($_POST["apellidos"]);
$nomb=tsql($_POST["nombres"]);
$fena=fsql($_POST["fecha_nacimiento"]);
$edad=nulea($_POST["edad"]);
$feed=fsql($_POST["fecha_edad"]);
$tipo=tsql($_POST["tipo_documento"]);
$docu=nulea($_POST["numero_documento"]);
$naci=tsql($_POST["nacionalidad"]);
$juzg=nulea($_POST["juzgado"]);
$expe=tsql($_POST["expediente"]);
$defe=tsql($_POST["defensor"]);
$cdnn=tsql($_POST["cdnnya"]);
$inte=tsql($_POST["intervencion_sj"]);
$tom=$_POST["tom"];

$hosp=nulea($_POST["hospital"]);
$log_accion="Editar Caso";
if($id==0) {
 $log_accion="Nuevo Caso";
 $id=inserte("insert into casos (apellidos,nombres,nacionalidad) values(".$apel.",".$nomb.",".$naci.")");
 inserte("insert into casos_log(caso,fecha,estado) values(".$id.",curdate(),1)");
};
loguea($log_accion,$id,"0");
ejecute("update casos set apellidos=".$apel.", nombres=".$nomb.", fecha_nacimiento=".$fena.", edad=".$edad.", fecha_edad=".$feed.", tipo_documento=".$tipo.", numero_documento=".$docu.", nacionalidad=".$naci." where idcasos=".$id);
ejecute("update casos set juzgado=".$juzg.", expediente=".$expe.", defensor=".$defe.", cdnnya=".$cdnn.", intervencion_sj=".$inte." where idcasos=".$id);
ejecute("update casos set tom=".$tom." where idcasos=".$id);
ejecute("update casos set hospital_sugerido=".$hosp." where idcasos=".$id);
Redirect("casos");
?>