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

function tranca(){
if(!isset($_SESSION["usuario"])) Redirect("salir");
if(!$_SESSION["usuario"]>0) Redirect("salir");

return false;
}

/* De Consulta de Base de Datos */

function milink(){
$link= mysqli_connect($_SESSION['ipMySQL'], $_SESSION['usMySQL'], $_SESSION['pwMySQL']) or die(mysqli_error($link));
$resu=mysqli_select_db($link,$_SESSION['dbMySQL']) or die(mysqli_error($link));
return $link;
}

function ejecute($sent) {
$link=milink();
$sql=$sent;
$dato = mysqli_query($link,$sql) or die(mysqli_error($link));
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
return mysqli_fetch_assoc($dato);
}

function un_registro_array($sent)
{
$dato = registros($sent);
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
return $dato;
}



function un_campo($sent)
{
$dato = registros($sent);
$rs=mysqli_fetch_array($dato);
return $rs[0];
}

function tsql($texto) {
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
 return fsql($_GET[$fecha]);
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

function parentesco($x) {

if($x=="M") return "Madre";
if($x=="P") return "Padre";
if($x=="B") return "Pareja Madre";
if($x=="C") return "Pareja Padre";
if($x=="H") return "Hermano/a";
if($x=="T") return "Tio/a";
if($x=="I") return "Hijo/a";
if($x=="A") return "Abuelo/a";
if($x=="N") return "Pareja";
if($x=="O") return "Otros";
if($x=="S") return "Sobrino/a";

if($x=="") return "S/D";
}

/* Fin A Clasificar */

/* De Cadena y Texto */

function parsea($entrada) {
$salida=array();
$largocadena=strlen($entrada);
$buff="";
for ($i = 0; $i < $largocadena; $i++) {
  $l=substr($entrada,$i,1);
  if (!letra($l)) {if($buff!="") {$salida[]=$buff;$buff="";}} else {$buff=$buff.$l;}; 
};
if($buff!="") {$salida[]=$buff;};
return $salida;
}

function letra($le) {
if($le>="a" && $le<="z") return true;
if($le>="A" && $le<="Z") return true;
if($le=="Ñ" | $le=="ñ") return true;
return false;
}

function sacamas($texto) {
return str_replace("'","%27",str_replace(" ","%20",str_replace("+", "%2B", $texto)));
}

function sacamas_limpia($frase){ 
$viejos = array("á", "é", "í", "ó", "ú", "Á","É","Í","Ó","Ú","ñ","Ñ","º","ü","Ü","¦","/","@","'","´");
$nuevos   = array("a", "e", "i", "o", "u","A", "E", "I", "O", "U","ny", "NY","o.","u","U","x","x","x","x","x");
$texto = str_replace($viejos, $nuevos, $frase);
return $texto;
}

function sacapath($texto){ // lo que hace aca es quitar todo lo que viene antes del nombre de archivo, es decir antes de la ultima barra 

return true;
}

function reemplaza($frase) {
$viejos = array("á", "é", "í", "ó", "ú", "Á","É","Í","Ó","Ú","ñ","Ñ","º","ü","Ü");
$nuevos   = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;","&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;","&ntilde;", "&Ntilde;","o.","&uuml;","&Uuml;");
$texto = str_replace($viejos, $nuevos, $frase);
return $texto;
}

function ree($frase) {
$viejos = array("á", "é", "í", "ó", "ú", "Á","É","Í","Ó","Ú","ñ","Ñ","º","ü","Ü");
$nuevos   = array("Ã¡","Ã©","Ã­","Ã³","Ãº","Ã?","A", "E", "I", "O", "U","n_;", "N_","o.","u","U");
$texto = str_replace($viejos, $nuevos, $frase);
return $texto;
}

function nulea($dato) {
$texto = $dato;
if($texto==""|$texto=="NaN") $texto="null";
return $texto;
}

/* Fin De Cadena y Texto */

function loguea($accion,$caso,$archivo){
inserte("insert into log_acciones(fecha,hora,usuario,accion,caso,archivo) values(curdate(),curtime(),".$_SESSION["usuario"].",".tsql($accion).",".$caso.",".$archivo.")");
return true;
}
?>