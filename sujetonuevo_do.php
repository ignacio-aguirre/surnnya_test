<?php
session_start();
include("Funciones.php");
$apellidos=tget("apellidos");
$nombres=tget("nombres");
$sexo=tget("sexo");
$td="";
$nd="";
if(isset($_GET["td"])){
 $td=nget("td");
 $nd=nget("nd");
};
$ra="";
$rn="";
$rr="";
if(isset($_GET["ra"])){
 $ra=nget("ra");
 $rn=nget("rn");
 $rr=tget("rr");
};
$fn="";
$ed="";
if(isset($_GET["fn"])){
 $fn=fget("fn");
}
else{
 $ed=nget("ed"); 
};
$legajo=crea_sujeto();
registro_rapido("Legajo Nuevo ".$legajo);
ejecute("update sujetos set apellidos=".$apellidos.", nombres=".$nombres.",sexo=".$sexo." where legajo=".$legajo);
if($td!=""){ejecute("update sujetos set tipodni=".$td.", sujetosdni=".$nd." where legajo=".$legajo);};
if($ra!=""){ejecute("update sujetos set rib_anio=".$ra.", rib_numero=".$rn.", rib_reparticion=".$rr." where legajo=".$legajo);};
if($fn!=""){ejecute("update sujetos set f_nacimiento=".$fn." where legajo=".$legajo);};
if($ed!=""){ejecute("update sujetos set sujetosedad=".$ed.",sujetosactedad=curdate() where legajo=".$legajo);};
ejecute("update sujetos set sonidos=concat(lex_sonido(Apellidos),' ',lex_sonido(Nombres),' ',case when Apodos is null then '' else lex_sonido(Apodos) end) where sonidos is null");
Redirect("sujeactidentidad?legajo=".$legajo);
?>