<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Certificar viaje";
include("encabezado.php");

$id=nget("id");


$v=un_registro("select * from movil_viajes where id=".$id);
if($v["bandeja"]!="7"||$v["estado"]!="APR"){
    $_SESSION["msg"]="Viaje no aprobado";
    $_SESSION["retorno"]='mv_vdispo_ver';
    Redirect("aviso");
}

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



?>
</div>
<br>
<div class="container">
    
    <form class="form col-md-6" method="get" action="mv_viaje_certificar_do" onsubmit="valida_formulario()">
        <input hidden name="id" value="<?php echo $id?>">
        
        <div class="form-group has-warning">
            <label class="label-form">Fecha y hora partida</label>
            <input class="form-control" value="<?php echo ffec($v['fecha']).' '.substr($v['hora'],0,5)?>" disabled>
        </div>    
        
        
        
        <div class="form-group has-warning">
            <label class="label-form">El viaje se realiz&oacute;?</label>
        <div class="form-check form-check-inline">
            
            
            <input class="form-check-input" type="radio" checked id="si" name="cumplido" value="1">
            <label class="form-check-label" for="si">S&iacute;</label>
        </div>
         <div class="form-check form-check-inline">   
            
            <input class="form-check-input" type="radio" id="no" name="cumplido" value="-1">
            <label class="form-check-label" for="no">No</label>
        </div>
    
    </div>
    <div class="form-group has-warning">
            <label class="label-form">Motivo (si no realizado)</label>
            <input class="form-control" id="motivo" name="motivo">
     </div>       
    <button class="btn-success">Certificar</button>
    </form>
  
</div>
<script>
    function valida_formulario(){
        if(document.getElementById("no").checked && document.getElementById("motivo").value==""){
            status("motivo");return false;
        }
        return true;
    }
</script>



</body>