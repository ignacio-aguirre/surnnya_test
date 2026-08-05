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
if(mysqli_num_rows($dato)==0){return "";};

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
 if(!isset($_GET[$numero])){return "";};
 return $_GET[$numero];

}



function tget($texto) {

 return tsql($_GET[$texto]);

}



function fget($fecha) {
 if(!isset($_GET[$fecha])){return "null";};
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



function opciones($tabla){
$orden="descripcion";
if($tabla=="usuarios")$orden="apellido, nombre";
$s="<option value='0'>(vacio)</option>";
$reg=registros("select * from ".$tabla." where baja is null order by ".$orden);
while($r=mysqli_fetch_array($reg)){
$s=$s."<option value=".$r[0].">".$r[1]."</option>";
};
return $s;

}
function roles(){
 $reg=registros("select * from roles order by nombre");
 $s="<option value='0'>(vacio)</option>";
 while($r=mysqli_fetch_assoc($reg)){
   $s=$s."<option value=".$r["id"].">".$r["nombre"]."</option>";
 };
 return $s;
}

function opciones_cond($tabla,$cond){

$orden="descripcion";

if($tabla=="usuarios")$orden="apellido, nombre";

$s="<option value='0'>(vacio)</option>";

if($tabla=="efectores" && $_SESSION["permiso"]==4) {$s="";$cond="idefectores=".$_SESSION["efector"];};

$reg=registros("select * from ".$tabla." where baja is null and ".$cond." order by ".$orden);

while($r=mysqli_fetch_array($reg)){
if($tabla=="usuarios"){$s=$s."<option value=".$r[0].">".utf8_encode($r[1].", ".$r[2])."</option>";}
else {$s=$s."<option value=".$r[0].">".utf8_encode($r[1])."</option>";};

};

return $s;

}

function reg_acc($accion,$referencia,$comprobante){

return inserte("insert into registro_acciones(fecha,hora,usuario,accion,referencia,comprobante) values(curdate(),curtime(),".$_SESSION["usuario"].",".tsql($accion).",".tsql($referencia).",".nulea($comprobante).")");

}




function e_put($objeto,$celda,$texto){

$objeto->getActiveSheet()->setCellValue($celda,$texto);

return true;

}

function e_get($objeto,$celda){

return utf8_decode($objeto->getActiveSheet()->getCell($celda)->getValue()); 

}



function notificar($usuario,$texto){

return inserte("insert into notificaciones(fecha,hora,usuario,texto) values(curdate(),curtime(),".$usuario.",".tsql($texto).")");

}

function semaforo_pone(){
	$id_sema=inserte("insert into semaforo (fechahora) values(current_timestamp())");	

	$actual=un_campo("select idsemaforo from semaforo order by idsemaforo limit 1");



	while($actual!=$id_sema){	

	/*borra los que pasaron el tiempo en 5 segundos por proceso*/

        	$espera=un_campo("select count(*) from semaforo");

		ejecute("delete from semaforo where second(timediff(current_timestamp(),fechahora))>5*".$espera);

		$actual=un_campo("select idsemaforo from semaforo order by idsemaforo limit 1");

	};	
return $id_sema;
}
function semaforo_saca($id_sema){
 ejecute("delete from semaforo where idsemaforo=".$id_sema);
 return true;
}
function notificaciones(){
$cantidad=un_campo("select count(*) from notificaciones where usuario=".$_SESSION["usuario"]." and leido=0");
$texto="";
if($cantidad!="" && $cantidad>0){$texto="Ud. tiene ".$cantidad." notificaciones. Click <a href='notificaciones'>Aqu&iacute;</a> para consultarlas";};
$pedidos=un_campo("select count(*) from pedidos where deposito=".$_SESSION["deposito"]." and estado=1");
if($pedidos!="" && $pedidos>0 && $_SESSION["pd_aut"]==1){$texto=$texto."<br>Hay ".$pedidos." Pedidos para Autorizar.";};
return $texto; 
};