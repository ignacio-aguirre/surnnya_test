<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Establecer viaje regular";
include("encabezado.php");
$oper=un_registro("select * from movil_procesos where id=".$_SESSION['idproceso']);  
  $bl="b1_6";
  $fini=$oper["desde_ab"];
  if($oper[$bl]>"0" && $_SESSION["perfil_moviles"]=="1") {$fini=$oper["desde_db"];}

$fini=$_SESSION['hoy_c'];
$ffin=$_SESSION['hoy_c'];

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

$fecha=ffec($v['fecha']);
?>
</div>
<br><br>
<div class="container">

  <form class="form-inline" method="get" onsubmit="return valida_formulario()" action="mv_viaje_regular_do">
   <input name="id" value="<?php echo $id?>" hidden>

 <div class="row">  
    <div class="form-group has-warning col-md-3">
         <label>Solicitante<br></label>
        <p class="form-control text-primary"><?php 
        if($tipo_dispositivo=="Dispositivo") {
            echo un_campo("select nombre from dispositivos where id=".$dispositivo);}
        else{
            echo un_campo("select denominacion from sectores where id=".$dispositivo);}     
        ?></p>    
    </div>        
    <div class="form-group has-warning col-md-3">
        <label class="label-form">Estado</label>
	    <p class="form-control text-primary"><?php echo des_obs($v["estado"])?></p>    
    </div>&nbsp;&nbsp;
    
    <div class="form-group has-warning col-md-9">
        <label class="label-form">Observaciones del revisor/a</label>&nbsp;
        	<p class="form-control text-danger">
             <?php echo $v["observaciones"];?>   
            </p>
     </div>
    
    </div>        
    <br>
  <div class="row">
         <div class="form-group has-warning col-md-2">
        <label class="label-form">Fecha del viaje</label>
        <p class="form-control text-primary"><?php echo ffec($v['fecha'])?></p>
        </div>
    <div class="form-group has-warning col-md-2">
        <label class="label-form">Hora de partida</label>
        <p class="form-control text-primary"><?php echo $v['hora']?></p>
    </div>

    <div class="form-group has-warning col-md-4">
        <label class="label-form">Tipo de m&oacute;vil</label>
        <select disabled class="form-control" id="tipo">
              
        <?php
                $opc=registros("select id,nombre_info from movil_renglones  order by id");
                    while($o=mysqli_fetch_assoc($opc)){
                echo "<option value='".$o["id"]."'>".$o["nombre_info"]."</option>";}
         ?>
        </select>             
    </div>
    <div class="form-group has-warning col-md-3">
        <label class="label-form">Motivo del recurso</label>
            <select class="form-control" id="motivo_recurso" name="motivo_recurso" disabled>
            <option value="">Completar</option>
        <?php echo opc_tabla("MVMT")?>
        </select>
        <script>
        seleccionar("tipo","<?php echo $v['tipo_movil']?>");
        seleccionar("motivo_recurso","<?php echo $v['motivo_recurso']?>");
        </script>

      </div>

    </div>
    <div class="row">
    
        <div class="form-group has-warning col-md-4">
         <label class="label-form">Partida</label>
                <input class="form-control dir" size="40" maxlength="70" id="partida" name="partida"  value="<?php echo estandariza_dom($v['partida'])?>" readonly>
         </div>
    
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Destino 1</label>
        <input class="form-control dir" id="destino_1"  name="destino_1" size="40" maxlength= "70" value="<?php echo estandariza_dom($v['destino_1'])?>" readonly>
        
    </div>
    
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Destino 2</label>
        <input class="form-control dir" id="destino_2"  name="destino_2" size="40" maxlength= "70"  value="<?php echo estandariza_dom($v['destino_2'])?>" readonly>
    
    </div>

    </div>
    
    
    <div class="row">
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Destino 3</label>
        <input class="form-control" id="destino_3"  name="destino_3" size="40" maxlength= "70"  value="<?php echo estandariza_dom($v['destino_3'])?>" readonly>
        
        
    </div>
    
     <div class="form-group has-warning col-md-6">
        <label class="label-form">Destino 4</label>
        <input class="form-control" id="destino_4"  name="destino_4" size="40" maxlength= "70"  value="<?php echo estandariza_dom($v['destino_4'])?>" readonly>
        
     </div>
     <br><br>
    </div>
    <div class="row">
    <div class="col-md-12">
    	<div class="table-responsive">
    <table class="table">
    <thead>
     <tr class="bg-success" style="font-size:.9em"><th>Pas.Alojados</th><th>Legajo</th></tr>
        </thead>
        <tbody id="alojados">
	<?php 
	  $paxal=registros("select movil_pasajeros.*, concat(sujetos.apellidos,', ',sujetos.nombres) as apynombre 
           from movil_pasajeros left join sujetos on movil_pasajeros.legajo=sujetos.legajo where viaje=".$id." and tipo_pasajero=1");
         $i=0;
          while($p=mysqli_fetch_assoc($paxal)){
	    $i++;	
            echo "<tr><td><input class='form-control' size='35' disabled value='".$p["apynombre"]."'></td><td>
		<input disabled class='form-control' size='6' value='".$p["legajo"]."'></td></tr>";
          };
          
        ?>
        </tbody>
        </table>
        </div>
     </div>
</div>

      <div class="row">
      <div class="form-group has-warning col-md-2">
    <label class="label-form">NNYA</label>
    <input class="form-control" disabled size="3" value="<?php echo $v['pasajeros_alojados']?>">
    </div>
      
      <div class="form-group has-warning col-md-2">
    <label class="label-form">Adultos</label>
    <input class="form-control" disabled size="3"  value="<?php echo $v['pasajeros_acompaniantes']?>">

      </div>
      <div class="form-group has-warning col-md-8">
        <label class="label-form">Comentarios</label>
        <textarea disabled class="form-control" cols="80" rows="4" id="comentarios" name="comentarios"><?php echo $v['comentarios']?></textarea>
      </div>
    </div>
    
      <hr>
      <h4>Programaci&oacute;n</h4>			
      </div>
      <div class="container">
      	<div class="row">
      	<div class="form-group has-warning col-md-3">
		<label class="label-form">D&iacute;s de la semana</label>
	        <input class="form-control" id="ds" name="ds" required value="LMXJVSD">
      </div>
          
      
      <div class="form-group has-warning col-md-3">
	<label class="label-form">En d&iacute;as</label>
                <select class="form-control" id="dias" name="dias" required>
	        <option value="">Completar</option>
	        <option value="1">Laborables</option>
	        <option value="2">No laborables</option>
	        <option value="3">Ambos</option>
		</select>
      </div>
      
      <div class="form-group has-warning col-md-3">
		<label class="label-form">Desde el</label>
		<input id="fecha_inicio" name="fecha_inicio" class="form-control" type="date" value="<?php echo $fini?>" required>
      </div>
      <div class="form-group has-warning col-md-3">
		<label class="label-form">Hasta el</label>
		<input id="fecha_fin" name="fecha_fin" class="form-control" type="date"  value="<?php echo $ffin?>" required>
      </div>
		</div>		
      <br><br>
      <button class="form-control btn-success">Programar</button>	 				
  </form>	
</div>

<script>
function valida_formulario(){
 fini=document.getElementById("fecha_inicio").value;
 ffin=document.getElementById("fecha_fin").value;
 if(fini=="" || ffin==""){status("fechas desde y hasta son obligatorias");return false;}
 if(fini>=ffin){status("fecha hasta debe ser mayor a fecha desde");return false;};
 fech="<?php echo $fecha?>";
 finc=fini.replaceAll("-","");
  if(finc<=fsql(fech)){status("fecha inicio debe ser mayor a la del viaje");return false;};
 status("");
 return true;
} 
</script>

</body>