<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Certificado de Alojamiento";
$id=nget("id");
$ab=un_registro("select * from altasybajas where idaltasybajas=".$id);
$hg=un_registro("select dispositivos.*, diop.deno as diroper from dispositivos
left join tablas diop on diop.tipo='DIOP' and diop.valo=direccion_operativa where dispositivos.id=".$ab["hogar"]);
$nn=un_registro("select * from sujetos where legajo=".$ab["legajo"]);

function dni($n){
  if(!$n["SujetosDNI"]>"0"){return "sin datos";};
  if($n["TipoDNI"]=="1"){return $n["SujetosDNI"];};
  return "sin datos";
}

function muestra_hogar($h){
 $nom=$h["nombre"]." ";
 if($h["ong"]>"0"){$nom=$nom." dependiente de la asociaci&oacute;n civil ".un_campo("select nombre from hogares_ong where id=".$h["ong"]);}
 else {$nom=$nom." dependiente de esta Direcci&oacute;n General";};
 return $nom;
}
function muestra_dir($h){
 if($h["diroper"]=="DOIE"){return "Intervenciones Especiales";};
 if($h["diroper"]=="DOAVS"){return "Atenci&oacute;n Integral a Ni&ntilde;os, Ni&ntilde;as y Adolescentes en Situaci&oacute;n de Vulnerabilidad Social";};
 return $h["diroper"];
} 	
function muestra_domicilio($h){
 $nom=$h["domicilio"]." ".$h["localidad"];
 if(strpos($nom,"CABA")<=0){$nom=$nom."- Provincia de Buenos Aires";};
 return $nom;
}

?>
<body>
<div id="texto">
<h3>Certificado de Alojamiento</h3>
Para ser presentado ante quien corresponda.<br>
En mi calidad de Directora Operativa de la Direcci&oacute;n Operativa de <?php echo muestra_dir($hg)?>, dependiente de la Direcci&oacute;n General de Servicios de Atenci&oacute;n Permanente (DGSAP), del Consejo de Derechos de Ni&ntilde;os 
<br>Ni&ntilde;as y Adolescentes (CDNNYA), certifico que el d&iacute;a <?php echo ffec($ab["fecha_operacion"])?>, ingres&oacute; el/a ni&ntilde;o/a o adolescente 
<?php echo $nn["Apellidos"].", ".$nn["Nombres"]?>, con fecha de nacimiento <?php echo ffec($nn["f_nacimiento"])?>, D.N.I. Nro. <?php echo dni($nn)?>, 
<br>al dispositivo de alojamiento <?php echo muestra_hogar($hg)?>, ubicado en calle <?php echo muestra_domicilio($hg)?>
<br><?php echo si($hg["ong"]>"0","con personer&iacute;a jur&iacute;dica nro.".un_campo("select igj from hogares_ong where id=".$hg["ong"]),"")?>, cuyo responsable institucional es el/la sr./a 
<?php echo $hg["referente"]?>, D.N.I. Nro.<?php echo $hg["dni_referente"]?> <br>en el marco de la Convenci&oacute;n Internacional de Derechos del Ni&ntilde;o, Ley CABA Nro. 114 y Ley Nacional Nro. 26.061 de Protecci&oacute;n Integral de Ni&ntilde;os, Ni&ntilde;as y Adolescentes.
</div>
<br><button onclick='genera()'>Descargar</button>
<br><button onclick='navega("<?php echo $_SESSION["menu"]?>")'>Men&uacute;</button>
<script src="generales.js"></script>
<script>
function genera(){
  texto=document.getElementById("texto").innerHTML;
  const link = document.createElement("a");
  const file = new Blob([texto], { type: 'text/plain' });
  link.href = URL.createObjectURL(file);
  link.download = "<?php echo "cert.".$id?>.txt";
  link.click();
  URL.revokeObjectURL(link.href);
}
</script>
</body>
