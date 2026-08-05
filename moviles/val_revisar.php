<?php
session_start();
include("funciones.php");
$id=nget("id");
$bandeja=$_SESSION["bandeja"];
$bandejas="X".$bandeja;
if($_SESSION["supervisa"]=="B13"){
    $bandejas="X16789";
}
$oper=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
$b1="b1_6";
$fini=$oper["desde_ab"];
if($oper[$b1]>"0" && $_SESSION["perfil_moviles"]=="1") {$fini=$oper["desde_db"];}
;     
$v=un_registro("select * from movil_viajes where id=".$id);
$estado_ant=$v["estado"];
$errores="";

if($v["fecha"]<$fini && $v["gestion"]=="0"){
    $_SESSION['msg']="Fecha anterior a la permitida";
    $errores=si($errores=="","",$errores.", ")."Fecha anterior a la permitida";
}
if($v["fecha"]<$fini && $v["gestion"]!="0"){
    $vfecha=fsql(ffec($v["fecha"]));
    $f_proc=un_campo("select fecha_hoy from movil_procesos where desde_ab<=".$vfecha." and ".$vfecha."<=hasta");
    if($f_proc==""){
        $errores=si($errores=="","",$errores.", ")."Fecha anterior a la permitida";
    } else {
        ejecute("update movil_viajes set f_solicitud=".fsql(ffec($f_proc))." where id=".$id);
    }
}

if(strpos($bandejas,$v["bandeja"])==0 && $v["bandeja"]!="80" && 
    $_SESSION['perfil_moviles']=="1"){
    $_SESSION["retorno"]=$_SESSION['menu'];
    $_SESSION['msg']="El viaje no est&aacute; en tus bandejas";
    Redirect("aviso");
}
if($v["dispositivo"]!=$_SESSION["hogar"] &&$v["sector"]!=$_SESSION["sector"] && $_SESSION["perfil_moviles"]=="1") {
    $_SESSION["retorno"]=$_SESSION['menu'];
    $_SESSION['msg']="El viaje no est&aacute; en tu dispositivo";
    Redirect("aviso");
}
// validacion legajo fecha hora
$errolfh=0;
$lista="(";
$nnya=registros("select distinct legajo from movil_pasajeros where viaje=".$id." and tipo_pasajero=1 and legajo>0");
while($n=mysqli_fetch_assoc($nnya)){
  $lista=$lista.si($lista=="(","",",").$n["legajo"];
};
$lista=$lista.")";

if($lista!="()"){
     $oviajes=registros("select legajo,hora from movil_pasajeros left join movil_viajes on viaje=movil_viajes.id where tipo_pasajero=1 and estado<>'REC'  and fecha=".$v["fecha"]." and legajo in ".$lista." and viaje<>".$id);}
     

while($ov=mysqli_fetch_assoc($oviajes)){
  $h1=substr($ov["hora"],0,5);
  $h2=$substr($v["hora"],0,5);
  $difh=dh($h1,$h2);
  if($difh<65) {
    $errolfh=1;
     break;
   } 
    
};
if($errolfh==1){
  $errores=si($errores=="","",$errores.", ")."Otro viaje con hora cercana";
    
};

// partida y destino 1

if($v["partida"]==""||$v["destino_1"]==""){
  $errores=si($errores=="","",$errores.", ")."Partida y destino_1 obligatorios";
}
else{
  $pba=0;  
  $partida = $v["partida"];
  $par_f = tsql(formatea_dom($partida));
  if(strpos($par_f,"CABA")==false){$pba=1;};
  $destino_1 = $v["destino_1"];
  $de1_f = tsql(formatea_dom($destino_1));
  if(strpos($de1_f,"CABA")==false){$pba=1;};
  $destino_2 = "";
  $destino_3 = "";
  $destino_4 = "";
  $de2_f = "null";
  $de3_f = "null";
  $de4_f = "null";

  if ($v["destino_2"] != "") {
    $destino_2=$v["destino_2"];
    $de2_f = tsql(formatea_dom($destino_2));
    if(strpos($de2_f,"CABA")==false){$pba=1;};

    if ($v["destino_3"]!="") {
      $destino_3 = $v["destino_3"];
      $de3_f = tsql(formatea_dom($destino_3));
      if(strpos($de3_f,"CABA")==false){$pba=1;};
        if ($v["destino_4"]!="") {
          $destino_4 = $v["destino_4"];
          $de4_f = tsql(formatea_dom($destino_4));
          if(strpos($de4_f,"CABA")==false){$pba=1;};
          }
        }
  }
ejecute("update movil_viajes set partida=".$par_f.
  ",destino_1=".$de1_f.
  ",destino_2=".$de2_f.
  ",destino_3=".$de3_f.
  ",destino_4=".$de4_f.
  " where id=".$id);    
};


// verificar si es viaje PBA renglon 7
$tipo_tipo=$v["tipo_tipo"];

$renglon=$v["tipo_movil"];
$rng=un_registro("select * from movil_renglones where id=".$renglon);

if($pba==1 && $tipo_tipo=="1" && $renglon!="7"){
  $errores=si($errores=="","",$errores.", ")."Rengl&oacute;n no es remise PBA y el viaje contiene puntos en PBA";
}
if($pba==0 && $tipo_tipo=="1" && $renglon=="7"){
  $errores=si($errores=="","",$errores.", ")."Rengl&oacute;n remise PBA y viaje no contiene puntos en PBA";
}
// en remises partida no puede ser destino final
$ud=$destino_4;
if($ud=="") $ud=$destino_3;
if($ud=="") $ud=$destino_2;
if($ud=="") $ud=$destino_1;

if((intval($renglon)==4  || intval($renglon)==6) && $ud==$partida){
  $errores=si($errores=="","",$errores.", ")."Destino=Partida en Remise I/V CABA";
}

// distancia obligatoria

$distancia=intval($v["distancia_calculada"]);
if(!$distancia>0){
  $errores=si($errores=="","",$errores.", ")."Distancia obligatoria";
}

// tipo_tipo

if($tipo_tipo!=$rng["tipo"]){
  $errores=si($errores=="","",$errores.", ")."Tipo Veh- tipo movil";
}

//r y distancia

if($rng["distancia_maxima"]<$distancia && $rng["distancia_maxima"]>"0"){
      $errores=si($errores=="","",$errores.", ")."Km > máximo";
 };
 
 if($rng["distancia_minima"]>$distancia && $rng["distancia_minima"]>"0"){
      $errores=si($errores=="","",$errores.", ")."Km < mínimo";
 }
 
 
 if($rng["es_iv"]=="0" && $tipo_tipo=="1" && intval($v["hora_adicional"])+intval($v["minutos_adicionales"])>0){
       $errores=si($errores=="","",$errores.", ")."Tipo no I/V y se solicita espera";
 }
 
 if(intval($v["hora_adicional"])==0 && intval($v["minutos_adicionales"]>=6)){
    $errores=si($errores=="","",$errores.", ")."minutos>=60 sin hora";
 }

 
 if($renglon=="7"){
  if(intval($v["b10_km"])<=0){
    $errores=si($errores=="","",$errores.", ")."remise PBA sin bloque 10 km";
  }
 }
 else{
  if(intval($v["b10_km"])>0){
    $errores=si($errores=="","",$errores.", ")."viaje no remise PBA con bloque 10 km";
  }
 }

 
 if(intval($v["hora_adicional"])+intval($v["minutos_adicionales"])>0 || $v["destino_2"]!="" || $distancia>3){
  if($renglon=="1"){
       $errores=si($errores=="","",$errores.", ")."combi jornada simple no corresponde";
  }
 }
 
 
 if($tipo_tipo=="2" && $v["empresa"]!="2"){
       $errores=si($errores=="","",$errores.", ")."combi no corresponde a empresa";
 }


 $cntalo=un_campo("select count(*) from movil_pasajeros where viaje=".$id." and tipo_pasajero=1");
 if($cntalo!=$v["pasajeros_alojados"]){
    $errores=si($errores=="","",$errores.", ")."cant pas alojados no corresponde";
 }
 
 $cntaco=un_campo("select count(*) from movil_pasajeros where viaje=".$id." and tipo_pasajero=2");
 if($cntaco!=$v["pasajeros_acompaniantes"]){
   $errores=si($errores=="","",$errores.", ")."cant pas acomp no corresponde";
 
 }
 
 if($v["dispositivo"]>"0" && ($cntalo==0||$cntaco==0)){
     $errores=si($errores=="","",$errores.", ")."Se requiere al menos 1 alojado y un acompa&ntilde;ante";
 }
 
 if($v["sector"]>"0" && $cntaco==0){
     $errores=si($errores=="","",$errores.", ")."Se requiere al menos 1 adulto";
 }

 $cntpas=intval($cntalo)+intval($cntaco);
 
 if($cntpas>$rng["capacidad_max"]){
    $errores=si($errores=="","",$errores.", ")."Se excede la cantidad m&aacute;xima de pasajeros";
 }
 
 if($cntpas<$rng["capacidad_min"]){
    $errores=si($errores=="","",$errores.", ")."La cantidad de pasajeros es menor a la cantidad m&iacute;nima";
 }
 
 

$pasadu=registros("select * from movil_pasajeros where viaje=".$id." and tipo_pasajero=2");
while($p=mysqli_fetch_assoc($pasadu)){
    if($p["celular"]==""){$errores=si($errores=="","",$errores.", ")."celular adulto ".$p["pas_nombre"]." faltante";};
    if(strlen($p["celular"])<10 || $p["celular"]=="1100000000"){
        $errores=si($errores=="","",$errores.", ")."Celular adulto ".$p["pas_nombre"]." incorrecto ";
    }
    
    if($p["pas_nombre"]==""){
        $errores=si($errores=="","",$errores.", ")."Adulto sin nombre ni apellido";
    }

}





if($errores==""){
    if($estado_ant!="REC"){
    ejecute("update movil_viajes set estado='PRO' where id=".$id);}
    else{
        ejecute("update movil_viajes set estado='".$estado_ant."' where id=".$id);
    }
    ejecute("update movil_viajes set observaciones=null where id=".$id);
    
    $cosa=valoriza($id);
    echo "ok";
}
else{
  $obse=substr($errores,0,100);
  ejecute("update movil_viajes set estado='OBS', observaciones=".tsql($obse)." where id=".$id);
  echo $obse;
}
;
?>
