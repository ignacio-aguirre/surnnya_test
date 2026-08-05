<?php
function Redirect($Str_Location, $Bln_Replace = 1, $Int_HRC = NULL)
{  
        if(!headers_sent())
        {
            header('location: ' . urldecode($Str_Location), $Bln_Replace, $Int_HRC);
            exit;
        }
    exit('<meta http-equiv="refresh" content="0; url=' . urldecode($Str_Location) . '"/>'); # | exit('<script>document.location.href=' . urldecode($Str_Location) . ';</script>');
    return;
}

function tranca($permiso=10){
if(!isset($_SESSION["usuario"])) Redirect("salir");
//if(un_campo("select usuario from log_in_out where idlog_in_out=".$_SESSION["log_in"])!=$_SESSION["usuario"]) Redirect("salir");
if($_SESSION["permiso"]<$permiso) Redirect($_SESSION["menu"]."?status=ErrPerm");
return false;
}

/* De Consulta de Base de Datos */
function milink(){
include("static/par-conexion.php");
if(!($_SESSION['ipMySQL']>"0")){Redirect('sesion_expirada');};
$link= mysqli_connect($_SESSION['ipMySQL'], $_SESSION['usMySQL'], $_SESSION['pwMySQL']) or die(mysqli_error($link));

$resu=mysqli_select_db($link,$_SESSION['dbMySQL']) or die(mysqli_error($link));

return $link;

}

function ejecute($sent) {

$link=milink();

$sql=$sent;

$dato = mysqli_query($link,$sql) or die(mysqli_error($link));
milink();
}



function inserte($sent) {

$link=milink();

$sql=$sent;

$dato = mysqli_query($link,$sql) or die(mysqli_error($link));

return mysqli_insert_id($link);

}


function un_registro($sent)

{

$dato = registros($sent);
milink();
return mysqli_fetch_assoc($dato);

}



function un_registro_array($sent)

{

$dato = registros($sent);
milink();
return mysqli_fetch_array($dato,MYSQLI_NUM);

}





function un_re($sent)

{

$dato = registros($sent);

return mysqli_fetch_array($dato,MYSQL_NUM);

}





function registros($sent)

{

$link=milink();

$sql=$sent;

$dato = mysqli_query($link,$sql) or die(mysqli_error($link));
milink();
return $dato;

}







function un_campo($sent)

{

$dato = registros($sent);

$rs=mysqli_fetch_array($dato);
milink();
return $rs[0];

}



function tsql($texto) {
$probl=array("¨","&","$","%","*","(",")","_","+","=","{","}","[","]","|",chr(92),"±","÷","^","<",">","?","/","~","ä","ö","ç","ß","œ","?","8","v","n","˜","?","?","n","=","?","n","¶","?"
,"`","¯","°","¬","¶","•","©","®","™");
//$texto=str_replace($probl,"x",$texto);
return "'".mysqli_real_escape_string(milink(),$texto)."'";
}



function fsql($fecha) {

if($fecha=="") return "null";

return substr($fecha,-4).substr($fecha,3,2).substr($fecha,0,2);

}



function ffec($fecha)

{

if(gettype($fecha)=="NULL") {return "";} else return substr($fecha,8,2)."/".substr($fecha,5,2)."/".substr($fecha,0,4);

}



function nget($numero) {
 return nulea($_GET[$numero]);
}
function tget($texto) {
 return tsql($_GET[$texto]);
}
function fget($fecha) {
 return si($_GET[$fecha]=="","null",fsql($_GET[$fecha]));
}
function npost($numero) {
 return nulea($_POST[$numero]);
}
function tpost($texto) {
 return tsql($_POST[$texto]);
}
function fpost($fecha) {
 return si($_POST[$fecha]=="","null",fsql($_POST[$fecha]));
}


/* Fin de Consulta de Base de Datos */









function si($condicion,$vv,$vf){

if($condicion==true) return $vv;

return $vf;

}





function colorfila(){

$_SESSION["renglon"]=$_SESSION["renglon"]+1;

if($_SESSION["renglon"]%2==0) {$color="'white'";} else $color="'#F2F2F2'";

return "<tr bgcolor=".$color.">";

}



function cf($funcion){

$_SESSION["renglon"]=$_SESSION["renglon"]+1;

if($_SESSION["renglon"]%2==0) {$color='white';} else $color='#F2F2F2';

return '<tr class="filaclick" bgcolor="'.$color.'" onclick="'.$funcion.'">';

/* bgcolor="'.$color.'">';*/



};







/* Fin A Clasificar */



/* De Cadena y Texto */



function parsea($entrada) {

$salida=array();

$largocadena=strlen($entrada);

$buff="";

for ($i = 0; $i < $largocadena; $i++) {

  $l=substr($entrada,$i,1);

  if ($l==" ") {if($buff!="") {$salida[]=$buff;$buff="";}} else {$buff=$buff.$l;}; 

};

if($buff!="") {$salida[]=$buff;};

return $salida;

}



/* puede volar */





function reemplaza($frase) {

$viejos = array("á", "é", "í", "ó", "ú", "Á","É","Í","Ó","Ú","ñ","Ñ","º","ü","Ü");

$nuevos   = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;","&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;","&ntilde;", "&Ntilde;","o.","&uuml;","&Uuml;");

$texto = str_replace($viejos, $nuevos, $frase);

return $texto;

}



function ree($frase) {

$viejos =   array("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ", "Ñ" ,"º" ,"ü","Ü");

$nuevos   = array("a","e","i­","o","u","A","E","I","O","U","n_","N_","o.","u","U");

$texto = str_replace($viejos, $nuevos, $frase);

return $texto;

}



function nulea($dato) {

$texto = $dato;

if($texto==""|$texto=="NaN") $texto="null";

return $texto;

}

function comillas($texto){
return nl2br(str_replace('"',"",$texto));
}


/* Fin De Cadena y Texto */



function opciones($tabla){
$orden=si($tabla=="dispositivos","nombre","descripcion");
$s="<option value='0'>(vacio)</option>";
$reg=registros("select * from ".$tabla." where baja is null order by ".$orden);
while($r=mysqli_fetch_array($reg)){
  if($tabla=="provincias"){$s=$s."<option value=".$r[1].">".$r[2]."</option>";}
  else{$s=$s."<option value=".$r[0].">".$r[1]."</option>";};
};
return $s;
}
function opcionest($tabla){
$orden=si($tabla=="dispositivos"||$tabla=="partidos","nombre","descripcion");
$s="<option value=''>(vacio)</option>";
$reg=registros("select * from ".$tabla." where baja is null order by ".$orden);
while($r=mysqli_fetch_array($reg)){
  if($tabla=="provincias"){$s=$s."<option value='".$r[2]."'>".$r[2]."</option>";}
  else{$s=$s."<option value='".$r[1]."'>".$r[1]."</option>";};
};
return $s;
}

function opciones_cond($tabla,$cond){

$orden=si($tabla=="dispositivos","nombre","descripcion");


if($tabla=="usuarios")$orden="apellido, nombre";

$s="<option value='0'>(vacio)</option>";

if($tabla=="efectores") $s="";

$reg=registros("select * from ".$tabla." where baja is null and ".$cond." order by ".$orden);

while($r=mysqli_fetch_array($reg)){

$s=$s."<option value=".$r[0].">".$r[1]."</option>";

};

return $s;

}



function opc_tabla($tipo){

$orden="order by valor";

if($tipo=="DZ"||$tipo=="ZP"||$tipo=="TJ"||$tipo=="ESAC"||$tipo=="ESAB"||$tipo=="ESPEC"||$tipo=="ESMEN"||$tipo=="ESPSM") $orden="order by descripcion";

$s="";

$reg=registros("select valor,descripcion from tablas_semestrales where baja is null and tipo=".tsql($tipo)." ".$orden);

while($r=mysqli_fetch_array($reg)){

$s=$s."<option value=".$r[0].">".($r[0]=="0"? "(vacio)": $r[1])."</option>";
};

return $s;



}



function opc_numeros($desde,$hasta){

$orden="order by valor";

$s="";

for($i=$desde;$i<=$hasta;$i++){

$s=$s."<option value=".$i.">".$i."</option>";

};

return $s;



}





function reg_acc($accion,$referencia,$comprobante){

return inserte("insert into registro_acciones(fecha,hora,usuario,accion,referencia,comprobante) values(curdate(),curtime(),".$_SESSION["usuario"].",".tsql($accion).",".tsql($referencia).",".nulea($comprobante).")");

}



function exc($texto){

return $texto;

}

function e_put($objeto,$celda,$texto){

$objeto->getActiveSheet()->setCellValue($celda,exc($texto));

return true;

}

function e_get($objeto,$celda){

return utf8_decode($objeto->getActiveSheet()->getCell($celda)->getValue()); 

}



function notificar($usuario,$texto){

return inserte("insert into notificaciones(fecha,hora,usuario,texto) values(curdate(),curtime(),".$usuario.",".tsql($texto).")");

}



function registra($prestacion){

if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {$ford=$_SERVER['HTTP_X_FORWARDED_FOR'];} else $ford=".";

return inserte("insert into log_minimo(usuario,ip,prestacion,fecha,hora) values(".$_SESSION["usuario"].",".tsql($_SERVER['REMOTE_ADDR']." ".$ford).",".tsql($prestacion).",curdate(),curtime())");

}


function blancosino(){
echo "<option value='0'>(vac&iacute;o)</option><option value='1'>S&iacute;</option><option value='2'>No</option>";
return true;
}
function sino(){
echo "<option value='1'>S&iacute;</option><option value='2'>No</option>";
return true;
}
function nosi(){
echo "<option value='2'>No</option><option value='1'>S&iacute;</option>";
return true;
}

function snb($valor){
return si(!$valor>="1","",si($valor=="1","Si","No"));
}
function rib2($r){
 if($r["rib_anio"]==""){return "";}
 else{
   return "RIB-".$r["rib_anio"]."-".intval($r["rib_numero"])."-".trim($r["rib_reparticion"]);
 };
}
function rib($anio,$numero,$reparticion){
 if($anio==""){return "";}
 else{
   return "RIB-".$anio."-".intval($numero)."-".trim($reparticion);
 };
}

function opc_tabla_surnnya($tipo){
$reg=registros("select * from surnnya.tablas where baja is null and tipo=".tsql($tipo)." order by info,deno");

$o="";

while($r=mysqli_fetch_assoc($reg)){

 $o=$o."<option value='".$r["valo"]."'>".$r["deno"]." ".$r["info"]."</option>";

};

return $o;

}
function ftx($t){
$t=comillas($t);
$s="";
for($i=0;$i<strlen($t);$i++){
 if(ord(substr($t,$i,1))==13 && ord(substr($t,$i+1,1))==10){$s=$s."<br>";$i++;} else {$s=$s.substr($t,$i,1);};
};
return $s;
}

function localidades($prov="",$part=""){

  $sent="select id,nombre,provincia,partido from localidades_nueva where baja is null ";	
  if($prov!=""){ $sent=$sent." and provincia=".tsql($prov)." ";};
  if($part!=""){ $sent=$sent." and partido=".tsql($part)." ";};

  $sent=$sent." order by case when provincia='CABA' then 0 else 1 end,
   case when partido is null then 1 else 0 end, partido, case when nombre is null then 1 else 0 end, 
 case when provincia is null then 1 else 0 end ,provincia,nombre";

 $loc=registros($sent);
	$o="";
	while($l=mysqli_fetch_assoc($loc)){
		$nombre=$l["nombre"];
		if($l["provincia"]=="CABA") {$nombre="CABA";}
		else if($l["nombre"]!=""){$nombre=$l["nombre"]." - ".($l["provincia"]!=""? "Provincia:".$l["provincia"]:"");}
		elseif($l["provincia"]!=""){$nombre="Provincia de ".$l["provincia"];};
		if($nombre=="") $nombre="s/datos localidad";
 		$o=$o."<option value='".$l["nombre"]."'>".$nombre."</option>";
	};
	return "<option value=''>(vacio)</option>".$o."<option value='999'>(nueva)</option>";
}
function barrios(){
  $bar=registros("select barrio,comuna from barrios_caba order by barrio");
  $o="<option value=''>(vacio)</option>";
  while($b=mysqli_fetch_assoc($bar)){
   $o=$o."<option value='".$b["barrio"]."'>".$b["barrio"]."</option>";	
  };
return $o;
}
?>