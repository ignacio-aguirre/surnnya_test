<?php
include("Funciones_Tablas.php");
/* Generales */

function blancosino(){
echo "<option value='0'>(vac&iacute;o)</option><option value='1'>S&iacute;</option><option value='2'>No</option>";
return true;
}
function snb($valor){
return si(!$valor>="1","",si($valor=="1","Sí","No"));
}

function comillas($texto){
return str_replace('"',"",$texto);
}

function opc_tablas($tipo){
$orden="order by valor";
if($tipo=="DZ"||$tipo=="ZP"||$tipo=="TJ") $orden="order by descripcion";
$s="";
$reg=registros("select valor,descripcion from tablas_semestrales where baja is null and tipo=".tsql($tipo)." ".$orden);
while($r=mysqli_fetch_array($reg)){
 $s=$s."<option value=".$r[0].">".$r[1]."</option>";
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


function registre() {
if(!isset($_SESSION['glusua'])) Redirect(".");
ejecute("delete from sesiones where timediff(current_timestamp(),fechayhora)>'12:00'"); //.$_SESSION['glto']
$cantses = un_campo("select count(*) from sesiones where idsesiones=".$_SESSION['gl_sesion']);
if($cantses==0) Redirect(".");
return "OK";
}

function noconsulta(){
registre();
if($_SESSION["glcons"]=="1") Redirect("error_noautorizado");
}

function logueasistema(){
if(!isset($_SESSION['glusua'])) Redirect(".");
inserte("insert into logs_sistema(logs_usuario,logs_script) values(".tsql($_SESSION["glusua"]).",".tsql($_SERVER["REQUEST_URI"]).")");
}

function registro_rapido($texto){
return    inserte("insert into log_rapido(usuario,texto) values(".tsql($_SESSION["glusua"]).",".tsql($texto).")");
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



function alerte($frase) {

echo "<script>";

echo "alert('".$frase."');";

echo "</script>";

}



function variables_iniciales($u)  { /* en u viene el registro de usuario */

     $_SESSION['LeyendaAnual']=un_campo("select leyendaanual from parametros where idparametros=1");
     $_SESSION['glto']=36;
     if($u['id']==1) $_SESSION['glto']=360000;
     $_SESSION['gldispo'] = $u['sector'];
     $_SESSION['glddispo'] = $u['ndispo'];
     $_SESSION['glusua'] = $u['apellido'].", ".$u['nombre'];
     $_SESSION['glidusua'] = $u['id'];
     $_SESSION['glperfil']=$u['nperfil'];
     $_SESSION['glidperfil']=$u['perfil'];
     if($u["perfil"]>"0"){
     $p=un_registro("select * from perfiles where id=".$u["perfil"]);
     $_SESSION['gl_acciones'] = $p['acciones'];
     $_SESSION['glcons'] = $p['soloconsulta'];
     $_SESSION['gl_nuevo_sujeto']= $p['nuevo_sujeto'];
     $_SESSION['gl_editar_sujeto']= $p['editar_sujeto'];
     $_SESSION['gl_todos_dispo']= $p['todos_dispo'];
     $_SESSION['gl_admi']= $p['admision'];
     $_SESSION['gl_super_super']= $p['super_supervisar'];
     $_SESSION['gl_usuarios']= $p['usuarios'];
     $_SESSION['gl_tablahogares']= $p['tabla_hogares'];
     $_SESSION['gl_tablaongs']= $p['tabla_ongs'];
     $_SESSION['legajo']="";
     $_SESSION['menu']=$p['menu'];
     $_SESSION['mnu']=$p['menu_nuevo'];
     $_SESSION['glnombdispo']=$p['ndispo'];

     if($u['hogar']>0) {$_SESSION['glhogar']=$u['hogar'];
        $_SESSION['gldhogar']=un_campo("select nombre from dispositivos where dispositivos.id=".$u['hogar']);};
     $_SESSION['renglon']=1;
     $idsesion=inserte("insert into sesiones (usuario, ingreso,fechayhora,ip) values('".$_SESSION['glusua']."','".time()."',concat(curdate(),' ',curtime()),".tsql(ipactual()).")");
     $_SESSION['gl_sesion']=$idsesion;
     tablas_generales();
 } else{Redirect("salir?mensaje=No tiene perfil en SURNNYA");};

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



function un_registro_array($sent)

{

$dato = registros($sent);
milink();
return mysqli_fetch_array($dato,MYSQLI_NUM);

}





function un_re($sent)

{

$dato = registros($sent);
$respuesta=mysqli_fetch_array($dato,MYSQL_NUM);
milink();
return $respuesta;

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
if(mysqli_num_rows($dato)==0){return "";};
$rs=mysqli_fetch_array($dato);
milink();
return $rs[0];

}



function tsql($texto) {

return "'".escapar($texto)."'";

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


/* Fin de Consulta de Base de Datos */







/* De consulta de Nivel 2 a Base de Datos */





function buscador_pibes($frase,$h18,$alojados) {
 $cerra="cerrado<>1";
 $sql="select sujetos.legajo, apellidos, nombres, apodos, sexo, paradas.descripcion as para, Lugparada, vivie.descripcion as proc, Lugvivienda, edadcalc(f_nacimiento,SujetosEdad,SujetosMeses,SujetosActEdad,null) as edad_c, SujetosDni, deno as TDNI, f_Nacimiento, (select nombre from hogares_admision left join dispositivos on admi_hogar=dispositivos.id where sujetos.legajo=admi_legajo and admi_alta is not null and admi_baja is null) as hoga, rib_anio,rib_numero,rib_reparticion from sujetos ";
 $sql=$sql." left outer join localidades as paradas on paradas.idlocalidades=locparada ";
 $sql=$sql." left outer join tablas on tablas.tipo='TD' and valo=TipoDNI ";
 $sql=$sql." left outer join localidades as vivie on vivie.idlocalidades=locvivienda where (".$cerra." ";

 if(intval($frase)!=0) {$sql=$sql." and (sujetos.legajo=".$frase." or sujetosDNI=".$frase." or rib_numero=".$frase.") ";}
 else{
    if(substr($frase,0,3)=="RIB"){
     $anio=substr($frase,4,4);
     $reparticion="";
     $t=substr($frase,9);
     $primer_guion=strpos($t,"-");
     $numero=substr($t,0,$primer_guion);
     $t=substr($t,$primer_guion+1);
     if(substr($t,0,2)==" -"){$t=substr($t,2);};
     $sql=$sql." and rib_anio=".$anio." and rib_numero=".$numero." and rib_reparticion=".tsql($t);		
    }
    else {
 	$salida=array();
 	$palabras=parsea($frase);
 	foreach ($palabras as &$palabra) {
    		$da = un_registro("select lex_sonido('".$palabra."') as son");
    		$sql=$sql." and sonidos like '%".$da['son']."%' ";
 	};
   };
 };
 $sql=$sql.")";
 if($h18){$sql=$sql." and edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,null)<=18";};
  if($alojados){$sql=$sql." having hoga >''";};
  $sql=$sql ." order by apellidos, nombres limit 15";

 return  $sql;
}

function buscador_pibes_lt($frase) {
  $sql="select sujetos.legajo, apellidos, nombres from sujetos where cerrado<>1 ";
 if(intval($frase)>0) {$sql=$sql." and (sujetos.legajo=".$frase." or sujetosDNI=".$frase.") ";}
 else{
    
    $salida=array();
    $palabras=parsea($frase);
    foreach ($palabras as &$palabra) {
            $da = un_registro("select lex_sonido('".$palabra."') as son");
            $sql=$sql." and sonidos like '%".$da['son']."%' ";
    };
   
 };
 $sql=$sql ." order by apellidos, nombres limit 10";
 return  $sql;
}



function buscador_personas($frase) {

 $sql="select idpersonas, apellidos, nombres,  genero, edadcalc(f_nacimiento,edad,0,fecha_actualizacion,null) as edad_c, nrodoc, deno as TDNI, f_Nacimiento from personas ";

 $sql=$sql." left outer join tablas on tipo='TD' and valo=nrodoc ";

 $sql=$sql." where ";



 if(intval($frase)!=0) {$sql=$sql." (idpersonas=".$frase." or nrodoc=".$frase.") ";}

 else {

 $salida=array();

 $palabras=parsea($frase);

 $prim=1;

 foreach ($palabras as &$palabra) {

    $da = un_registro("select lex_sonido('".$palabra."') as son");

    if($prim==1) {$sql=$sql."  sonidos like '%".$da['son']."%' ";} else {$sql=$sql." and sonidos like '%".$da['son']."%' ";};

    $prim=0;};

 };

 $sql=$sql." order by apellidos, nombres";

 return  $sql;

}



function buscador_familias($frase) {

 $sql="select idaf_familias, denominacion from af_familias ";

 $sql=$sql." left outer join personas on persona=idpersonas ";

 $sql=$sql." where ";



 if(intval($frase)!=0) {$sql=$sql." (registro_unico=".$frase." or nrodoc=".$frase.") ";}

 else {

 $salida=array();

 $palabras=parsea($frase);

 $prim=1;

 foreach ($palabras as &$palabra) {

    $da = un_registro("select lex_sonido('".$palabra."') as son");

    if($prim==1) {$sql=$sql."  lex_sonido(denominacion) like '%".$da['son']."%' ";} else {$sql=$sql." and lex_sonido(denominacion) like '%".$da['son']."%' ";};

    $prim=0;};

 };

 $sql=$sql." order by apellidos, nombres";

 return  $sql;

}


function si($condicion,$vv,$vf){

if($condicion==true) return $vv;

return $vf;

}



/* Fin De consulta de Nivel 2 a Base de Datos */



/* A Clasificar */





function pega($orig,$nuevo) {

$resu="";

if($orig!="") $resu=$orig.", ";

$resu=$resu.$nuevo;

return $resu;

};



function axel($texto){

return utf8_encode($texto);

};



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





function crea_sujeto(){

    $legajo = un_campo("select max(legajo)+1 as leg from sujetos");

    ejecute("insert into sujetos(legajo,usuario,genero) values(".$legajo.",".tsql($_SESSION["glusua"]).",0)");

    ejecute("insert into sujetos_juridicos(legajo) values(".$legajo.")");

    return $legajo;

}



function envia_unamedida($id){
$r=un_registro("select legajo, archivo from sujetos_medidas where idsujetos_medidas=".$id);
$lega=$r["legajo"];
$arch=$r["archivo"];
$hoga=un_campo("select admi_hogar from hogares_admision where admi_legajo=".$lega." and admi_alta is not null and admi_baja is null");
if($hoga!="") {
 $rh=un_registro("select nombre, hogares_mail from dispositivos where dispositivos.id=".$hoga);
 if($rh["hogares_mail"]!="") {
   $mhog=strtolower($rh["hogares_mail"]);
   $nhog=$rh["nombre"];
   $apyn=un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$lega);
   $ruta=un_campo("select as_path from archivos_subidos where idarchivos_subidos=".$arch);
   if($ruta!=""){
     error_reporting(E_STRICT);
     require 'vendor/autoload.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
  
     $mail->IsSMTP(); // telling the class to use SMTP
     $mail->SMTPTimeOut = 260; 
     $mail->SMTPDebug = 0; 
     $mail->SMTPSecure    = "tls";                // enable SMTP authentication
     $mail->SMTPAuth      = true;                  // enable SMTP authentication
     $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
     $mail->Host          = "smtppro.zoho.com";// sets the SMTP server
     $mail->Port          = 587;                    // set the SMTP port for the GMAIL server
     $mail->Username      = "notificacioncdnnya@undato.com.ar"; // SMTP account username
     $mail->Password      = "718Q21_Mi";
     $mail->SetFrom('notificacioncdnnya@undato.com.ar', 'Notificaciones CDNNYA');
     $mail->AddReplyTo('iaguirre@buenosaires.gob.ar', 'Ignacio Aguirre');
     $mail->Subject       = "Medida Excepcional (MEX) - CDNNYA";
     $mail->MsgHTML("<html>At. Hogar <strong>".$nhog."</strong><br>Adjuntamos medida de ".utf8_encode($apyn)."<br><br><br><br>Mensaje generado autom&aacute;ticamente por SURNNYA<br>Por favor no responder a esta direcci&oacute;n de mail.</html>");
     $mail->AddAddress($mhog, $nhog);
     $mail->AddAttachment($ruta,"medida".utf8_encode($apyn).".pdf");     
     if(!$mail->Send()) {
     } else {
	ejecute("update sujetos_medidas set hogar=".$hoga.", email=".tsql($mhog).", envio=curdate() where idsujetos_medidas=".$id);     };
     // Clear all addresses and attachments for next loop
     $mail->ClearAddresses();
     $mail->ClearAttachments();
    };
  };
 };
ejecute("update sujetos_medidas set intentos=intentos+1 where idsujetos_medidas=".$id);
return true;
}

function envia_unaderivacion($id){
$r=un_registro("select legajo, nota_derivacion, hogar from altasybajas where idaltasybajas=".$id);
$lega=$r["legajo"];
$arch=$r["nota_derivacion"];
$hoga=$r["hogar"];
 $rh=un_registro("select nombre, hogares_mail from dispositivos where dispositivos.id=".$hoga);
 if($rh["hogares_mail"]!="") {
   $mhog=strtolower($rh["hogares_mail"]);
   $nhog=$rh["nombre"];
   $apyn=un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$lega);
   $ruta=un_campo("select as_path from archivos_subidos where idarchivos_subidos=".$arch);
   if($ruta!=""){
     error_reporting(E_STRICT);
     require 'vendor/autoload.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
  
     $mail->IsSMTP(); // telling the class to use SMTP
     $mail->SMTPTimeOut = 260; 
     $mail->SMTPDebug = 0; 
     $mail->SMTPSecure    = "tls";                // enable SMTP authentication
     $mail->SMTPAuth      = true;                  // enable SMTP authentication
     $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
     $mail->Host          = "smtppro.zoho.com";// sets the SMTP server
     $mail->Port          = 587;                    // set the SMTP port for the GMAIL server
     $mail->Username      = "notificacioncdnnya@undato.com.ar"; // SMTP account username
     $mail->Password      = "718Q21_Mi";
     $mail->SetFrom('notificacioncdnnya@undato.com.ar', 'Notificaciones CDNNYA');
     $mail->AddReplyTo('iaguirre@buenosaires.gob.ar', 'Ignacio Aguirre');
     $mail->Subject       = "Nota Derivaci&oacute;n ".$apyn;
     $mail->MsgHTML("<html>At. Hogar <strong>".$nhog."</strong><br>Adjuntamos nota derivaci&oacute;n de ".$apyn."<br><br><br><br>Mensaje generado autom&aacute;ticamente por SURNNYA<br>Por favor no responder a esta direcci&oacute;n de mail.</html>");
     $mail->AddAddress($mhog, $nhog);
     $mail->AddAttachment($ruta,sacamas_limpia(sacapath($ruta)));     
     if(!$mail->Send()) {
     } else {
        ejecute("update altasybajas set email=".tsql($mhog).", envio=curdate() where idaltasybajas=".$id);
     };
     // Clear all addresses and attachments for next loop
     $mail->ClearAddresses();
     $mail->ClearAttachments();
    };
   };
ejecute("update altasybajas set intentos=intentos+1 where idaltasybajas=".$id);
return true;
}
function rib($anio,$numero,$reparticion){
 if($anio==""){return "";}
 else{
   return "RIB-".$anio."-".intval($numero)."-".trim($reparticion);
 };
}
function rib2($r){
 if($r["rib_anio"]==""){return "";}
 else{
   return "RIB-".$r["rib_anio"]."-".intval($r["rib_numero"])."-".trim($r["rib_reparticion"]);
 };
}

function estado1($e){
  if($e==1) {return "Admitida";};
  if($e==2) {return "En evaluaci&oacute;n";};
  if($e==3) {return "Con evaluaci&oacute;n negativa";};
  if($e==4) {return "Desisti&oacute;";};
  return "";
}
function estado2($e){
  if($e==1) {return "Disponible acogimiento";};
  if($e==2) {return "Disponible apoyo";};
  if($e==3) {return "Disponible acogimiento y apoyo";};
  if($e==4) {return "Acogimiento";};
  if($e==5) {return "Apoyo";};
  if($e==6) {return "Acogimiento y apoyo";};
  if($e==7) {return "Acogimiento con disponibilidad de apoyo";};
  if($e==8) {return "Apoyo con disponibilidad de acogimiento";};
  if($e==9) {return "Pausa";};
  if($e==10) {return "Observada";};
  if($e==11) {return "Baja";};
  return ""; 
 }

function envia_unanota($id){
$r=un_registro("select legajo, operacion, fecha_operacion, hogar, nota, hogar from altasybajas where idaltasybajas=".$id);
$lega=$r["legajo"];
$arch=$r["nota"];
$hoga=un_campo("select nombre from dispositivos where dispositivos.id=".$r["hogar"]);
$destinatario="hogares@mptutelar.gob.ar";
$apyn=un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$lega);
$ruta=un_campo("select as_path from archivos_subidos where idarchivos_subidos=".$arch);
if($ruta!=""){
  require 'vendor/autoload.php';
  $mail = new PHPMailer\PHPMailer\PHPMailer(true);
  
  $mail->IsSMTP(); // telling the class to use SMTP
  $mail->SMTPTimeOut = 260; 
  $mail->SMTPDebug = 0; 
  $mail->SMTPSecure    = "tls";                // enable SMTP authentication
  $mail->SMTPAuth      = true;                  // enable SMTP authentication
  $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
  $mail->Host          = "smtppro.zoho.com";// sets the SMTP server
  $mail->Port          = 587;                    // set the SMTP port for the GMAIL server
  $mail->Username      = "notificacioncdnnya@undato.com.ar"; // SMTP account username
  $mail->Password      = "718Q21_Mi";
  $mail->SetFrom('notificacioncdnnya@undato.com.ar', 'Notificaciones CDNNYA');
  $mail->AddReplyTo('iaguirre@buenosaires.gob.ar', 'Ignacio Aguirre');
  $mail->Subject       = "Nota ".si($r["operacion"]=="A","Alta","Baja")." del dispositivo ".sacamas_limpia(utf8_decode($hoga));
  $mail->MsgHTML("<html>At. <strong>MPT - Hogares</strong><br>Adjuntamos Nota ".si($r["operacion"]=="A","Alta","Baja")." de ".
   sacamas_limpia(utf8_decode($apyn))." del dispositivo ".sacamas_limpia(utf8_decode($hoga))."<br>
   <br>Mensaje generado autom&aacute;ticamente por SURNNYA<br>Por favor no responder a esta direcci&oacute;n de mail.</html>");
     $mail->AddAddress($destinatario, "MPTutelar CABA");
     $mail->AddAddress("iaguirre@buenosaires.gob.ar", "Ignacio Aguirre");
     $mail->AddAttachment($ruta,sacamas_limpia(sacapath($ruta)));     
     if(!$mail->Send()) {
	die("error");
     } else {
        ejecute("update altasybajas set mails_notaaltabaja=".tsql($destinatario).", envio_notaaltabaja=curdate() where idaltasybajas=".$id);
     };
     // Clear all addresses and attachments for next loop
     $mail->ClearAddresses();
     $mail->ClearAttachments();
  };
  ejecute("update altasybajas set intentos_notaaltabaja=intentos_notaaltabaja+1 where idaltasybajas=".$id);
 
return true;
}

function e_get($objeto,$celda){

return utf8_decode($objeto->getActiveSheet()->getCell($celda)->getValue()); 

}

function caso($r){
if($r["codigo_anio"]==0) return "";
return $r["codigo_sector"]."-".substr("000000".$r["codigo_numero"],-6)."/".$r["codigo_anio"];
}

function showsex($s){
 if($s=="M") return "Masculino";
 if($s=="F") return "Femenino";
 if($s=="X") return "X Otros";
 return "";
}

function casoj($r){
 return $r["numero"]."/".$r["anio"];
}

function aja_situacion($r){
  $s="";
  if($r["fecha_derivacion"]!=""){
    $s="DERIVADO";
    if($r["resp1"]!=""){$s=$s."<br>R:".ffec($r["resp1"]);}
    else{$s=$s."<br>N1 S/R";}; 
  }
  else{$s="ABIERTO";};
  if($r["fecha_d2"]!=""){
    if($r["resp2"]!=""){$s="CERRADO<br>N2 R:".ffec($r["resp2"]);}
    else{$s="DERIVADO<br>N2 ".ffec($r["fecha_d2"])." S/R";};
  };
  if($r["fecha_d3"]!=""){
    if($r["resp3"]!=""){$s="CERRADO<br>N3 R:".ffec($r["resp3"]);}
    else{$s="DERIVADO<br>N3 ".ffec($r["fecha_d3"])." S/R";};
  };
  if($r["fecha_d4"]!=""){
    $s="CERRADO N4 ".ffec($r["fecha_d4"]);
    if($r["resp4"]!=""){$s=$s."<br>R:".ffec($r["resp4"]);};
  };
  return $s;
}

function cuil($c){
  return substr($c,0,2) . "-". substr($c,2,11)."-".substr($c,-1);
}

// Gabinete de salud
function inicioyfin($idaccion){
   $a=un_registro("select * from es_acciones where id=".$idaccion);
   if($a["estado"]=="2"){
	$s=un_registro("select * from es_participaciones where id=".$a["solicitud"]);
        if(ffec($s["fecha_inicio"])==""){
	  ejecute("update es_participaciones set fecha_inicio=".fsql(ffec($a["fecha"])).", motivo_estado='Primera respuesta'  where id=".$s["id"]);	
        };
       	if($a["tipo"]=="1"||$a["tipo"]=="5"||$a["tipo"]=="2") {
		ejecute("update es_participaciones set fecha_fin=".fsql(ffec($a["fecha"])).", motivo_estado='Accion responde solicitud' where id=".$s["id"]);
	};
   };
	
}
function envia_logs($texto){
  $texto=$_SESSION['glusua'].":".$texto;
  $ch = curl_init("https://undato.com.ar/logs/?sistema=SURNNYA&texto=".$texto);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  $resultado=curl_exec($ch);
  curl_close($ch);
  return true;
}

function envia_unmail(){
  require 'vendor/autoload.php';
  $mail = new PHPMailer\PHPMailer\PHPMailer(true);
  $mail->IsSMTP(); // telling the class to use SMTP
  $mail->SMTPTimeOut = 260; 
  $mail->SMTPDebug = 0; 
  $mail->SMTPSecure    = "tls";                // enable SMTP authentication
  $mail->SMTPAuth      = true;                  // enable SMTP authentication
  $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
  $mail->Host          = "smtppro.zoho.com";// sets the SMTP server
  $mail->Port          = 587;                    // set the SMTP port for the GMAIL server
  $mail->Username      = "notificacioncdnnya@undato.com.ar"; // SMTP account username
  $mail->Password      = "718Q21_Mi";
  $mail->SetFrom('notificacioncdnnya@undato.com.ar', 'Notificaciones CDNNYA');
  $mail->AddReplyTo('iaguirre@buenosaires.gob.ar', 'Ignacio Aguirre');
  $mail->Subject       = "Test mailer";
  $mail->MsgHTML("<html>Texto prueba<br>
   <br>Mensaje generado autom&aacute;ticamente por SURNNYA<br>Por favor no responder a esta direcci&oacute;n de mail.</html>");
     
     $mail->AddAddress("iaguirre@buenosaires.gob.ar", "Ignacio Aguirre");
     
     if(!$mail->Send()) {
    die("error");
     } else {
     
     };
     // Clear all addresses and attachments for next loop
     $mail->ClearAddresses();
     $mail->ClearAttachments();
  
  
return true;
}

?>