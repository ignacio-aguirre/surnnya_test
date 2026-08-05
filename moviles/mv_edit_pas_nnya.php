<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Editar pasajeros alojados";
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
 
 v_tipo="<?php echo $v['tipo_movil']?>";
 rng=JSON.parse(eje("val_renglon?renglon="+v_tipo));
 minpasajeros=rng.capacidad_min;
 maxpasajeros=rng.capacidad_max;
  recuentoalo();
 
  // debe haber por lo menos un alojado como pasajero
  td="d";
  if("<?php echo $dispositivo?>"=="<?php echo $_SESSION['sector']?>"){td="s";}
  
  palo=parseInt(document.getElementById("pasajeros_alojados").value);

  if( palo==0 && td=="d"){ status("sin alojados");    return false;};
  paco=parseInt("<?php echo $v['pasajeros_acompaniantes']?>");
  pax=palo+paco;
  
  
  if(pax>maxpasajeros && rng.tipo==1){status("# pasajeros "+pax+" excede capacidad "+maxpasajeros); return false;};
  if(pax<minpasajeros && rng.tipo==1){status("# pasajeros "+pax+" menor a capacidad "+minpasajeros); return false;};
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
  <div class="form-group has-warning col-md-3">
        <label class="label-form">Motivo recurso&nbsp;</label>
        <p class="form-control text-primary">
        <?php echo un_campo("select deno from tablas where tipo='MVMT' and valo=".$v['motivo_recurso'])?>
        </p>
    </div>
  
     <form class="form-inline" method="get" onsubmit="return valida_formulario()" action="mv_edit_pas_nnya_do">
      <input hidden id="id" name="id" value="<?php echo $id?>">
  
</div>
<div class="container">
  <div class="row">
     <h4 class="col-md-6">Pasajeros</h4>
</div>
  
<div class="row">
        <div class="col-md-6">
            <label class="label-form">Alojados dispositivo</label>
            <select class="form-control" id="lista_alojados">
                <?php 
                 $cond="true";
                 if($v['dispositivo']>"0"){$cond="admi_hogar=".$v['dispositivo'];};
                 $add=registros("select legajo, apellidos, nombres from hogares_admision left join sujetos on admi_legajo=sujetos.legajo where ".$cond." and admi_alta is not null and admi_baja is null order by nombres,apellidos");
                  while($e=mysqli_fetch_assoc($add)){
                    echo "<option value='".$e["legajo"]."'>".$e["nombres"]." ".$e["apellidos"]."</option>";
                  }
                ?>
        </select>
        <a class="btn-sm btn-primary" href="javascript:seleccional()">Seleccionar</a>
          
        </div>
        
        
    
	<div class="table-responsive col-md-6 pre-scrollable">
	<table class="table">
	<thead>
	 <tr class="bg-success" style="font-size:.9em"><th>Alojados</th><th>Legajo</th></tr>
        </thead>
        <tbody id="alojados">
          <?php 
    $paxal=registros("select movil_pasajeros.*, concat(sujetos.apellidos,', ',sujetos.nombres) as apynombre 
           from movil_pasajeros left join sujetos on movil_pasajeros.legajo=sujetos.legajo where viaje=".$id." and tipo_pasajero=1");
         $i=0;
          while($p=mysqli_fetch_assoc($paxal)){
      $i++; 
            echo "<tr><td><input class='form-control alo' size='35' name='p".$i."' id='p".$i."' value='".$p["apynombre"]."' onblur='salealo(".$i.")' autocomplete='off'></td><td>
    <input readonly class='form-control leg' size='6' name='lega".$i."' id='lega".$i."' value='".$p["legajo"]."'></td></tr>";
          };
    
    
          $j=$i;
          while($j<30){
     $j++;  
            echo "<tr><td><input class='form-control alo' size='35' name='p".$j."' id='p".$j."'  autocomplete='off' onblur='salealo(".$j.")' ></td><td>
    <input readonly class='form-control' size='6' name='lega".$j."' id='lega".$j."'></td></tr>";
        
          }
  
        ?>
        </tbody>
        </table>
        </div>
    
  </div>        
	
      <div class="row">
      <div class="form-group has-warning col-md-6">
	<label class="label-form">Cantidad pasajeros alojados</label>
	<input class="form-control" readonly id="pasajeros_alojados" name="pasajeros_alojados" onfocus="recuentoalo()" value="<?php echo $v['pasajeros_alojados']?>">
      </div>
  <div class="form-group has-warning col-md-6">
    <label class="label-form">Cantidad pasajeros acompa&ntilde;antes</label>
    <input class="form-control" readonly id="pasajeros_acompaniantes" name="pasajeros_acompaniantes" size="3"  value="<?php echo $v['pasajeros_acompaniantes']?>">

      </div>
      
    </div>
    <br><br>    
    
    
      <button class="form-control btn-success">Guardar</button>					
  


  </form>	
  
</div>

</body>