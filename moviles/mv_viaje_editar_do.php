<?php
session_start();
include("funciones.php");
$id = nget("id");
$viaje = un_registro("select * from movil_viajes where id=" . $id);
$dispositivo = $viaje["dispositivo"];
$sector=$viaje["sector"];
$tipo_movil=nget("tipo_movil");
$hora = tget("hora");
$fecha=str_replace("-","",$_GET["fecha"]);
$empresa=nget("empresa");
$pasajeros_alojados = nget("pasajeros_alojados");
// control previo, revisa los pasajeros alojados, que no tengan viajes muy cercanos
// lista de legajos para control posterior
$lista="(";
for($i=1; $i<=intval($pasajeros_alojados);$i++){
  $legajo=nget("lega".$i);
  $lista=$lista.si($lista=="(","",",").$legajo;
};
$lista=$lista.")";
$err_fecha=0;
if($lista!="()"){
if($dispositivo>"0"){
 $oviajes=registros("select legajo,hora from movil_pasajeros left join movil_viajes on viaje=movil_viajes.id where estado<>'REC' and fecha=".$fecha." and legajo in ".$lista." and viaje <>".$id. " and dispositivo=".$dispositivo);


while($ov=mysqli_fetch_assoc($oviajes)){
  if(dh($ov["hora"],$_GET["hora"])<65){
    $err_fecha=1;
    
  }
  
};
};
};

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
$dist_calc=nget("dis_total");


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





$pasajeros_acompaniantes = nget("pasajeros_acompaniantes");
$motivo_recurso = nget("motivo_recurso");

$comentarios = tget("comentarios");

ejecute(
  "update movil_viajes set fecha=".$fecha.",tipo_movil=".$tipo_movil.",hora=" . $hora .
  ", partida=" . $par_f .
  ", destino_1=" . $de1_f .
  ", destino_2=" . $de2_f .
  ", destino_3=" . $de3_f .
  ", destino_4=" . $de4_f .
  ", distancia_calculada=" . $dist_calc .
  ", pasajeros_alojados=" . $pasajeros_alojados .
  ", pasajeros_acompaniantes=" . $pasajeros_acompaniantes .
  ", motivo_recurso=" . $motivo_recurso .
  ", comentarios=" . $comentarios .
  ", empresa=".$empresa.
  " where id=" . $id
);

// pasajeros alojados
ejecute("delete from movil_pasajeros where viaje=" . $id." and tipo_pasajero=1");
for ($i = 1; $i <= intval($pasajeros_alojados); $i++) {
  $apellidonombre = tget("p" . $i);
  $legajo = nget("lega" . $i);
  if ($legajo > "100") {
    $rlegajo = un_registro("select nombres from sujetos where legajo=" . $legajo);
    inserte(
      "insert into movil_pasajeros(viaje,tipo_pasajero,
      pas_nombre,legajo) values(" . $id . ",1," .
      tsql($rlegajo["nombres"]) . "," . $legajo . ")"
    );
  } else {
    die("leg:" . $legajo . " i:" . $i);
  }
}
// pasajeros acomp
ejecute("delete from movil_pasajeros where viaje=" . $id." and tipo_pasajero=2");

for ($i = 1; $i <= intval($pasajeros_acompaniantes); $i++) {
  $nombre = tget("a" . $i);
  $celular = tget("acel" . $i);
  if($celular!="''"){
  inserte("insert into movil_pasajeros(viaje,tipo_pasajero,
    pas_nombre,celular)   values(" .
    $id . ",2," .  $nombre .  "," . $celular . ")"
  );
  };
  
  }




// controles adicionales
if($err_fecha==0){
ejecute("update movil_viajes set estado='PRO' , observaciones=null where id=" . $id);}
else{
ejecute("update movil_viajes set estado='OBS' , observaciones='Otro viaje con fecha y hora muy cercana' where id=" . $id);
};

$msg = "Viaje #" . $id . " editado ";
$_SESSION["msg"] = $msg;
$_SESSION["retorno"]="mv_viajes_ver";
Redirect("aviso");


?>
