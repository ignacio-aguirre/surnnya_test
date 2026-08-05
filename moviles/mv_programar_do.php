<?php
session_start();
include("funciones.php");
$bandeja=$_SESSION["bandeja"];
$proc=un_registro("select desde_ab,desde_db, fecha_hoy,b1_6 as bl from movil_procesos where id=".$_SESSION['idproceso']);
$fecha=fsql(ffec($_GET["fecha"]));

$desde=fsql(ffec($proc["desde_ab"]));
if($proc["bl"]>"0" && $_SESSION['perfil_moviles']=="1"){
  $desde=fsql(ffec($proc["desde_db"]));
}



$hora_adicional="0";
if(isset($_GET["hora_adicional"])){
if($_GET["hora_adicional"]=="on"){
  $hora_adicional="1";
}
}

$minutos_adicionales=nget("minutos_adicionales");

$hogar="0";
$sector="0";
if($_SESSION["hogar"]>"0"){
    $dispositivo=$_SESSION["hogar"];  
    $hogar=$_SESSION["hogar"];  
    if($_SESSION["perfil_moviles"]=="2" && $fecha>$_SESSION['hoy_s']){
      $bandeja=un_campo("select bandeja from dispositivos where id=".$dispositivo);
    }  
} 
else{
  $dispositivo=$_SESSION["sector"];
  $sector=$_SESSION["sector"];
  if($_SESSION["perfil_moviles"]=="2" && $fecha>$_SESSION['hoy_s']){
      $bandeja=un_campo("select bandeja from sectores where id=".$dispositivo);
    }  
};

if($fecha<$desde && nget("bloqueado")=="0"){
  die("Fecha menor a la permitida");
};

$tipo_movil=nget("tipo_movil");
$tipo_tipo=nget("tipo_tipo");
$hora=tget("hora");
$partida = $_GET["partida"];
$par_f = tsql(formatea_dom($partida));

$destino_1 = $_GET["destino_1"];
$de1_f = tsql(formatea_dom($destino_1));

$destino_2 = "";
$destino_3 = "";
$destino_4 = "";
$de2_f = "null";
$de3_f = "null";
$de4_f = "null";



// 🔧 Corrección de paréntesis faltantes en isset
if (isset($_GET["destino_2"])) {
  $destino_2 = $_GET["destino_2"];
  if ($destino_2 != "") {
    $de2_f = tsql(formatea_dom($destino_2));

    if (isset($_GET["destino_3"])) {
      $destino_3 = $_GET["destino_3"];
      if ($destino_3 != "") {

        $de3_f = tsql(formatea_dom($destino_3));

        if (isset($_GET["destino_4"])) {
          $destino_4 = $_GET["destino_4"];
          if ($destino_4 != "") {

            $de4_f = tsql(formatea_dom($destino_4));
          }
        }
      }
    }
  }
}



$pasajeros_alojados=nget("pasajeros_alojados");
$pasajeros_acompaniantes=nget("pasajeros_acompaniantes");
$motivo_recurso=nget("motivo_recurso");

$comentarios=tget("comentarios");
// control previo, revisa los pasajeros alojados, que no tengan viajes muy cercanos
// lista de legajos para control posterior
$lista="(";
for($i=1; $i<=intval($pasajeros_alojados);$i++){
  $legajo=nget("lega".$i);
  $lista=$lista.si($lista=="(","",",").$legajo;
};
$lista=$lista.")";


if($lista!="()"){
  if($hogar>0){
     $oviajes=registros("select legajo,hora from movil_pasajeros left join movil_viajes on viaje=movil_viajes.id where estado<>'REC' and dispositivo=".$dispositivo." and fecha=".$fecha." and legajo in ".$lista);}
 else{
     $oviajes=registros("select legajo,hora from movil_pasajeros left join movil_viajes on viaje=movil_viajes.id where estado<>'REC' and sector=".$dispositivo." and fecha=".$fecha." and legajo in ".$lista);};
     

while($ov=mysqli_fetch_assoc($oviajes)){
  $h1=substr($ov["hora"],0,5);
  $h2=$_GET["hora"];
echo $h1."<br>";
echo $h2."<br>";  
$difh=dh($h1,$h2);
echo $difh."<br>";  
  if($difh<65){
    
    $_SESSION["msg"]="No pudo guardarse el viaje debido a la fecha y hora";
    $_SESSION["retorno"]="mv_programar";
    Redirect("aviso");
  }
  
};
};


$msg="";
$id=inserte("insert into movil_viajes(
dispositivo,
sector,
fecha,
tipo_tipo,
tipo_movil,
hora,
partida,
destino_1,
destino_2,
destino_3,
destino_4,
distancia_calculada,
b10_km,
hora_adicional,
minutos_adicionales,
pasajeros_alojados,
pasajeros_acompaniantes,
motivo_recurso,
comentarios,
estado,
bandeja,
empresa,usuario) values (".
$hogar.",".$sector.",".$fecha.",".$tipo_tipo.",".$tipo_movil.",".$hora.",".$par_f.",".$de1_f.",".$de2_f.",".$de3_f.",".$de4_f.",".nget("dis_total").",".
nget("b10_km").",".$hora_adicional.",".$minutos_adicionales.",".$pasajeros_alojados.",".$pasajeros_acompaniantes.",".$motivo_recurso.",".$comentarios.",'PRO',".$bandeja.",".nget("empresa").",".tsql($_SESSION["nusuario"]).")");



if(nget("bloqueado")=="1"){
  if(nget("recreativo")=="1"){
  $fs=fsql(ffec(un_campo("select fecha_hoy from movil_procesos where id=".$_SESSION["idproceso"]))); 
  $idges=inserte("insert into movil_gestiones (dispositivo,sector,viaje,tipo_gestion,estado,usuario) values(".$hogar.", ".
    $sector.",".$id.",'Agregar CMR','SOL',".tsql($_SESSION["nusuario"]).")");
  ejecute("update movil_viajes set f_solicitud=".$fs.",bandeja=80,gestion=".$idges." where id=".$id);
}
else{  
  $idges=inserte("insert into movil_gestiones (dispositivo,sector,viaje,tipo_gestion,estado,usuario) values(".$hogar.", ".
    $sector.",".$id.",'Agregar','SOL',".tsql($_SESSION["nusuario"]).")");
  $fs=fsql(ffec(un_campo("select fecha_hoy from movil_procesos where ".$fecha." between desde_ab and hasta")));
  if($fs!=''){
    ejecute("update movil_viajes set f_solicitud=".$fs.",bandeja=80,gestion=".$idges." where id=".$id);
  };  
}
}

// pasajeros 


for($i=1; $i<=intval($pasajeros_alojados);$i++){
  
  $legajo=nget("lega".$i);
  $nombre=tsql(un_campo("select nombres from sujetos where legajo=".$legajo));
  inserte("insert into movil_pasajeros(viaje,tipo_pasajero,pas_nombre,legajo) values(".$id.",1,".$nombre.",".$legajo.")");

}

for($i=1; $i<=intval($pasajeros_acompaniantes);$i++){
  $nombre=tget("a".$i);
  $celular=tget("acel".$i);
    if($celular!="''"){
  inserte("insert into movil_pasajeros(viaje,tipo_pasajero,pas_nombre,celular)
   values(".$id . ",2," . $nombre .  "," . $celular . ")");
  };
};

$cosa=valoriza($id);


$msg="Viaje #".$id." programado "."<br><br>";


$_SESSION["msg"]=$msg;
$_SESSION["retorno"]="mv_programar";
if(nget("bloqueado")=="1"){$_SESSION["retorno"]="menu_gestiones";};
if(nget("administrador")=="1"){
  //die("adm");
  $_SESSION["retorno"]="menu_adm_dg";
  $fecha_solicitud=fsql(ffec($proc["fecha_hoy"]));
  ejecute("update movil_viajes set f_solicitud=".$fecha_solicitud." where id=".$id);
  $_SESSION["hogar"]="0";
  $_SESSION["sector"]="0";
};
Redirect("aviso");


?>
