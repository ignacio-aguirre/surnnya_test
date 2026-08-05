<?php
include("funciones.php");
session_start();
$id=nget("id");
$tri=un_registro("select * from trimestrales where id=".$id);
$anio=$tri["anio"];
$trimestre=$tri["trimestre"];
$legajo=$tri["legajo"];
$legajo_surnnya=$tri["legajo_surnnya"];
$m_fin=$trimestre*3;
if($m_fin==6 || $m_fin==9){$d_fin="30";} else {$d_fin="31";};
$m_fin=(string) $m_fin;
$fact=$anio.substr("0".$m_fin,-2).substr("0".$d_fin,-2);
$edad=un_campo("select edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,".$fact.") from sujetos where legajo=".$legajo_surnnya);
$_SESSION["edad"]=$edad;

$hogar=$tri["hogar"];
$logo=un_campo("select as_path from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where as_tipo=200 and tipo='H' and identificador='".$hogar."'");
$nin=un_registro("select * from alojados where idalojados=".$legajo);
$hog=un_registro("select * from dispositivos where id=".$hogar);
$ide=un_registro("select * from trim_identidad where trimestral=".$id);
$jur=un_registro("select * from trim_juridicos where trimestral=".$id);
$saf=un_registro("select * from trim_salud_fisica where trimestral=".$id);
$sam=un_registro("select * from trim_salud_mental where trimestral=".$id);
$dis=un_registro("select * from trim_discapacidad where trimestral=".$id);
$edu=un_registro("select * from trim_educacion where trimestral=".$id);
$tra=un_registro("select * from trim_trayectos where trimestral=".$id);
$act=un_registro("select * from trim_actividades where trimestral=".$id);
$vin=un_registro("select * from trim_vinculaciones where trimestral=".$id);
$egr=un_registro("select * from trim_egreso where trimestral=".$id);
$est=un_registro("select * from trim_estrategias where trimestral=".$id);
$ri=un_registro("select * from sujetos where legajo=".$legajo_surnnya);
$rib=rib2($ri);
$fecha_informe=ffec($ide["fecha"]);
$dias_alojado=un_campo("select datediff(".fsql($fecha_informe).",admi_alta) from hogares_admision where admi_hogar=".$hogar." and admi_legajo=".$legajo_surnnya." and admi_alta is not null order by admi_alta desc limit 1");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Informe Trimestral</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<style type="text/css">
		<header>,div {
			display: flex;
			flex-direction: column;
			align-items: flex-end;
			font-size: 1.2em;
		}
		h1 {
			font-size: 1.2em;
		}
		h3 {
			font-size: 1.5em;
		}
		ul {
			list-style: none;
		}
		li, p {
			letter-spacing: 0.10em;
			text-align: justify;
		}
		span {
			margin: 0 0.5rem;
			font-weight: 550;
		}
	</style>
</head>
<body class="container">
<script>
function imprimir(){
  document.getElementById("bi").style.visibility="collapse";
  window.print();
  document.getElementById("bi").style.visibility="visible";

}
</script>

	<header class="text-center">
		<img src="/surnnya/<?php echo $logo?>" heigth="200" width="200" alt="Logo de la institucion">
		<h2 class=""><?php echo $hog["nombre"]?></h2>
		<div>
			<h1>Informe trimestral</h1>
			<p>Periodo: <span>Trimestre <?php echo $tri["trimestre"]." / ".$tri["anio"]?></span></p>
			<p>Fecha de elaboraci&oacuten: <span><?php echo $fecha_informe?></span></p>
		</div>
	</header>
	<main>
		<?php if(intval($dias_alojado)<30){echo "<p><i>Este informe se elabora sin contar con 30 d&iacute;as de alojamiento en el dispositivo de cuidado</i></p>";};?>
		<section>
			<h3>Identidad y datos generales</h3>
			<ul class="list-group">
				<li class="list-group-item text-primary">RIB: <span><strong><?php echo $rib?></strong></li>
				<li class="list-group-item text-primary">Apellidos: <span><strong><?php echo $nin["apellidos"]?></strong>
</span> Nombres: <span><strong><?php echo $nin["nombres"]?></strong></span> Fecha de Nacimiento: <span><strong><?php echo ffec($nin["nacimiento"])?></strong></span></li>
<?php echo item_sinoblanco("Otros nombres a los que responde",$ide["otros_nombres"]);
$campo1=un_campo("select descripcion from paises where idpaises=".nulea($ide["pais_nacimiento"]));
$campo2=un_campo("select descripcion from provincias where idprovincias=".nulea($ide["provincia_nacimiento"])); 
if($campo1!=""||$campo2!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Nacimiento Pa&iacute;s",$campo1)." ".parte_sinoblanco("Provincia",$campo2)."</li>";
 };
$campo1=un_campo("select descripcion from paises where idpaises=".nulea($ide["pais_ultresfam"]));
$campo2=$ide["provincia_ultresfam"];
$campo3=$ide["partido_ultresfam"];
$campo4=$ide["localidad_ultresfam"];
$campo5=$ide["barrio_ultresfam"];
$nombre="x";
if($campo1!="Argentina") {$nombre=($campo4!="" ? $campo4.", " :"").$campo1;}
else if($campo2==""){$nombre="";}
else{
   if($campo2=="CABA"){$nombre="CABA".($campo5!="" ? ", ".$campo5:"");}
   else{
     if($campo3!="") {$nombre=$campo4.", Pdo. ".$campo3;}
    else {$nombre=($campo4!="" ? $campo4.", ":"")."Pcia. de ".$campo2;}
   }
};
if($nombre!=""){echo "<li class='list-group-item'>".parte_sinoblanco("&Uacute;lt. Residencia Familiar ",$nombre)."</li>";};

$campo1=un_campo("select descripcion from paises where idpaises=".nulea($ide["pais_origenfam"]));
$campo2=un_campo("select descripcion from provincias where idprovincias=".nulea($ide["provincia_origenfam"]));

if($campo1!=""||$campo2!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Origen Familiar Pa&iacute;s",$campo1)." ".
parte_sinoblanco("Provincia",$campo2)."</li>";};?>
<?php echo item_sinoblanco("Id. de G&eacute;nero",d_t("GENERO",$ide["identidad_genero"]))?>
</li>
<li class="list-group-item">
<?php echo parte_sinoblanco("Tiene Partida de Nacimiento",snb($ide["partida"]))." ".
parte_sinoblanco("Partida de nacimiento en el hogar",snb($ide["partida_ubicacion"]))." ".
parte_sinoblanco("Posee Documento de Identidad",snb($ide["documento_posee"]))?>
</li>
<li class="list-group-item">
<?php echo parte_sinoblanco("Tipo de Documento",d_t("TD",$ide["documento_tipo"]))." ".
parte_sinoblanco("N&uacute;mero de Documento",$ide["documento_numero"])." ".
parte_sinoblanco("Ubicaci&oacute;n F&iacute;sica",d_t("UBICACION",$ide["documento_ubicacion"]))?>
</li>
<?php echo item_sinoblanco("Informaci&oacute;n de referentes familiares y/o comunitarios",$ide["informacion_familiar"]);?>

</ul>
		</section>
		<section>
			<h3>Situaci&oacute;n administrativa / legal</h3>
			<ul class="list-group">
				
<?php
$campo1=d_t("DZ",$jur["defensoria_zonal"]);
$campo2=d_t("ZP",$jur["zona_provincial"]);
if($campo1!=""||$campo2!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Defensor&iacute;a CDNNyA",$campo1)." ".parte_sinoblanco("Zonal/Local PBA",$campo2)."</li>";
};
$campo1=$jur["juzgado_civil"];
$campo2=d_t("TJ",$jur["juzgado_otro"]);
$campo3=$jur["juzgado_otro_q"];
if($campo1!=""||$campo2!=""||$campo3!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Juzgado Civil",$campo1)." ".parte_sinoblanco("Otro Juzgado",$campo2)." ".parte_sinoblanco("Detallar",$campo3)."</li>";
};
$campo1=d_n($jur["defensoria_nacional"],"");
$campo2=$jur["defensor"];
if($campo1!=""||$campo2!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Defensor&iacute;a Nacional",$campo1)." ".parte_sinoblanco("Defensor",$campo2)."</li>";
};
$campo1=d_n($jur["tutoria"],"");
$campo2=$jur["tutor"];
if($campo1!=""||$campo2!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Tutor&iacute;a",$campo1)." ".parte_sinoblanco("Tutor",$campo2)."</li>";
};
$campo1=snb($jur["abogado_ninio"]);
$campo2=$jur["abogado"];
$campo3=d_t("ANP",$jur["pertenencia"]);
if($campo1!=""||$campo2!=""||$campo3!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Abogado del ni&ntilde;o",$campo1)." ".parte_sinoblanco("Abogado",$campo2)." ".parte_sinoblanco("Pertenencia",$campo3)."</li>";
};
echo item_sinoblanco("Adoptabilidad Decretada",snb($jur["ad_decretada"]));
$campo1=snb($jur["guardas_fallidas"]);
$campo2=ffec($jur["guardas_fult_vinculacion"]);
if($campo1!=""||$campo2!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Tuvo vinculaciones para Guardas Preadoptivas fallidas",$campo1)." ".
parte_sinoblanco("Fecha &Uacute;ltima vinculaci&oacute;n para Guarda Preadoptiva fallida",$campo2)."</li>";
};
$campo1=snb($jur["medida_excepcional"]);
$campo2=snb($jur["medida_cautelar"]);
if($campo1!=""||$campo2!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Medida Excepcional Vigente",$campo1)." ".parte_sinoblanco("Medida Cautelar de Alojamiento",$campo2)."</li>";
};

?>
  			</ul>
		</section>
		<section>
			<h3>Situaci&oacute;n al ingreso</h3>
			<p class="list-group-item">Descripci&oacute;n: <span><?php echo renglonar(un_campo("select descripcion from trim_ingreso where trimestral=".$id))?></span></p>
		</section>
		<section>
			<h3>Situaci&oacute;n de la vida cotidiana / Aspectos convivenciales</h3>
			<p class="list-group-item">Descripci&oacute;n: <span><?php echo renglonar(un_campo("select descripcion from trim_convivencial where trimestral=".$id))?></span></p>
		</section>
		<section>
			<h3>Vinculaciones familiares o comunitarias</h3>
			<ul class="list-group">
<?php
echo item_sinoblanco("Tuvo vinculaciones en el trimestre",snb($vin["vin_tuvo"]));
$campo1=d_t("VQUI",$vin["vin_quien"]);
$campo2=d_t("VFRE",$vin["vin_frecuencia"]);
$campo3=d_t("VLUG",$se2["vin_lugar"]);
if($campo1!=""||$campo2!=""||$campo3!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Con qu&iacute;enes",$campo1)." ".parte_sinoblanco("Frecuencia",$campo2)." ".parte_sinoblanco("Lugar",$campo3)."</li>";
};
$campo1=d_t("VQUI",$vin["vin_quien2"]);
$campo2=d_t("VFRE",$vin["vin_frecuencia2"]);
$campo3=d_t("VLUG",$se2["vin_lugar2"]);
if($campo1!=""||$campo2!=""||$campo3!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Con qu&iacute;enes",$campo1)." ".parte_sinoblanco("Frecuencia",$campo2)." ".parte_sinoblanco("Lugar",$campo3)."</li>";
};
$campo1=d_t("VQUI",$vin["vin_quien3"]);
$campo2=d_t("VFRE",$vin["vin_frecuencia3"]);
$campo3=d_t("VLUG",$se2["vin_lugar3"]);
if($campo1!=""||$campo2!=""||$campo3!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Con qu&iacute;enes",$campo1)." ".parte_sinoblanco("Frecuencia",$campo2)." ".parte_sinoblanco("Lugar",$campo3)."</li>";
};
$campo1=d_t("VQUI",$vin["vin_quien4"]);
$campo2=d_t("VFRE",$vin["vin_frecuencia4"]);
$campo3=d_t("VLUG",$se2["vin_lugar4"]);

if($campo1!=""||$campo2!=""||$campo3!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Con qu&iacute;enes",$campo1)." ".parte_sinoblanco("Frecuencia",$campo2)." ".parte_sinoblanco("Lugar",$campo3)."</li>";
};
echo item_sinoblanco("Con referentes programa Abrazar",snb($vin["vin_abrazar"]));
echo item_sinoblanco("Descripci&oacute;n",renglonar($vin["vin_observaciones"]));
?>
		</section>
		<section>
<h3>Salud Integral</h3>
			<h4>Salud f&iacute;sica</h4>
			<ul class="list-group">
<?php
$campo1=snb($saf["en_tratamiento"]);
$campo2=snb($saf["obra_social"]);
if($campo1!=""||$campo2!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Tuvo atenci&oacute;n m&eacute;dica en el trimestre",$campo1)." ".parte_sinoblanco("Afiliado a Obra Social",$campo2)."</li>";
};
$campo1=si($saf["juris_ef1"]<"1","",d_t(si($saf["juris_ef1"]=="1","ESAC","ESAB"),$saf["ef_1"]));
$campo2=si($saf["juris_ef2"]<"1","",d_t(si($saf["juris_ef2"]=="1","ESAC","ESAB"),$saf["ef_2"]));
$campo3=si($saf["juris_ef3"]<"1","",d_t(si($saf["juris_ef3"]=="1","ESAC","ESAB"),$saf["ef_3"]));
if($campo1!=""||$campo2!=""||$campo3!=""){
 echo "<li class='list-group-item'>Efectores de Salud</li>";
 echo "<li class='list-group-item'>".parte_sinoblanco("1",$campo1)." ".parte_sinoblanco("2",$campo2)." ".parte_sinoblanco("3",$campo3)."</li>";
};
$campo1=d_t("ESPEC",$saf["especialidad_1"]);
$campo2=d_t("ESPEC",$saf["especialidad_2"]);
$campo3=d_t("ESPEC",$saf["especialidad_3"]);
$campo4=d_t("ESPEC",$saf["especialidad_4"]);
if($campo1!=""||$campo2!=""||$campo3!=""||$campo4!=""){
 echo "<li class='list-group-item'>Especialidades Consultadas</li>";
 if($campo1!="") echo item_sinoblanco("1",$campo1);
 if($campo2!="") echo item_sinoblanco("2",$campo2);
 if($campo3!="") echo item_sinoblanco("3",$campo3); 
 if($campo4!="") echo item_sinoblanco("4",$campo4);
};
$campo1=si($saf["juris_odonto"]<"1","",d_t(si($saf["juris_odonto"]=="1","ESAC","ESAB"),$saf["ef_odonto"]));
$campo2=$saf["obse_odonto"];
if($campo1!=""||$campo2!=""){
  echo "<li class='list-group-item'>".parte_sinoblanco("Odontolog&iacute;a Efector",$campo1)." ".parte_sinoblanco("Tratamiento",$campo2)."</li>";
};
$campo1=snb($saf["calendario_vacunacion"]);
$campo2=snb($saf["internacion"]);
if($campo1!=""||$campo2!=""){
 echo "<li class='list-group-item'>".parte_sinoblanco("Calendario vacunaci&oacute;n actualizado",$campo1)." ".parte_sinoblanco("Internaci&oacute;n",$campo2)."</li>";
};
$campo1=$saf["sf_observaciones"];
echo item_sinoblanco("Descripci&oacute;n de la situaci&oacute;n de salud durante el per&iacute;odo",$campo1);
?>
			</ul>
		</section>
		<section>
			<h4>Salud mental</h4>
			<ul class="list-group">

<?php 
echo item_sinoblanco("Realiz&oacute; tratamiento durante el trimestre",snb($sam["en_tratamiento"]));
$campo1=si($sam["juris_em1"]<"1","",d_t(si($sam["juris_em1"]=="1","ESMEN","ESAB"),$sam["em_1"]));
$campo2=si($sam["juris_em2"]<"1","",d_t(si($sam["juris_em2"]=="1","ESMEN","ESAB"),$sam["em_2"]));
$campo3=si($sam["juris_em3"]<"1","",d_t(si($sam["juris_em3"]=="1","ESMEN","ESAB"),$sam["em_3"]));
$campo4=si($sam["juris_em4"]<"1","",d_t(si($sam["juris_em4"]=="1","ESMEN","ESAB"),$sam["em_3"]));
$campo5=$sam["pm_1"];
$campo6=$sam["pm_2"];
$campo7=$sam["pm_3"];
$campo8=$sam["pm_4"];
if($campo1!=""||$campo2!=""||$campo3!=""||$campo4!=""){
 echo "<li class='list-group-item'>Efectores y Profesionales</li>";
 echo "<li class='list-group-item'>".parte_sinoblanco("1",$campo1).parte_sinoblanco("",$campo5)." ".
parte_sinoblanco("2",$campo2).parte_sinoblanco("",$campo6)." ".parte_sinoblanco("3",$campo3).parte_sinoblanco("",$campo7)." ".parte_sinoblanco("4",$campo4).parte_sinoblanco("",$campo8)."</li>";
};
$campo1=d_t("ESPSM",$sam["espec_sm1"]);
$campo2=d_t("ESPSM",$sam["espec_sm2"]);
$campo3=d_t("ESPSM",$sam["espec_sm3"]);
$campo4=d_t("ESPSM",$sam["espec_sm4"]);
if($campo1!=""||$campo2!=""||$campo3!=""||$campo4!=""){
 echo "<li class='list-group-item'>Especialidades</li>";
 echo "<li class='list-group-item'>".parte_sinoblanco("1",$campo1)." ".parte_sinoblanco("2",$campo2)." ".parte_sinoblanco("3",$campo3)." ".parte_sinoblanco("4",$campo4)."</li>";
};
echo item_sinoblanco("Internaci&oacute;n",snb($sam["sm_internacion"]));
echo item_sinoblanco("Tiene plan de medicaci&oacute;n",snb($sam["plan_medicacion"]));
echo item_sinoblanco("&Uacute;ltimo plan",$sam["plan_detalle"]);
$med="";
if($sam["plan_efector"]=="1") $med=$sam["pm_1"];
if($sam["plan_efector"]=="2") $med=$sam["pm_2"];
if($sam["plan_efector"]=="3") $med=$sam["pm_3"];
if($sam["plan_efector"]=="4") $med=$sam["pm_4"];
echo item_sinoblanco("M&eacute;dico control psicofarmacol&oacute;gico",$med);
echo item_sinoblanco("Descripci&oacute;n de la situaci&oacute;n de salud mental durante el per&iacute;odo",$sam["sm_observaciones"]);
$campo1=$sam["at_tuvo"];
if($campo1>"0"){
 echo "<li class='list-group-item'>Tuvo acompa&ntilde;amiento terap&eacute;utico durante el trimestre</li>";
 echo item_sinoblanco("Prestador",d_t("ATPSM",$sam["at_prestador"]));
 echo item_sinoblanco("Esquema de d&iacute;as y horarios",$sam["at_esquema"]);
 
}
?>
			</ul>
		</section>
		<section>

			
<?php
$campo1=d_t("DIS_TIPO",$dis["tipo_discapacidad"]);
if($campo1!=""){echo "<h3>Necesidades de apoyo por discapacidades</h3><ul class='list-group'>";
$campo2=snb($dis["certificado_discapacidad"]);
$campo3=ffec($dis["cd_vencimiento"]);
if($campo1!=""||$campo2!=""||$campo3!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Tipo de discapacidad",$campo1)." ".parte_sinoblanco("C.U.D",$campo2)." ".parte_sinoblanco("Fecha de vencimiento C.U.D",$campo3)."</li>";
};
$campo1=$dis["cd_diagnostico"];
echo item_sinoblanco("Diagn&oacute;stico",$campo1);
$campo1=$dis["cd_prestaciones"];
echo item_sinoblanco("Orientaci&oacute;n prestacional",$campo1);
$campo1=si($dis["pension"]=="1","S&iacute;",si($dis["pension"]=="2","No",si($dis["pension"]=="3","En tr&aacute;mite","")));
$campo2=d_t("DIS_PET",$dis["pension_estado_tramite"]);
$campo3=snb($dis["incluir_salud"]);
if($campo1!=""||$campo2!=""||$campo3!=""){
 echo "<li class='list-group-item'>".parte_sinoblanco("Pensi&oacute;n",$campo1)." ".parte_sinoblanco("Estado del tr&aacute;mite",$campo2)." ".parte_sinoblanco("Afiliaci&oacute;n a P.F.Incluir Salud",$campo3)."</li>";
};
echo "</ul>";
};
?>				
		</section>
		<section>
			<h3>Educaci&oacute;n</h3>
			<h4>Escolaridad</h4>
			<ul class="list-group">
<?php 
echo item_sinoblanco("Asiste a establecimiento educativo",snb($edu["edu_asiste"]));
echo item_sinoblanco("Establecimiento educativo",$edu["edu_establecimiento"]);
$campo1=$edu["edu_distrito_caba"];
$campo2=d_t("EMUNI",$edu["edu_municipio_pba"]);
$campo3="";
if($edu["edu_gestion"]=="1") {$campo3="Estatal";};
if($edu["edu_gestion"]=="2") {$campo3="Privada";};
if($edu["edu_gestion"]=="3") {$campo3="Mixta";};
if($campo1!=""||$campo2!=""||$campo3!=""){
 echo "<li class='list-group-item'>".parte_sinoblanco("Distrito escolar (CABA)",$campo1)." ".parte_sinoblanco("Municipio (PBA)",$campo2)." ".
parte_sinoblanco("Gesti&oacute;n",$campo3)."</li>"; 
};
echo item_sinoblanco("Tipo de establecimiento",d_t("ETIPO",$edu["edu_tipo_establecimiento"]));
echo item_sinoblanco("Nivel educativo",d_t("ENIVE",$edu["edu_nivel"]));
$campo1=snb($edu["edu_regular"]);
$campo2=d_t("EGRAD",$edu["edu_grado"]);
$campo3=d_t("ETURN",$edu["edu_turno"]);
if($campo1!=""||$campo2!=""||$campo3!=""){
 echo "<li class='list-group-item'>".parte_sinoblanco("As. regular",$campo1)." ".parte_sinoblanco("Sala/A&ntilde;o/Grado",$campo2)." ".
parte_sinoblanco("Turno",$campo3)."</li>";
};
$campo1=snb($edu["edu_apoyo"]);
$campo2=$edu["edu_apoyo_efector"];
if($campo1!=""||$campo2!=""){
echo "<li class='list-group-item'>".parte_sinoblanco("Recibe apoyo escolar",$campo1)." ".parte_sinoblanco("Efector",$campo2)."</li>";
};
$campo1=d_t("EGRAD",$edu["edu_ultimo_grado"]);
$campo2=$edu["edu_ultimo_anio"];
if($campo1>"0"||$campo2>"0"){
echo "<li class='list-group-item'>".parte_sinoblanco("Ult.Sala/A&ntilde;o/Grado aprobado",$campo1)." ".parte_sinoblanco("En el a&ntilde;o",$campo2)."</li>";
};
echo item_sinoblanco("Otras ofertas educativas",d_t("EOOFE",$edu["edu_otras_ofertas"]));
echo item_sinoblanco("Descripci&oacute;n de la situaci&oacute;n educativa durante este trimestre",$edu["edu_observaciones"]);
?>
			</ul>
		</section>
<section>
<?php 
if(($tra["tra_actividad"]!="" || $tra["pae"]=="1") && $edad>=16){
echo "<h3>Espacios Socioformativos y laborales</h3><ul class='list-group'>";
echo item_sinoblanco("Instituci&oacute;n",$tra["tra_institucion"]);
echo item_sinoblanco("Tipo de Actividad",d_t("TAFL",$tra["tipo_actividad"]));
echo item_sinoblanco("Programa / propuesta",$tra["tra_programa"]);
echo item_sinoblanco("Detalle",$tra["tra_actividad"]);
echo item_sinoblanco("D&iacute;as y horarios de actividad",$tra["tra_horario"]);
echo item_sinoblanco("Frecuencia",d_t("AFRE",$tra["frecuencia"]));

echo item_sinoblanco("<hr>Instituci&oacute;n",$tra["tra_institucion2"]);
echo item_sinoblanco("<hr>Tipo de Actividad",d_t("TAFL",$tra["tipo_actividad2"]));
echo item_sinoblanco("Programa / propuesta",$tra["tra_programa2"]);
echo item_sinoblanco("Detalle",$tra["tra_actividad2"]);
echo item_sinoblanco("D&iacute;as y horarios de actividad",$tra["tra_horario2"]);
echo item_sinoblanco("Frecuencia",d_t("AFRE",$tra["frecuencia2"]));
if($tra["pae"]=="1"){
	echo item_sinoblanco("PAE","S&iacute;");
	echo item_sinoblanco("Etapa",$tra["pae_etapa"]);
       echo item_sinoblanco("Referente",$tra["pae_referente"]);

};

echo item_sinoblanco("Descripci&oacute;n del modo de vivenciar cada propuesta",$tra["tra_observaciones"]);
echo "</ul>";
};

?>								
</section>

<section>
<?php 
if($act["actividad"]!=""){
echo "<h3>Actividades deportivas, recreativas y culturales</h3><ul class='list-group'>";
echo item_sinoblanco("Instituci&oacute;n / Programa",$act["institucion"]);
echo item_sinoblanco("Tipo de Actividad",d_t("TADRC",$act["tipo_actividad"]));
echo item_sinoblanco("Programa / propuesta",$act["programa"]);
echo item_sinoblanco("Detalle",$act["actividad"]);
echo item_sinoblanco("D&iacute;as y horarios de actividad",$act["horario"]);
echo item_sinoblanco("Frecuencia",d_t("AFRE",$act["frecuencia"]));

echo item_sinoblanco("Instituci&oacute;n",$act["institucion2"]);
echo item_sinoblanco("Tipo de Actividad",d_t("TADRC",$act["tipo_actividad2"]));
echo item_sinoblanco("Programa / propuesta",$act["programa2"]);
echo item_sinoblanco("Detalle",$act["actividad2"]);
echo item_sinoblanco("D&iacute;as y horarios de actividad",$act["horario2"]);
echo item_sinoblanco("Frecuencia",d_t("AFRE",$act["frecuencia2"]));

echo item_sinoblanco("Descripci&oacute;n del modo de vivenciar cada propuesta",$act["observaciones"]);
echo "</ul>";
};
?>								
		</section>
		<section>
			<h3>Proceso de egreso</h3>
			<p class="list-group-item">
<?php echo item_sinoblanco("Descripci&oacute;n",$egr["descripcion"]);?>
</p>
		</section>
		<section>
			<h3>Estrategias y Acciones</h3>
			<p class="list-group-item">
<?php echo item_sinoblanco("Descripci&oacute;n",$est["estraccion"]);?>
</p>
		</section>
		<h3>Articulaciones</h3>
			<p class="list-group-item">
<?php echo item_sinoblanco("Descripci&oacute;n",$est["articulacion"]);?>
</p>
		</section>
		<section>
			<h3>Firmas digitales</h3>
<?php
 $firmas=registros("select trim_firmas.usuario, usuarios_hogares_roles.funcion as f1, usuarios_hogares.funcion as f2,usuarios_hogares.* from trim_firmas 
 left join usuarios_hogares on usuarios_hogares.id=trim_firmas.usuario 
 left join usuarios_hogares_roles on usuarios_hogares_roles.hogar=".$hogar." and usuarios_hogares_roles.usuario=trim_firmas.usuario 
 where trimestral=".$id);
 while($f=mysqli_fetch_assoc($firmas)){
  if($f["usuario"]=="0"){echo "LABORDE, DENISE - Coordinadora &Aacute;rea Supervisi&oacute;n y Monitoreo - DGSAP - CDNNYA";}
  else {echo $f["apellidos"].", ".$f["nombres"].si($f["matricula"]!="",""," - DNI ".$f["dni"])." - ".si($f["f1"]=="",$f["f2"],$f["f1"])." - ".$f["profesion"]." - ".$f["matricula"]."<br>";};
 };
?>		
               </section>
                
     <button class="btn-primary" id='bi' onclick='imprimir()'>Imprimir</button>
     </main>
</body>
<?php
exit;

function item_sinoblanco($rotulo,$campo){
 if($campo==""){return "";};
 return "<li class='list-group-item'>".$rotulo.": <span>".renglonar($campo)."</span></li>";
}
function parte_sinoblanco($rotulo,$campo){
 if($campo==""){return "";};
 return $rotulo.": <span>".renglonar($campo)."</span>";
}

function d_t($tipo,$valor){
$ret=un_campo("select descripcion from tablas_semestrales where tipo=".tsql($tipo)." and valor=".nulea($valor));
if($ret=="(ninguno)"){return "";};
if($ret=="(ninguna)"){return "";};
if($ret=="(Vacio)"){return "";};

return $ret;
}
function d_n($valor,$cero){
return si($valor=="0",$cero,$valor);
}
function renglonar($t){
return nl2br($t);
}
?>


           