<?php
require("Funciones.php");
session_start();
$tipo=$_GET["tipo"];


if($tipo=="BUSQUEDA_H5"){
 $frase=gtsql("frase");
 $sql=buscadorh5($frase);

 $reg=registros($sql);
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr onclick='navega(".'"sujeact_PIN?legajo='.$r["legajo"].'"'.")'><td>".$r["legajo"]."</td><td>".$r["apellidos"].", ".$r["nombres"]."</td><td>".$r["edad_c"]."</td><td>".$r["hoga"]."</td><td>".un_campo("select descripcion from salud_establecimientos where idsalud_establecimientos=".nulea($r["hospital_cual"]))."</td></tr>";
 };
};

if($tipo=="PIN_JURIDICOS"){
 $legajo=nget("lega");
 $defensoria_zonal=nget("dezo");
 $juzgado_modalidad=nget("jumo");
 $juzgado_numero=nget("junu");
 $defensoria_nacional=nget("dena");
 $defensor_nombre=tget("deno");
 ejecute("update sujetos set defensoria_zonal=".$defensoria_zonal." where legajo=".$legajo);
 ejecute("update sujetos_juridicos set juzgado_modalidad=".$juzgado_modalidad.
 ", juzgado_numero=".$juzgado_numero.", defensoria_nacional=".$defensoria_nacional.", defensor_nombre=".$defensor_nombre. "where legajo=".$legajo);
 
};
if($tipo=="PIN1"){
 $legajo=nget("lega");
 $edad_gestacional=nget("eges");
 $edad_corregida=nget("ecor");
 $hospital=nget("hosp");
 $hospital_cual=nget("hcua");
 $hospital_ingreso=fget("hing");
 $ah_asignado=nget("ahas");
 $ah_cual=tget("ahcu");
 $ah_fecha=fget("ahfe");
 ejecute("update sujetos_neonatal set edad_gestacional=".$edad_gestacional.", edad_corregida=".$edad_corregida.
 ", hospital=".$hospital.", hospital_cual=".$hospital_cual.", hospital_ingreso=".$hospital_ingreso.
 ", ah_asignado=".$ah_asignado.", ah_cual=".$ah_cual.", ah_fecha=".$ah_fecha." where legajo=".$legajo); 
};
if($tipo=="PIN2"){
 $legajo=nget("lega");
 $situacion_social=tget("ssoc");
 $progenitores_presentes=nget("ppre");
 $referentes_presentes=nget("rpre");
 $referentes_cual=tget("rpcu");
 $edad_madre=nget("emad");
 $controles_prenatales=nget("cpre");
 $sit_salud_madre=tget("ssma");
 $residencia_madre=nget("rema");
 $origen_madre=nget("orma");
 $contactos_intervinientes=tget("cint");
 $peso=tget("peso");
 $talla=tget("tall");
 $diagnostico=tget("diag");
 $alta_hospitalaria=nget("ahos");
 $alta_hospitalaria_fecha=fget("alhf");
 ejecute("update sujetos_neonatal set situacion_social=".$situacion_social.", progenitores_presentes=".$progenitores_presentes.", referentes_presentes=".$referentes_presentes.
 ", referentes_cual=".$referentes_cual.", edad_madre=".$edad_madre.", controles_prenatales=".$controles_prenatales.", sit_salud_madre=".$sit_salud_madre.
 ", residencia_madre=".$residencia_madre.", origen_madre=".$origen_madre.", contactos_intervinientes=".$contactos_intervinientes.", peso=".$peso.", talla=".$talla.
 ", diagnostico=".$diagnostico.", alta_hospitalaria=".$alta_hospitalaria.", alta_hospitalaria_fecha=".$alta_hospitalaria_fecha." where legajo=".$legajo); 
};
if($tipo=="PIN3"){
 $legajo=nget("lega");
 $datos_perinatales=nget("dper"); 
 $datos_cual=tget("dpcu"); 
 $serologia=nget("sero"); 
 $serologia_cual=tget("secu"); 
 $sindrome_abstinencia=nget("sind"); 
 $sindrome_cual=tget("sicu"); 
 $eco_cerebral=nget("ecer"); 
 $e_cerebral_cual=tget("eccu"); 
 $ppn=nget("ppnn"); 
 $ppn_cual=tget("ppcu"); 
 $test_acustico=nget("test"); 
 $test_cual=tget("tecu"); 
 $fondo_ojos=nget("fond"); 
 $fondo_cual=tget("focu"); 
 $vacunas=nget("vacu"); 
 $vacunas_cual=tget("vacc"); 
 $eco_cardio=nget("ecar"); 
 $e_cardio_cual=tget("ecac"); 
 $eco_caderas=nget("ecad"); 
 $e_caderas_cual=tget("ecdc"); 
 $otros=nget("otro"); 
 $otros_cual=tget("otcu"); 
 ejecute("update sujetos_neonatal set datos_perinatales=".$datos_perinatales.", datos_cual=".$datos_cual.", serologia=".$serologia.
  ", serologia_cual=".$serologia_cual.", sindrome_abstinencia=".$sindrome_abstinencia.", sindrome_cual=".$sindrome_cual.
  ", eco_cerebral=".$eco_cerebral.", e_cerebral_cual=".$e_cerebral_cual.", ppn=".$ppn.", ppn_cual=".$ppn_cual.", test_acustico=".$test_acustico.
  ", test_cual=".$test_cual.", fondo_ojos=".$fondo_ojos.", fondo_cual=".$fondo_cual.", vacunas=".$vacunas.", vacunas_cual=".$vacunas_cual.
  ", eco_cardio=".$eco_cardio.", e_cardio_cual=".$e_cardio_cual.", eco_caderas=".$eco_caderas.", e_caderas_cual=".$e_caderas_cual.
  ", otros=".$otros.", otros_cual=".$otros_cual.", fecha_actualizacion=curdate() where legajo=".$legajo);
};

function gtsql($t){
return tget($t);
}

function gfsql($t){
return fget($t);
}

function gnsql($t){
return nget($t);
}
function buscadorh5($frase) {
 $sql="select sujetos.legajo, apellidos, nombres, edadcalc(f_nacimiento,SujetosEdad,SujetosMeses,SujetosActEdad,null) as edad_c,  Fecha_Nacimiento, (select nombre from hogares_admision left join dispositivos on admi_hogar=dispositivos.id where sujetos.legajo=admi_legajo and admi_alta is not null and admi_baja is null) as hoga, hospital_cual from sujetos ";
 $sql=$sql." left join sujetos_neonatal on sujetos.legajo=sujetos_neonatal.legajo where (sujetos.cerrado=0 ";
 if(intval($frase)!=0) {$sql=$sql." and (sujetos.legajo=".$frase." or sujetosDNI=".$frase.") ";}
 else {
 $salida=array();
 $palabras=parsea($frase);
 foreach ($palabras as &$palabra) {
    $da = un_registro("select lex_sonido('".$palabra."') as son");
    $sql=$sql." and sonidos like '%".$da['son']."%' ";
 };
 $sql=$sql.") having edad_c<5 order by apellidos, nombres";
 };
 return  $sql;
}


?>
