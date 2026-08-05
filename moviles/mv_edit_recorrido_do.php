<?php
session_start(); 
require("funciones.php"); 
$id=nget("id");
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


ejecute("update movil_viajes set partida=".
$par_f.", destino_1=".$de1_f.", destino_2=".$de2_f.", destino_3=".$de3_f.",destino_4=".$de4_f.", estado='OBS', observaciones='Requiere revisión' where id=".$id);
$_SESSION["retorno"]="mv_edit_menu?id=".$id;
$_SESSION["msg"]="Se actualiz&oacute; el recorrido.";
Redirect("aviso?validar=".$id);
?>
