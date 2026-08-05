<?php
require("funciones.php"); 
session_start();
$calle=tget("calle");
$calle_cruce=tget("calle_cruce");
$altura=nget("altura");
if($_GET["altura"]=="") $altura="0";
$localidad=trim($_GET["localidad"]);
$partido=trim($_GET["partido"]);
if($partido!="CABA"){
	$partido=maymin($partido);
	$localidad=maymin($localidad);
	if(isset($_GET["loc_esp"])){
		if($_GET["loc_esp"]!=""){
			$localidad=trim(strtoupper($_GET["loc_esp"]));
			$partido=trim(strtoupper($partido));
			inserte("insert into localidades_nueva(pais,nombre,provincia,partido) values(9,".tsql($localidad).",'BUENOS AIRES',".tsql($partido).")");
			$part_ex=un_campo("select nombre from partidos where nombre like '%".$partido."%'");
			if($part_ex==""){
				inserte("insert into partidos(nombre) values(".tsql($partido).")");
			}
		}
	}
	
};
$barrio=tget("barrio");
$comuna=nget("comuna");
if($_GET["comuna"]=="") $comuna="0";
if($_GET["altura"]!=""){
   $direccion=$_GET["calle"]." ".$_GET["altura"].", ".$partido;
} else {$direccion=$_GET["calle"]." y ".$_GET["calle_cruce"].", ".$partido;}
$longitud=nget("longitud");
$latitud=nget("latitud");
$ref_general=tget("ref_general");
$id_dom=inserte("insert into domicilios(direccion,calle,calle_cruce,altura,localidad,partido,barrio,comuna,normalizada,latitud,longitud,ref_general) values(".tsql($direccion).",".$calle.",".$calle_cruce.",".$altura.",".tsql($localidad).",".tsql($partido).",".$barrio.",".$comuna.",0,".$latitud.",".$longitud.",".$ref_general.")");
if($_SESSION["perfil_moviles"]=="1"){
 $domicilio=tsql(formatea_dom($direccion));
 
 if($_SESSION["hogar"]>"0"){ 	
 	
   $id=inserte("insert into movil_domicilios(dispositivo,iddomicilios,domicilio,referencia) values(".$_SESSION["hogar"].",".$id_dom.",".$domicilio.",".$ref_general.")");}
 else{
 	$id=inserte("insert into movil_domicilios(sector,iddomicilios,domicilio,referencia) values(".$_SESSION["sector"].",".$id_dom.",".$domicilio.",".$ref_general.")");
 }  
 
};


$_SESSION["msg"]="Domicilio #".$id_dom." creado";
$_SESSION["retorno"]=$_SESSION['menu'];
Redirect("aviso?cierre=1");


function maymin($t){
	$re=strtoupper(substr($t,0,1)).strtolower(substr($t,1));
	/*$minu=true;
	for($i=1;$i<strlen($t);$i++) {
		if($minu){$re=$re.strtolower(substr($t,$i,1));}
		else{$re=$re.strtoupper(substr($t,$i,1));};
		if(substr($t,$i,1)==" "){$minu=false;} else{$minu=true;};
	};
	$re=str_replace(" De ", " de ", $re);
	$re=str_replace(" Del ", " del ", $re);
    */
	return $re;
}
?>
<script>window.close()</script>