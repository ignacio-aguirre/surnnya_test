<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Ver datos de viaje";
include("encabezado.php");
$id=nget("id");


$v=un_registro("select * from movil_viajes where id=".$id);
if($v["dispositivo"]>"0"){$dispositivo=$v["dispositivo"];
  $tipo_dispositivo="Dispositivo";
   if($_SESSION["perfil_moviles"]=="1" && $dispositivo!=$v["dispositivo"]){    Redirect("salir");};
};
if($v["sector"]>"0"){$dispositivo=$v["sector"];
   $tipo_dispositivo="Sector";
   if($_SESSION["perfil_moviles"]=="1" && $dispositivo!=$v["sector"]){    Redirect("salir");};
};


?>
</div>
<br>
<div class="container" style="font-size:.9em;">
    
    <div class="row">  
    <div class="form-group has-warning col-md-3">
         <label>Solicitante<br></label>
        <p class="form-control-sm text-info"><?php 

        if($tipo_dispositivo=="Dispositivo") {
            echo un_campo("select nombre from dispositivos where id=".$dispositivo);}
        else{
            echo un_campo("select denominacion from sectores where id=".$dispositivo);}     
        ?></p>    
    </div>        
    <div class="form-group has-warning col-md-2">
        <label class="label-form">Estado</label>
	    <p class="form-control-sm text-info"><?php echo des_obs($v["estado"])?></p>    
    </div>&nbsp;
    <div class="form-group has-warning col-md-2">
        <label class="label-form">Bandeja</label>
        <p class="form-control-sm text-info"><?php echo un_campo("select nombre from movil_bandejas where id=".$v["bandeja"])?></p>
    </div>
    <div class="form-group has-warning col-md-3">
        <label class="label-form">Usuario</label>
        <p class="form-control-sm text-info"><?php echo $v["usuario"]?></p>
    </div>
    
    </div>
    
    <div class="row">  
    
    <div class="form-group has-warning col-md-7">
        <label class="label-form">Observaciones del revisor/a</label>&nbsp;
        	<p class="form-control-sm text-danger">
             <?php echo $v["observaciones"];?>   
            </p>
     </div>
     <div class="form-group has-warning col-md-3">
        <label class="label-form">Marca temporal</label>
        <p class="form-control-sm text-info"><?php echo ffec(substr($v["fechahora"],0,10))." ".substr($v["fechahora"],-8)?></p>
    </div>
    
    
    </div>        
    
  <div class="row">
         <div class="form-group has-warning col-md-2">
        <label class="label-form">Fecha del viaje</label>
        <p class="form-control-sm text-info"><?php echo ffec($v['fecha'])?></p>
        </div>
    <div class="form-group has-warning col-md-2">
        <label class="label-form-sm">Hora de partida</label>
        <p class="form-control-sm text-info"><?php echo $v['hora']?></p>
    </div>

    <div class="form-group has-warning col-md-4">
        <label class="label-form">Tipo de m&oacute;vil</label>
        <select disabled class="form-control-sm text-info" name="tipo_movil" id="tipo">
              
        <?php
                $opc=registros("select id,nombre_info from movil_renglones   order by id");
                    while($o=mysqli_fetch_assoc($opc)){
                echo "<option value='".$o["id"]."'>".$o["nombre_info"]."</option>";}
         ?>
        </select>             
    </div>
    <div class="form-group has-warning col-md-3">
        <label class="label-form">Motivo del recurso</label>
            <select class="form-control-sm text-info" id="motivo_recurso" name="motivo_recurso" disabled>
            <option value="">Completar</option>
        <?php echo opc_tabla("MVMT")?>
        </select>
        <script>
        seleccionar("tipo","<?php echo $v['tipo_movil']?>");
        seleccionar("motivo_recurso","<?php echo $v['motivo_recurso']?>");
        </script>

      </div>

    </div>
    <div class="row" style="font-size:  .9em;">
    
        <div class="form-group col-md-4">
         <label class="label-form">Partida</label>
                <input class="form-control-sm" size="40" maxlength="70" id="partida" name="partida"  value="<?php echo estandariza_dom($v['partida'])?>" disabled>
         </div>
    
    <div class="form-group col-md-4">
        <label class="label-form">Destino 1</label>
        <input class="form-control-sm dir" id="destino_1"  name="destino_1" size="40" maxlength= "70" value="<?php echo estandariza_dom($v['destino_1'])?>" disabled>
        
    </div>
    
    <div class="form-group col-md-4">
        <label class="label-form">Destino 2</label>
        <input class="form-control-sm dir" id="destino_2"  name="destino_2" size="40" maxlength= "70"  value="<?php echo estandariza_dom($v['destino_2'])?>" disabled>
    
    </div>

    </div>
    
    
    <div class="row" style="font-size:  .9em;">
    <div class="form-group col-md-6">
        <label class="label-form">Destino 3</label>
        <input class="form-control-sm" id="destino_3"  name="destino_3" size="40" maxlength= "70"  value="<?php echo estandariza_dom($v['destino_3'])?>" disabled>
        
        
    </div>
    
     <div class="form-group col-md-6">
        <label class="label-form">Destino 4</label>
        <input class="form-control-sm" id="destino_4"  name="destino_4" size="40" maxlength= "70"  value="<?php echo estandariza_dom($v['destino_4'])?>" disabled>
        
     </div>
     <br><br>
    </div>
    <div class="row" style="font-size:  .9em;">
        <div class="form-group col-md-2">
      <label class="label-form">Km</label>
      <input class="form-control-sm" size="3" disabled  value="<?php echo $v['distancia_calculada']?>" id="dis_total">

        </div> 
        <div class="form-group col-md-2">
          <label class="label-form">Hora espera adicional</label>
          <input class="form-control-sm" type="checkbox" readonly id="hora_adicional" <?php echo si($v["hora_adicional"]=="1"," checked","")?> disabled>

      </div>
      <div class="form-group col-md-2">
        <label class="label-form">Min espera adic.</label>
          <select class="form-control-sm" id="minutos_adicionales" disabled>
            <option value=0>No</option>
            <option value=1>10</option>
            <option value=2>20</option>
            <option value=3>30</option>
            <option value=4>40</option>
            <option value=5>50</option>
          </select>  
      </div>  
      <script>
        minu="<?php 
        echo $v['minutos_adicionales']?>";
        seleccionar("minutos_adicionales",minu)</script>
      <div class="form-group col-md-6">
        <label class="label-form">Empresa</label>
        <input class="form-control-sm"  disabled value="<?php echo un_campo("select deno from tablas where tipo='ETRA' and valo=".$v['empresa'])?>"> 
      </div>
    </div>
    <div class="row">
    <div class="table-responsive  col-md-6">
    <table class="table">
    <thead>
     <tr class="bg-dark text-white" style="font-size:.9em"><th>Pas.NNYA</th><th>Legajo</th></tr>
        </thead>
        <tbody id="alojados">
	<?php 
	  $paxal=registros("select movil_pasajeros.*, concat(sujetos.apellidos,', ',sujetos.nombres) as apynombre 
           from movil_pasajeros left join sujetos on movil_pasajeros.legajo=sujetos.legajo where viaje=".$id." and tipo_pasajero=1");
         $i=0;
          while($p=mysqli_fetch_assoc($paxal)){
	    $i++;	
            echo "<tr><td><input class='form-control-sm' size='35' disabled value='".$p["apynombre"]."'></td><td>
		<input disabled class='form-control-sm' size='6' value='".$p["legajo"]."'></td></tr>";
          };
          
        ?>
        </tbody>
        </table>
        </div>
    <div class="table-responsive  col-md-6">
    <table class="table">
    <thead>
     <tr class="bg-dark text-white" style="font-size:.9em"><th>Pas.Adultos</th><th>Celular</th></tr>
        </thead>
        <tbody id="otros">
    	        <?php 
      $paxac=registros("select * from movil_pasajeros where viaje=".$id." and tipo_pasajero=2");
         $k=0;
          while($p=mysqli_fetch_assoc($paxac)){
        $k++;   
            echo "<tr><td><input class='form-control-sm' size='35' value='".$p["pas_nombre"]."' disabled ></td><td><input disabled class='form-control-sm' size='8' value='".$p["celular"]."'></td></tr>";

          };
          
          
    
        ?>

    


        </tbody>
        </table>
        </div>
    </div>

      <div class="row">
      <div class="form-group has-warning col-md-2">
    <label class="label-form">NNYA</label>
    <input class="form-control-sm" disabled size="3" value="<?php echo $v['pasajeros_alojados']?>">
    </div>
      
      <div class="form-group has-warning col-md-2">
    <label class="label-form">Adultos</label>
    <input class="form-control-sm" disabled size="3"  value="<?php echo $v['pasajeros_acompaniantes']?>">

      </div>
      <div class="form-group has-warning col-md-8">
        <label class="label-form">Comentarios</label>
        <textarea disabled class="form-control" cols="80" rows="4" id="comentarios" name="comentarios"><?php echo $v['comentarios']?></textarea>
      </div>
    </div>
    
</div>

</body>