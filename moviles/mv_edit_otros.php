<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Editar Otros";
include("encabezado.php");
$id=nget("id");
$bandejas="X".$_SESSION["bandeja"];
$_SESSION["retorno"]='mv_edit_menu?id='.$id;
if($_SESSION["supervisa"]=="B24"){
    $bandejas="X245";
   
}
if($_SESSION["supervisa"]=="B13"){
    $bandejas="X136789";
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
<script>
var ventana;
var minpasajeros=0; 
var maxpasajeros=0;

function valida_formulario(){
 status("");
  return true;
} 



</script>
</div>
<br><br>
<div class="container">
<div class="row">  
    <div class="form-group has-warning col-md-4">
         <label class="label-form">Solicitante&nbsp;</label>
        <p class="form-control text-primary"><?php 
        if($tipo_dispositivo=="Dispositivo") {
            echo un_campo("select nombre from dispositivos where id=".$dispositivo);}
        else{
            echo un_campo("select denominacion from sectores where id=".$dispositivo);}     
        ?></p>    
    </div>        
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Observaciones del revisor/a</label>&nbsp;
          <p class="form-control text-danger"><?php echo si($v["observaciones"]=="","Ninguna",$v["observaciones"])?></p>
     </div>
    </div>        
    <div class="row">
        <div class="form-group has-warning col-md-3">
        <label class="label-form">Fecha del viaje&nbsp;</label>
        <p class="form-control text-primary">
        <?php echo ffec($v['fecha'])?>
        </p>
    </div>    
    <div class="form-group has-warning col-md-3">
        <label class="label-form">Hora de partida&nbsp;</label>
        <p class="form-control text-primary">
        <?php echo $v['hora']?>
        </p>
    </div>
    <form class="form-inline" method="get" onsubmit="return valida_formulario()" action="mv_edit_otros_do">
      <input hidden id="id" name="id" value="<?php echo $id?>">
  
  <div class="form-group has-warning col-md-5">
          <label for="motivo_recurso" class="label-form">Motivo del recurso</label>
          <select class="form-control" id="motivo_recurso" name="motivo_recurso" required>
          <option value="">Completar</option>
          <?php echo opc_tabla("MVMT")?>
          </select>
    </div>
    <script>seleccionar("motivo_recurso","<?php echo $v['motivo_recurso']?>")</script> 
</div>
<div class="container">
  <div class="row">
  <div class="form-group has-warning col-md-6">
    <label class="label-form">Comentarios/Observaciones</label>
    <textarea class="form-control" cols="80" rows="4" id="comentarios" name="comentarios" ><?php echo $v['comentarios']?></textarea>
      </div>    
  </div>
    <br><br>    
    
    
      <button class="form-control btn-success">Guardar</button>					
    </form>	
  
</div>

</body>