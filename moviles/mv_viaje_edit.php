<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Editar viaje";
include("encabezado.php");

$id=nget("id");
$oper=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
$b1="b1_6";
$fini=$oper["desde_ab"];
if($oper[$b1]>"0" && $_SESSION['perfil_moviles']=="1") {$fini=$oper["desde_db"];}
;     

$v=un_registro("select * from movil_viajes where id=".$id);
if($_SESSION["perfil_moviles"]=="1"){
if($v["dispositivo"]>"0"){$dispositivo=$v["dispositivo"];
  $tipo_dispositivo="Dispositivo";
  if($_SESSION["hogar"]!=$dispositivo) {
    $_SESSION["msg"]="Viaje de otro dispositivo ".$_SESSION["dispositivo"];
    $_SESSION["retorno"]='mv_vdispo_ver';
    Redirect("aviso");
  }
};
if($v["sector"]>"0"){$dispositivo=$v["sector"];
   $tipo_dispositivo="Sector";
   if($_SESSION["sector"]!=$dispositivo) {
    $_SESSION["msg"]="Viaje de otro sector";
    $_SESSION["retorno"]='mv_vdispo_ver';
    Redirect("aviso");
  }
};
if($v["bandeja"]!=$_SESSION["bandeja"]){
    $_SESSION['msg']="El viaje no est&aacute; en tus bandejas";
    Redirect("aviso");
}
};

if($v["fecha"]<$fini && $v["gestion"]=="0"){
    $_SESSION['msg']="Fecha anterior a la permitida";
    Redirect("aviso");
}


$estado=$v["estado"];
if($v["observaciones"]!=""){
 $estado=$estado." ".$v["observaciones"];
}


?>
</div>

<div class="container">
    <div class="row">
        <h5 class="col-md-12">Fecha <?php echo ffec($v["fecha"])?>&nbsp;Estado <?php echo $estado;?></h5>
    </div>
    <div class="row">
        <h5 class="col-md-12">Opciones de edici&oacute;n</h5>
    </div>
 
  <ul class="list-group col-md-12">
    <li class="list-item col-md-6"><a href='mv_edit_hora?id=<?php echo $id?>'>Hora de salida <?php echo substr($v["hora"],0,5)?></a></li>
    <li class="list-item col-md-6"><a href='mv_edit_recorrido?id=<?php echo $id?>'>Recorrido <?php echo $v["partida"]." -> ".$v["destino_1"]?></a></li>
    <li class="list-item col-md-6"><a href='mv_edit_distancia?id=<?php echo $id?>'>Km.<?php echo $v["distancia_calculada"]?>, tipo <?php echo $v["tipo_movil"]?>, espera <?php echo $v["hora_adicional"]." h,".$v["minutos_adicionales"]*10?></a></li>
    <li class="list-item col-md-6"><a href="mv_edit_pas_nnya?id=<?php echo $id?>">Pasajeros
alojados <?php echo $v["pasajeros_alojados"]?></a></li>
<li class="list-item col-md-6"><a href="mv_edit_pas_acom?id=<?php echo $id?>">Pasajeros acompa&ntilde;antes 
<?php echo $v["pasajeros_acompaniantes"]?></a></li>
    <li class="list-item col-md-6"><a href="mv_edit_otros?id=<?php echo $id?>">Otros (motivo, comentarios <?php echo $v["comentarios"]?>)</a></li>
  
  </ul>  
 
</div>




</body>