<?php
session_start();
require("funciones.php"); 
$idges=nget("idges");
$g=un_registro("select * from movil_gestiones where id=".$idges);
$id=$g["viaje"];
$v=un_registro("select * from movil_viajes where id=".$id);
$fecha=ffec($v["fecha"]);

?>
<script>
resp=eje("val_revisar?id=<?php echo $id?>");

if(resp!="ok"){
  alert("no pas&oacute; revisi&oacute;n");
  navega("mv_gestiones");};
</script>
<?php 
ejecute("update movil_gestiones set usuario_control=".tsql($_SESSION['nusuario'])." where id=".$idges);
$tipoges=un_campo("select tipo_gestion from movil_gestiones where id=".$idges);
$ok=un_campo("select case when ".fsql($fecha)."=curdate() then case when ".tsql($v["hora"])."<curtime() then 'ok' else 'nook' end else 'ok' end from dual");
if($ok!="ok"){
  $_SESSION["msg"]="Viaje no pudo ser agregado";
  $_SESSION["retorno"]="mv_gestiones";
  Redirect("aviso");
}  
$cosa=valoriza($id);
if($tipoges=="Agregar"){
          $regi=un_registro("select * from movil_procesos where ".fsql($fecha)." between desde_ab and hasta");
          if($regi["id"]>"0"){
            if($regi["b2_6"]=="1"){
              $bandeja="7";
              $bloqueo="2";
              $f_solicitud=$regi["fecha_hoy"];
              $estado="APR";
            }
            else{
              $bandeja="6";
              $bloqueo="1";
              $f_solicitud=$regi["fecha_hoy"];
              $estado="APR";
            }  
          }
          else{
            $_SESSION['msg']="No se encontr&oacute; fecha de proceso";
            $_SESSION['retorno']="mv_gestiones";
            Redirect("aviso");            
          }        
        }
else if($tipoges=="Agregar CMR"){
          $oper=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
          if($oper["b2_6"]=="1"){
            $bandeja="7";
            $bloqueo="2";
            $f_solicitud=$oper["fecha_hoy"];
            $estado="APR";
          }
          else{
            $bandeja="6";
            $bloqueo="1";
            $f_solicitud=$oper["fecha_hoy"];
            $estado="APR";
          }
          
};
ejecute("update movil_gestiones set estado='APR' where id=".$idges);
ejecute("update movil_viajes set bandeja=".$bandeja.", bloqueo=".$bloqueo.",estado=".tsql($estado)." , f_solicitud=".fsql(ffec($f_solicitud)).", observaciones='Agregado gestion ".$idges."' where id=".$id);
if($bandeja=="7"){          Redirect("mv_notif_agregar?id=".$id);};
$_SESSION["retorno"]="mv_gestiones";
$_SESSION['msg']="Viaje agregado como aprobado";
Redirect("aviso");
?>
