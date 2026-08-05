<?php
session_start(); 
require("funciones.php"); 
$_SESSION["prestacion"]="Editar hora viaje";
include("encabezado.php");

$id=nget("id");
$bandejas="X".$_SESSION["bandeja"];
$_SESSION["retorno"]='mv_edit_menu?id='.$id;
if($_SESSION["supervisa"]=="B13"){
    $bandejas="X16789";
}

$v=un_registro("select * from movil_viajes where id=".$id);
if($v["dispositivo"]>"0"){$dispositivo=$v["dispositivo"];
  $tipo_dispositivo="Dispositivo";
   
};
if($v["sector"]>"0"){$dispositivo=$v["sector"];
   $tipo_dispositivo="Sector";
   
};

if(strpos($bandejas,$v["bandeja"])==0 && $v["bandeja"]!="80"){
    $_SESSION["msg"]="Viaje de otras bandejas";
    Redirect("aviso");

}

$_SESSION["retorno"]=$_SESSION['menu'];

?>
</div>


    



<div class="container">

    <div class="row">  
    <div class="form-group has-warning col-md-3">
         <label>Solicitante&nbsp;</label>
        <p class="form-control text-primary"><?php 
        if($tipo_dispositivo=="Dispositivo") {
            echo un_campo("select nombre from dispositivos where id=".$dispositivo);}
        else{
            echo un_campo("select denominacion from sectores where id=".$dispositivo);}     
        ?></p>    
    </div>        
    <div class="form-group has-warning col-md-7">
        <label class="label-form">Observaciones del revisor/a</label>&nbsp;
        	<p class="form-control text-danger"><?php echo si($v["observaciones"]=="","Ninguna",$v["observaciones"])?></p>
     </div>
    </div>        
    <br>
    <form class="form-inline" method="get" onsubmit="return valida_formulario()" action="mv_edit_hora_do">
   <input name="id" value="<?php echo $id?>" hidden>
 
  <div class="row">
        <div class="form-group has-warning col-md-4">
        <label class="label-form">Fecha del viaje&nbsp;</label>
        <p class="form-control text-primary">
        <?php echo ffec($v['fecha'])?>
        </p>
    </div>    
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Hora de partida&nbsp;</label>
    
        <input type="time" class="form-control" min="00:00" max="23:59"  id="hora" name="hora" required value="<?php echo $v['hora']?>">
    </div>
    </div>  
      
    <br><br>
      <button class='form-control btn-success'>Guardar</button>
      
    </form></div>    

  

<script>

function valida_formulario(){
 hora=document.getElementById("hora").value;
 cnt=eje("val_hora_leg?id=<?php echo $id?>&hora="+hora);
 if(parseInt(cnt)>0){status("viaje en horario próximo");return false;};
 return true;
} 



</script>

</body>