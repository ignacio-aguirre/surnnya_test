<?php
session_start(); 
require("funciones.php"); 
$_SESSION["prestacion"]="Editar km y espera";
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


$pba="NO";
$pos_partida=strpos($v["partida"],"CABA");
$pos_d1=strpos($v["destino_1"],"CABA");
$pos_d2=strpos($v["destino_2"],"CABA");
$pos_d3=strpos($v["destino_3"],"CABA");
$pos_d4=strpos($v["destino_4"],"CABA");
if($pos_partida==false){$pba="SI";};
if($pos_d1==false){$pba="SI";};
if($pos_d2==false && $v["destino_2"]!=""){$pba="SI";};
if($pos_d3==false && $v["destino_3"]!=""){$pba="SI";};
if($pos_d4==false && $v["destino_4"]!=""){$pba="SI";};
if($pba=="SI" && $v["tipo_tipo"]=="1"){
    $opc_renglones="<option value=7>Remise PBA</option>";
};
if($v["tipo_tipo"]=="2"){
    $opc_renglones="<option value=1>MB/Combi J Simple</option>
    <option value=2>MB/Combi J Completa</option>";
};
if($v["tipo_tipo"]=="1" && $pba=="NO"){
    $opc_renglones="<option value=3>Remise CABA h/6 km Ida</option>
    <option value=4>Remise CABA h/6 km I/V</option>
    <option value=5>Remise CABA +6 km Ida</option>
    <option value=6>Remise CABA +6 km I/V</option>";
};
$empresa=$v["empresa"];
?>


</div>
<br>
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
    
    <script>

    
</script>

</div>

<div class="container">
     <form class="form-inline" method="get" onsubmit="return valida_formulario()" action="mv_edit_distancia_do">
   <input name="id" value="<?php echo $id?>" hidden>
   <input hidden id="renglon">
  <div class="row">
        <div class="form-group has-warning col-md-3">
        <label class="label-form">Fecha del viaje&nbsp;</label>
        <p class="form-control text-primary">
        <?php echo ffec($v['fecha'])?>
        </p>
    </div>    
    <div class="form-group has-warning col-md-2">
        <label class="label-form">Hora de partida&nbsp;</label>
        <p class="form-control text-primary">
        <?php echo $v['hora']?>
        </p>
    </div>
    <div class="form-group has-warning col-md-3">
        <label class="label-form">Tipo Veh&iacute;culo&nbsp;</label>
        <p class="form-control text-primary">
        <?php echo si($v['tipo_tipo']=="1","Remise","Minibus/Combi")?>
        </p>
    </div>
   <div class="form-group has-warning col-md-2">
      <label class="label-form">PBA&nbsp;</label>
      <input class="form-control" name="pba" id="pba" size="2" disabled value="<?php echo $pba?>">
   </div>  
</div>
                
    <div class="row">    
   <div class="form-group has-warning col-md-2">
      <label class="label-form">Distancia km&nbsp;</label>
      <input class="form-control" size="3" value="<?php echo $v['distancia_calculada']?>" name="dis_total" id="dis_total" onblur="bl_distotal()" autofocus>
   </div> 
   <div class="form-group has-warning col-md-4">
      <label class="label-form" for="tipo">Rengl&oacute;n</label>
      <select class="form-control" id="tipo"  name="tipo_movil" onblur="bl_renglon()" required>
               <option value="">Completar</option>
        <?php
          echo $opc_renglones;
          
         ?>
      </select>
    </div>
  <script>seleccionar("tipo","<?php echo $v['tipo_movil']?>")</script>
   
   <div class="form-group has-warning col-md-2">
          <label class="label-form">Hora espera adicional</label>
          <input class="form-control" type="checkbox" id="hora_adicional" name="hora_adicional" onblur="sale_hora()">
      </div>
      <script>if("<?php echo $v['hora_adicional']?>">0){
      document.getElementById("hora_adicional").checked=true;}</script>
      <div class="form-group has-warning col-md-3">
          <label class="label-form">Minutos adicionales de espera</label>
          <select class="form-control" id="minutos_adicionales" name="minutos_adicionales" disabled>
            <option value=0>No</option>
            <option value=1>10</option>
            <option value=2>20</option>
            <option value=3>30</option>
            <option value=4>40</option>
            <option value=5>50</option>
            <option value=6>60</option>
            <option value=7>70</option>
            <option value=8>80</option>
            <option value=9>90</option>
            
          </select>  
      </div>  
      <script>seleccionar("minutos_adicionales","<?php echo $v['minutos_adicionales']?>")</script>
    </div>
    <div class="row">
    <div class="form-group has-warning col-md-4">
      <label class="label-form">Empresa</label>
      <select class="form-control" id="empresa" name="empresa" disabled>
        <?php
        $opc=registros("select valo,deno from tablas where tipo='ETRA' order by valo");
          while($o=mysqli_fetch_assoc($opc)){
          echo "<option value='".$o["valo"]."'>".$o["deno"]."</option>";}
         ?>
      </select>  
      <script>seleccionar("empresa","<?php echo $empresa?>")</script>
    </div>  
    <div class="form-group has-warning col-md-3">
          <label class="label-form">R7 bloques 10 km</label>
          <input class="form-control" id="b10_km" name="b10_km" value="<?php echo $v['b10_km']?>" readonly onfocus="valida_formulario">
      </div>
    </div>
</div>
  
    

    
    
    <br><br>
      <button id="btnguardar" class='form-control btn-success'>Guardar</button>
      
    </form></div>    

  

<script>

function valida_formulario(){
 if(!bl_renglon()) {return false;}
 dista=document.getElementById("dis_total").value;
 if(dista==""){
  status("distancia km");return false;
 }
 dista=parseInt(dista);

 v_tipo=document.getElementById("tipo").value;
 rng=JSON.parse(eje("val_renglon?renglon="+v_tipo));
 minpasajeros=rng.capacidad_min;
 maxpasajeros=rng.capacidad_max;
 
 if(rng.distancia_maxima<dista && rng.distancia_max>0){
    status("distancia mayor a "+rng.distancia_max);
    return false;
 }
 if(rng.distancia_minima>=dista && rng.distancia_min>0){
    status("distancia menor a "+rng.distancia_min);
    return false;
 }
 
 document.getElementById("renglon").value=rng.id;

  

 status("");
 
 document.getElementById("empresa").disabled=false; 
 document.getElementById("b10_km").readonly=false; 
 document.getElementById("hora_adicional").disabled=false; 
 document.getElementById("minutos_adicionales").disabled=false; 

 return true;
} 


function bl_renglon(){
  v_tipo=document.getElementById("tipo").value;
  document.getElementById("renglon").value=v_tipo;
  if(v_tipo>0){
  document.getElementById("empresa").disabled=false;
  seleccionar("empresa","<?php echo $empresa?>");
  empre=document.getElementById("empresa").value;
  document.getElementById("empresa").disabled=true;
  rng=JSON.parse(eje("val_renglon?renglon="+v_tipo));
  
  if((empre==1 && rng.valor1==0)||(empre==2 && rng.valor2==0)){
    if(empre==1 && rng.id<3){
    document.getElementById("empresa").disabled=false;
    seleccionar("empresa","2");
    document.getElementById("empresa").disabled=true;
  } else{
    status("tipo móvil y empresa");
    seleccionar("tipo","");
    return false;
    }
  }
  if(document.getElementById("pba").value=="SI" && rng.es_pba==0){
    status("PBA - renglon");
    seleccionar("tipo","");
    return false;
  }
  if(document.getElementById("pba").value=="NO" && rng.es_pba==1){
    status("PBA - renglon");
    seleccionar("tipo","");
    return false;
  }
  if(rng.es_pba==1){
    
    document.getElementById("b10_km").value=enterakm(document.getElementById("dis_total").value);
  
    
  }
  else{
    document.getElementById("b10_km").value="0";
  }
  if(rng.es_iv==0){
    document.getElementById("hora_adicional").checked=false;
    document.getElementById("hora_adicional").disabled=true;
    seleccionar("minutos_adicionales","0");
    document.getElementById("minutos_adicionales").disabled=true;
  }
  else{
    document.getElementById("hora_adicional").disabled=false;
    //document.getElementById("minutos_adicionales").disabled=false;
  }};
  status("")
  return true;
  

 } 
 function enterakm(n){
    m=n;
    if(n<10){m=10;};
    r=m % 10;
    s=0;
    if(r>=5){s++;};
    ek=s+parseInt(m/10);
    return ek;
 }
 function bl_distotal(){
  dt=document.getElementById("dis_total").value;
  destino_2="<?php echo $v['destino_2']?>";
  d2=0;
  if(destino_2!=""){d2=1;};
  if(dt==""){
    status("distancia es obligatoria");
    document.getElementById("dis_total").focus();
    return false;
  };
  dtn=parseInt(dt);
  if(dtn!=NaN){
    document.getElementById("dis_total").value=dtn;
    tipo_tipo="<?php echo $v['tipo_tipo']?>";
    document.getElementById("tipo").innerHTML=eje("val_tpdi?tp="+tipo_tipo+"&di="+dtn+"&d2="+d2+"&pba="+document.getElementById("pba").value);
  };
  
  
    return true;
 }
 function sale_hora(){
 if(document.getElementById("hora_adicional").checked==true){
    document.getElementById("minutos_adicionales").disabled=false;
    document.getElementById("minutos_adicionales").focus();
  }
  else{
    seleccionar("minutos_adicionales","0");
    document.getElementById("minutos_adicionales").disabled=true;

  }
}
</script>

</body>