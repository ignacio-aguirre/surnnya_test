<?php 
include("funciones.php");
session_start();
$trimestral=nget("id");
$tri=un_registro("select * from trimestrales where id=".$trimestral);
$nnya=$tri["legajo"];
$trimestre=$tri["trimestre"];
$anio=$tri["anio"];
$hogar=$tri["hogar"];
$dni=nget("dni");
if(un_campo("select dni from usuarios_hogares where baja is null and id=".$_SESSION["usuario"])==$dni){
 $id=un_campo("select id from trim_firmas where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya." and usuario=".$_SESSION["usuario"]);
 if(!$id>0) {inserte("insert into trim_firmas(anio,trimestre,hogar,legajo,usuario,fecha,trimestral) values(".$anio.",".$trimestre.",".$hogar.",".$nnya.",".$_SESSION["usuario"].",curdate(),".$trimestral.")");};
 Redirect("informes");
}
else{
 echo "DNI incorrecto. Presiona (atras) para reintentar o volver al menu";
};
?>