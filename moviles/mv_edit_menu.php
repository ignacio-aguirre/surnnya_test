<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Editar viaje";
include("encabezado.php");
$id=nget("id");
$oper=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
$b1="b1_6";
$fini=$oper["desde_ab"];
if($oper[$b1]>"0" && $_SESSION["perfil_moviles"]=="1") {$fini=$oper["desde_db"];}
;     
$retorno=$_SESSION["ret_menu"];
$v=un_registro("select * from movil_viajes where id=".$id);

if($v["dispositivo"]>"0"){$dispositivo=$v["dispositivo"];
  $tipo_dispositivo="Dispositivo";
  if($_SESSION["hogar"]!=$dispositivo && $_SESSION['perfil_moviles']=="1") {
    $_SESSION["msg"]="Viaje de otro dispositivo ".$_SESSION["dispositivo"];
    $_SESSION["retorno"]='mv_vdispo_ver';
    Redirect("aviso");
  }
};
if($v["sector"]>"0"){$dispositivo=$v["sector"];
   $tipo_dispositivo="Sector";
   if($_SESSION["sector"]!=$dispositivo && $_SESSION['perfil_moviles']=="1") {
    $_SESSION["msg"]="Viaje de otro sector";
    $_SESSION["retorno"]='mv_vdispo_ver';
    Redirect("aviso");
  }
};

if($v["fecha"]<$fini){
    $_SESSION['msg']="Fecha anterior a la permitida";
    $_SESSION["retorno"]='menu';
    Redirect("aviso");
}

if($v["bandeja"]!=$_SESSION["bandeja"] && $_SESSION["perfil_moviles"]=="1"){
    $_SESSION["retorno"]=$_SESSION['menu'];
    $_SESSION['msg']="El viaje no est&aacute; en tus bandejas";
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
        <h5 class="col-md-12">Continuar a</h5>
    </div>
    <div class="row" align="center">
  <ul class="list-group col-md-12">
    <li class="list-item col-md-6"><a href='mv_viaje_edit?id=<?php echo $id?>'>Continuar la Edición </a></li>
 
    <li class="list-item col-md-6"><a href='<?php echo $retorno?>'>Volver</a></li>
  </ul>  
 </div>
</div>




</body>