<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Registrar Acci&oacute;n Equipo de Salud";
include("encabezado-test.php");
$solicitud=nget("solicitud");
$r=un_registro("select * from es_participaciones where id=".$solicitud);
$ult_dispositivo=un_campo("select dispositivo from es_acciones where solicitud=".$solicitud." order by fecha desc, id desc limit 1");
$ult_tipo=un_campo("select tipo from es_acciones where alcance=1 and solicitud=".$solicitud." order by fecha desc, id desc limit 1");
if($ult_dispositivo==""){$ult_dispositivo=$r["solicitante"];};
?>
</div>
<div class="container">
 <div class="row">
   <div class="col-md-4">
	Fecha Solicitud <strong> <?php echo ffec($r["fecha_ingreso"])?></strong>
   </div>
   <div class="col-md-4">
	Tipo de Acci&oacute;n Solicitada <strong> <?php echo si($r["alcance"]=="1","Intervenci&oacute;n","Institucional")?></strong>
   </div>
   <div class="col-md-4">
	Dispositivo Solicitante <strong> <?php echo si($r["solicitante"]=="-1",$r["solicitante_especificar"],un_campo("select nombre from dispositivos where dispositivos.id=".$r["solicitante"]))?></strong>
   </div>

 </div>
 <div class="row">
   <div class="col-md-4">
	Profesi&oacute;n <strong> <?php echo un_campo("select deno from tablas where tipo='ESESP' and valo=".$r["especialidad"]);?></strong>
   </div>
   <div class="col-md-8"><strong>
     <?php
      if($r["legajo"]>0){
        echo "NNYA ".un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$r["legajo"]);
      }else{
      echo "No asociada a un NNYA";};
      ?></strong>
   </div>

 </div>
 <h4>Registro de la Acci&oacute;n</h4>
 <form class="form-inline" method="get" action="es_accion_nueva_do" onsubmit="return valida()">
  <div class="form-group has-warning">
	<label class="label-form">Fecha</label>
        <input class="form-control" name="fecha" id="fecha" size="10" maxlength="10" onblur="v_fecha()" autofocus required>
  </div>
  <div class="form-group has-warning">
	  <label class="label-form">Alcance de la Acci&oacute;n Solicitada</label>
	  <select id="alcance" name="alcance" class="form-control" required >
          <option value=""></option>
	  <option value="1">Intervenci&oacute;n con NNYA</option>
	  <option value="2">Acciones Institucionales</option>
          </select>
	  <script>seleccionar("alcance","<?php echo $r['alcance']?>")</script>
 </div><br><br>
 <div class="form-group has-warning">
	  <label class="label-form">Dispositivo</label>
	  <select id="dispositivo" name="dispositivo" class="form-control" required>
          <option value=""></option>
		<?php echo $_SESSION['Opc_Hoga']?>
          <option value="-1">--Otros</option>
          </select>
	  <script>seleccionar("dispositivo","<?php echo $ult_dispositivo?>")</script>
 </div>&nbsp;&nbsp;
  <div class="form-group has-warning">
   	  <label class="label-form">Especificar</label>
	  <input class="form-control" id="dispositivo_especificar" name="dispositivo_especificar" size="50" maxlength="60" value="<?php echo $r['solicitante_especificar']?>" placeholder="En caso de haber seleccionado Otros"> 	
	</div><br><br>

 
 <div class="form-group has-warning">
    <label class="label-form">Profesi&oacute;n</label>
	  <select id="especialidad" name="especialidad" class="form-control" required>
          <option value=""></option>
          <?php echo opc_tabla("ESESP");?>
          <option value="99">Equipo Presidencia</option>
          </select>
          <script>
	  seleccionar("especialidad","<?php echo $r['especialidad']?>");
          </script>

 </div>
<div class="form-group has-warning">
    <label class="label-form">Modalidad</label>
    <select id="modalidad" name="modalidad" class="form-control" required>
    <option value=""></option>
    <option value="P">Presencial</option>
    <option value="V">Virtual</option>
    </select>	
</div><br><br>
  <div class="form-group has-warning">
	<label class="label-form">Observaciones</label>
        <input class='form-control' name='observaciones' id='observaciones' maxlength="100" size="80" ></div>
        <input hidden name='solicitud' value="<?php echo $solicitud?>">
        <input hidden name='legajo' value="<?php echo $r['legajo']?>"><br><br>

 <h4>Para intervenciones exclusivamente</h4>

  <div class="form-group has-warning">
    <label class="label-form">Tipo de Intervenci&oacute;n Realizada</label>
	  <select id="tipo" name="tipo" class="form-control">
          <option value=""></option>
          <?php echo opc_tabla("ESTIA");?>
          </select>
          <script>
	  seleccionar("tipo","<?php echo $ult_tipo?>");
          </script>
 </div>
<br><br>
<h4>Para acciones institucionales exclusivamente</h4>
 <div class="form-group has-warning">
    <label class="label-form">Especificar el tipo de acci&oacute;n realizada</label>
	  <input id="accion_especificar" name="accion_especificar" class="form-control">
 </div><br><br>


  <button class='btn-primary'>Registrar</button>
  </form>
</div>
<script>
function v_fecha(){
  valida_fecha("fecha");
  fecha=document.getElementById("fecha").value;
  if(fecha==""){status("fecha es obligatoria"); return false;};
  if(fsql(fecha)<fsql("<?php echo ffec($r['fecha_ingreso'])?>")) {
   status("fecha accion no puede ser anterior a la de la solicitud"); 
   document.getElementById("fecha").value="";	
   return false;
  };	
  status("");
  return true;	
}
function valida(){
 seguir=v_fecha();
 if(seguir==true){ 
 if(document.getElementById("fecha").value==""){status("fecha es obligatoria"); return false;};
 if(document.getElementById("tipo").value=="" && document.getElementById("alcance").value=="1"){status("Tipo de Intervenci&oacute;n es Obligatorio");return false;};
 if(document.getElementById("tipo").value=="5" && document.getElementById("alcance").value=="1"){status("Tipo de Acci&oacute;n Institucional no corresponde a Intervenci&oacute;nes");return false;};
 if(document.getElementById("alcance").value=="2") {seleccionar("tipo","5");}; 
 if(document.getElementById("accion_especificar").value==""&& document.getElementById("alcance").value=="2"){status("Especificar Acci&oacute;n");return false;};
 return true;}
 else{return false;};

}
</script>

</body>
</html>
