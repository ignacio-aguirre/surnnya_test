<?php
/* Generales */
function Redirect($Str_Location, $Bln_Replace = 1, $Int_HRC = NULL){

        if(!headers_sent())
        {
            header('location: ' . urldecode($Str_Location), $Bln_Replace, $Int_HRC);
            exit;
        }
    exit('<meta http-equiv="refresh" content="0; url=' . urldecode($Str_Location) . '"/>'); 
    return;

}

function salidas($t){
    die($t);
   $_SESSION["avs"]=$t;
   Redirect("salir");
 }

function opc_tabla($tabla){
    $reg=registros("select valo, deno from tablas where baja is null and tipo=".tsql($tabla)." order by deno");
    $o="";
    while($r=mysqli_fetcH_assoc($reg)){
        $o=$o."<option value='".$r["valo"]."'>".$r["deno"]."</option>";

    };
    return $o;
}

    
function sqlf($t){
    return substr($t,-2)."/".substr($t,4,2)."/".substr($t,0,4);
}

function sqlf2($t){
    return substr($t,0,4)."-".substr($t,4,2)."-".substr($t,-2);
}



/* Fin Generales */



/* De Consulta de Base de Datos */



function milink(){
include("static/par-conexion.php");

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
$idretorno=mysqli_insert_id($link);
milink();
return $idretorno;

}



function un_registro($sent)

{

$dato = registros($sent);
milink();
return mysqli_fetch_assoc($dato);

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
return "'".$texto."'";
}
function escapar($texto){
return mysqli_real_escape_string(milink(),$texto);
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
function npost($numero) {
 return nulea($_POST[$numero]);
}
function tpost($texto) {
 return tsql($_POST[$texto]);
}
function fpost($fecha) {
 return fsql($_POST[$fecha]);
}


function e_get($objeto,$celda){
return utf8_decode($objeto->getActiveSheet()->getCell($celda)->getValue()); 
}

/* Fin Excel */



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
if($le>="0" && $le<="9") return true;
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

function sacapath($texto) {

  $salida="";

  for ($i = 0; $i < strlen($texto); $i++) {

     $l=substr($texto,$i,1);

     if($l=="/"||$l=="_") {$salida="";} else {$salida=$salida.$l;};

  };

  return $salida;

};



function ipactual()

{

    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet

    {

      $ip=$_SERVER['HTTP_CLIENT_IP'];

    }

    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy

    {

      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];

    }

    else

    {

      $ip=$_SERVER['REMOTE_ADDR'];

    }

    return $ip;

}



function si($c,$v,$f){
$r=$f;
if($c==true){$r=$v;};
return $r;
}

function showsex($s){
 if($s=="M") return "Masculino";
 if($s=="F") return "Femenino";
 if($s=="X") return "X Otros";
 return "";
}


function formatea_dom($t){
    $d=un_registro("select * from domicilios where direccion=".tsql($t));
    if($d["id"]>"0"){
        if($d["localidad"]=="CABA"){
            return $d["direccion"]." (".$d["barrio"].")";
        };
        $poscoma=strripos($t, ",");
        return substr($t,0,$poscoma+1)." ".$d["localidad"].", partido ".$d["partido"];
     } else {
        $id=un_registro("select id from domicilios where direccion=".tsql(estandariza_dom($t)));
        if($id>"0"){ return $t;};
     };
     return "";   
}

function estandariza_dom($t){
    $pospartido=strpos($t, " partido");
    if($pospartido>0){
     $part=substr($t,$pospartido+9);
     $t=substr($t,0,$pospartido);
     $poscoma=strripos($t, ",");
     $t=substr($t,0,$poscoma);
     $poscoma=strripos($t, ",");
     $t=substr($t,0,$poscoma).", ".$part;
    };
    $posparentesis=strpos($t, " (");
    if($posparentesis>0){
     $t=substr($t,0,$posparentesis);
    };
    return $t;
};
function almacena_domicilios($id){
    $dv=un_registro("select partida,destino_1,destino_2,destino_3,destino_4 from movil_viajes where id=".$id);
    alm_dom($dv["partida"]);
    alm_dom($dv["destino_1"]);
      alm_dom($dv["destino_2"]);
        alm_dom($dv["destino_3"]);
          alm_dom($dv["destino_4"]);
    
}
function alm_dom($domi){
    if($domi!=""){
        $dispositivo=$_SESSION["hogar"];
        if($dispositivo=="0"){
            $dispositivo=$_SESSION["sector"];
            $sql="select id from movil_domicilios where sector=".$dispositivo." and domicilio=".tsql($domi);
        $idd=un_campo($sql);}
        else{
            $dispositivo=$_SESSION["hogar"];
            $sql="select id from movil_domicilios where dispositivo=".$dispositivo." and domicilio=".tsql($domi);
            $idd=un_campo($sql);}
        };

       if($idd==""){
        $sql="select id,ref_general from domicilios where direccion=".tsql(estandariza_dom($domi));
       
        $dom=un_registro($sql);
         
        if($dom["id"]>"0"){
            if($dispositivo==$_SESSION["hogar"]){
                    inserte("insert into movil_domicilios(dispositivo,iddomicilios,domicilio,referencia) values(".$dispositivo.",".$dom["id"].",".tsql($domi).",".tsql($dom["ref_general"]).")");}
            else{
            inserte("insert into movil_domicilios(sector,iddomicilios,domicilio,referencia) values(".$dispositivo.",".$dom["id"].",".tsql($domi).",".tsql($dom["ref_general"]).")");};

                    

        }
        
    };
}
    
    

function des_obs($e){
  $des="";
  if($e=="PRO"){$des="Programado";};
  if($e=="REC"){$des="Rechazado";};
  if($e=="OBS"){$des="Observado";};
  if($e=="AUTOK"){$des="Pas&oacute; control autom&aacutetico";};
  if($e=="APR"){$des="Aprobado";};
  if($e=="BAJ"){$des="Baja";};
  if($e=="UNI"){$des="Unificado";};
  if($e=="CAN"){$des="Cancelado por solicitante";};


  return $des;
}


function distanciaCoord($lat1, $lon1, $lat2, $lon2) {
    // Radio de la Tierra en km
    $R = 6371;
    
    // Pasar grados a radianes
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    // Diferencias
    $dLat = $lat2 - $lat1;
    $dLon = $lon2 - $lon1;

    // Fórmula de Haversine
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos($lat1) * cos($lat2) *
         sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    // Distancia en km
    return round($R * $c,2);
}

function valorizar(){
    $bandeja="6";
    $oper=un_registro("select * from movil_procesos where fecha_hoy=".$_SESSION["hoy_s"]);
    $fini=$oper["desde_ab"];
    $ffin=$oper["hasta"];
    
    $fini=fsql(ffec($fini));
    $ffin=fsql(ffec($ffin));
    

    $via=registros("select movil_viajes.*, movil_renglones.sg,case when empresa=1 then valor1 else valor2 end as valor, es_iv, tipo, es_pba  from movil_viajes left join movil_renglones on tipo_movil=movil_renglones.id where bandeja=".$bandeja." and fecha between ".$fini." and ".$ffin);
    while($v=mysqli_fetch_assoc($via)){
        
        
            $cosa=valoriza($v["id"]);
            
            
        
    }
return true;

}
function valorizar2($id){
    $bandeja="6";
    $oper=un_registro("select * from movil_procesos where id=".$id);
    $fini=$oper["desde_ab"];
    $ffin=$oper["hasta"];
    $fini=fsql(ffec($fini));
    $ffin=fsql(ffec($ffin));
    
    $via=registros("select movil_viajes.*, movil_renglones.sg,case when empresa=1 then valor1 else valor2 end as valor, es_iv, tipo, es_pba  from movil_viajes left join movil_renglones on tipo_movil=movil_renglones.id where bandeja=".$bandeja." and fecha between ".$fini." and ".$ffin);
    while($v=mysqli_fetch_assoc($via)){
            $cosa=valoriza($v["id"]);
        
    }
return true;

}
function valoriza($id){
    $v=un_registro("select movil_viajes.*, movil_renglones.sg,case when empresa=1 then valor1 else valor2 end as valor, es_iv, tipo, es_pba  from movil_viajes left join movil_renglones on tipo_movil=movil_renglones.id where movil_viajes.id=".$id);
        if($v["estado"]!="CAN" || $v["cancelado"]=="1"){
        
        if($v["tipo"]=="1"){
            if($v["es_pba"]=="0"){
                $sg=1;
                if($v["hora_adicional"]=="1"){
                    $sg=$sg+0.35+0.05*$v["minutos_adicionales"];
                }
                
            };
            if($v["es_pba"]=="1"){
                $sg=$v["b10_km"];
                if($v["hora_adicional"]=="1"){
                    $sg=$sg+1+0.17*$v["minutos_adicionales"];
                }
            };
            
        } else{
            $sg=1;
        };
        if($v["cancelado"]=="1"){$sg=$sg*0.5;};
        $valor=$sg*$v["valor"];
        ejecute("update movil_viajes set valor_base=".$v["valor"].", sg=".(string) $sg.",valor_calculado=".$valor." where id=".$id);
    }else{
        
        ejecute("update movil_viajes set valor_base=".$v["valor"].", sg=0,valor_calculado=0 where id=".$id);
    };
    return $valor;

}

function dh($h1,$h2){
  $vh1=intval(substr($h1,0,2))*60+intval(substr($h1,-2));
  $vh2=intval(substr($h2,0,2))*60+intval(substr($h2,-2));
  return abs($vh1-$vh2);

}


function revisa_programados(){
    ejecute("update movil_viajes set estado='OBS', observaciones='El viaje ha vencido', bandeja=90 where bandeja<6 and fecha<".$_SESSION["hoy_s"]." and estado='PRO'");

    return true;
}
function apertura_habil_anterior(){
    $prox_habil=fsql(ffec(un_campo("select min(fecha) from fechas where laborable=1 and fecha>=curdate()")));
    $maniana_ph=fsql(ffec(un_campo("select date_add(".$prox_habil.", interval 1 day) from dual")));
    $segundo_habil=fsql(ffec(un_campo("select min(fecha) from fechas where laborable=1 and fecha>".$prox_habil)));;
    $maniana_sh=fsql(ffec(un_campo("select date_add(".$segundo_habil.", interval 1 day) from dual")));
    $ida=un_campo("select id from movil_procesos where fecha_hoy=".$prox_habil);
    if(!$ida>0){
    $ida=inserte("insert into movil_procesos(estado_operativo,proceso,fecha_hoy,desde_ab,desde_db,hasta) values('OPER','Laborable',$prox_habil,".$maniana_ph.",".
    $maniana_sh.",".$segundo_habil.")");
    }
    return $ida;

}
function apertura(){
    $f_hoy=fsql(ffec(un_campo("select min(fecha) from fechas where laborable=1 and fecha>=curdate()")));
    $maniana=fsql(ffec(un_campo("select date_add(".$f_hoy.", interval 1 day) from dual")));
    $hasta=fsql(ffec(un_campo("select min(fecha) from fechas where laborable=1 and fecha>".$f_hoy)));;
    $desde_db=fsql(ffec(un_campo("select date_add(".$hasta.", interval 1 day) from dual")));
    $ida=un_campo("select id from movil_procesos where fecha_hoy=".$f_hoy);
    if(!$ida>0){
    $ida=inserte("insert into movil_procesos(estado_operativo,proceso,fecha_hoy,desde_ab,desde_db,hasta) values('OPER','Laborable',".$f_hoy.",".$maniana.",".
    $desde_db.",".$hasta.")");
    }
    return $ida;

}
function bloquear($id){
    $cosa=valorizar2($id);
    $proc=un_registro("select * from movil_procesos where id=".$id);
    $fini=fsql(ffec($proc["desde_ab"]));
    $ffin=fsql(ffec($proc["hasta"]));
    ejecute("update movil_viajes set bandeja=7,bloqueo=2,lote_envio=".$id." where bandeja=6 and estado='APR' and fecha between ".$fini." and ".$ffin);
    ejecute("update movil_viajes set bandeja=90,bloqueo=2 where bandeja=6 and estado<>'APR'  and fecha between ".$fini." and ".$ffin);
    ejecute("update movil_procesos set b1_6=1, b2_6=1 where id=".$id);
}



function compara($id){
    $v=un_registro("select * from movil_viajes where id=".$id);
    $difer="";
    if((intval($v["cumplido"])==-1||$v["estado"]=="CAN") && intval($v["cumplido_voucher"])==1){
        $difer="Cumplido DGSAP:".si($v["cumplido"]=="1","SI","NO").";ET:".si($v["cumplido_voucher"]=="1","SI","NO")." ";
    }
    $esp=intval($v["hora_adicional"])*60+intval($v["minutos_adicionales"])*10;
    if($esp>0){$esp=$esp+30;};
    $espv=intval(substr($v["espera_voucher"],0,2))*60+intval(substr($v["espera_voucher"],3,2));
    if($espv>$esp+9){
            $difer=$difer."ET min espera excedentes (".(string)(intval($espv)-intval($esp)).") " ;
    }
    $kmv=intval($v["km_voucher"]);
    $km=intval($v["distancia_calculada"]);
    if($v["tipo_movil"]=="3"||$v["tipo_movil"]=="5"){
        if($kmv>6 || $kmv>$km){
            $difer=$difer."Km DGSAP:".$km.";ET:".$kmv." ";
        }
    };
    if($v["tipo_movil"]=="4"||$v["tipo_movil"]=="6"){
        
        if($kmv<=6|| $kmv>$km){
            $difer=$difer."Km DGSAP:".$km.";ET:".$kmv." ";
        }
    };
    if($v["tipo_movil"]=="7"){
        $km=$v["b10_km"]*10;
        
        if($kmv>$km+5){
            $difer=$difer."Km DGSAP:".$km.";ET:".$kmv." " ;
        }
    };
    if($difer==""){$difer="Sin diferencias";}
    ejecute("update movil_viajes set observaciones=".tsql($difer)." where id=".$id);
    return $difer;
}   
?>