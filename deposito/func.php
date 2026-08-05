<?php
//header('Content-Type: text/html; charset=latin-1');
function tsql($texto) {
return "'".mysqli_real_escape_string(milink(),$texto)."'";
}

function fsql($fecha) {
if($fecha=="") return "null";
return substr($fecha,-4).substr($fecha,3,2).substr($fecha,0,2);
}



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

$rs=mysqli_fetch_array($dato);

return $rs[0];

}



function notificaciones(){

$cantidad=un_campo("select count(*) from notificaciones where usuario=".$_SESSION["usuario"]." and leido=0");

$texto="";

if($cantidad!="" && $cantidad>0) echo "Ud. tiene ".$cantidad." notificaciones. Click <a href='notificaciones'>Aqu&iacute;</a> para consultarlas";

return $texto; 

};

function nget($numero) {

 return nulea($_GET[$numero]);

}



function tget($texto) {

 return tsql($_GET[$texto]);

}



function fget($fecha) {

 return si($_GET[$fecha]=="","null",fsql($_GET[$fecha]));

}



function nulea($dato) {

$texto = $dato;

if($texto==""|$texto=="NaN") $texto="null";

return $texto;

}








function si($condicion,$vv,$vf){

if($condicion==true) return $vv;

return $vf;

}

function opciones($tabla){

$orden="descripcion";

$condicion="";

if($tabla=="usuarios")$orden="apellido, nombre";

$s="<option value='0'>(vacio)</option>";

if($tabla=="gerencias" && $_SESSION["gerencia"]>0){$s=""; $condicion="and idgerencias=".$_SESSION["gerencia"];};

if($tabla=="efectores" && $_SESSION["efector"]>0) $condicion="and idefectores=".$_SESSION["efector"];





$reg=registros("select * from ".$tabla." where baja is null ".$condicion." order by ".$orden);

while($r=mysqli_fetch_array($reg)){

$s=$s."<option value=".$r[0].">".utf8_encode($r[1])."</option>";

};

return $s;

}

function opciones_cond($tabla,$cond){

$orden="descripcion";

if($tabla=="usuarios")$orden="apellido, nombre";

$s="<option value='0'>(vacio)</option>";

if($tabla=="efectores" && $_SESSION["efector"]>0) {$s="";$cond="idefectores=".$_SESSION["efector"];};

$reg=registros("select * from ".$tabla." where baja is null and ".$cond." order by ".$orden);

while($r=mysqli_fetch_array($reg)){

$s=$s."<option value=".$r[0].">".utf8_encode($r[1])."</option>";

};

return $s;

}

function reg_acc($accion,$referencia,$comprobante){

return inserte("insert into registro_acciones(fecha,hora,usuario,accion,referencia,comprobante) values(curdate(),curtime(),".$_SESSION["usuario"].",".tsql($accion).",".tsql($referencia).",".nulea($comprobante).")");

}







?>