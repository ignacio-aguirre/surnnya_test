<?php
include("Funciones.php");
session_start();
$id=$_GET["id"];
$familia=un_campo("select familia from fv_participaciones where id=".$id);
$_SESSION["prestacion"]="Editar Intervenci&oacute;n con la Familia ".un_campo("select descripcion from fv_familias where idfv_familias=".$familia);
include("encabezado-test.php");
$r=un_registro("select * from fv_participaciones where id=".$id);
?>
</div>
<div class="container">
<form class="form-inline" method="POST" action="fv_intervencion_editar_do" onsubmit="return valida()">
        <div class="form-group has-warning">
   	  <label class="label-form">Fecha Ingreso</label>
	  <input class="form-control" id="fecha_ingreso" size="10" maxlength="10" name="fecha_ingreso" value="<?php echo ffec($r['fecha_ingreso'])?>" autofocus required onblur="valta(this.id)">
        </div>
        <div class="form-group has-warning">
   	  <label class="label-form">Derivante</label>
          <?php echo select_tabla("derivante","CM",true,false)?>
	  <script>
            seleccionar("derivante","<?php echo $r['derivante']?>");
          </script>
	</div>
        <div class="form-group has-warning">
   	  <label class="label-form">Juzgado Interviniente</label>
	  <input class="form-control" id="juzgado" name="juzgado" size="35" maxlength="50" value="<?php echo $r['juzgado']?>">	
	</div><br><br>
        <div class="form-group has-warning">
   	  <label class="label-form">Expediente</label>
	  <input class="form-control" id="expediente" name="expediente" size="45" maxlength="100" required value="<?php echo $r['expediente']?>">	
	</div>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Cond. p/Asignar</label>
	  <input class="form-control" id="fecha_condiciones" size="10" maxlength="10" name="fecha_condiciones" value="<?php echo ffec($r["fecha_condiciones"])?>" required onblur="valta(this.id)">
        </div>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Asignaci&oacute;n</label>
	  <input class="form-control" id="fecha_asignacion" size="10" maxlength="10" name="fecha_asignacion" value="<?php echo ffec($r['fecha_asignacion'])?>" required onblur="valta(this.id)">
        </div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Informe/CCOO Asignaci&oacute;n</label>
	  <input class="form-control" id="ccoo_asignacion" name="ccoo_asignacion" size="45" maxlength="60" required value="<?php echo $r['ccoo_asignacion']?>">	
        </div>
	<div class="form-group has-warning">
	  <label class="label-form">Centro Zonal Asignado</label>
	  <select id="efector" name="efector" class="form-control">
	 <?php echo efectorespropios()?>
          </select>
          <script>
            seleccionar("efector","<?php echo $r['efector']?>");
          </script>
        </div><br><br>
        <div class="form-group has-warning">
		<label class="label-form">Intervenciones Previas</label>
 		<?php echo select_tabla("intervenciones_previas","SINO",true,true)?>
        <script>
        seleccionar("intervenciones_previas","<?php echo $r['intervenciones_previas']?>");
        </script>
        </div>&nbsp;&nbsp;
        <div class="form-group has-warning">
	   <label class="label-form">Adultos Convivientes</label>
	   <input class="form-control" name="adultos_convivientes" id="adultos_convivientes" size="2" maxlength="2" onblur="valida_entero(this.id)" value="<?php echo $r['adultos_convivientes'] ?>">		
	</div>
        <div class="form-group has-warning">
	   <label class="label-form">Adultos No Convivientes</label>
	   <input class="form-control" name="adultos_noconvivientes" id="adultos_noconvivientes" size="2" maxlength="2" onblur="valida_entero(this.id)" value="<?php echo $r['adultos_noconvivientes']?>">		
	</div><br><br>
	<label class="label-form">Motivos de Intervenci&oacute;n</label><br>
	<div class="form-group has-warning">
	
	  <label class="label-form">1</label>
	  <?php echo select_tabla("m_asig1","FVMA",true,true)?>
	</div>&nbsp;&nbsp;
	<div class="form-group has-warning">
	  <label class="label-form">2</label>
	  <?php echo select_tabla("m_asig2","FVMA",false,true)?>
	</div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">3</label>
	  <?php echo select_tabla("m_asig3","FVMA",false,true)?>
	</div>&nbsp;&nbsp;
        <div class="form-group has-warning">
	  <label class="label-form">4</label>
	  <?php echo select_tabla("m_asig4","FVMA",false,true)?>
	</div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Profesional/Operador Responsable Seguimiento (si hay dos, separar con -)</label>
	  <input class="form-control" name="profesionales" id="profesionales" size="35" maxlength="50" value="<?php echo $r['profesionales']?>" onblur="valida_0(this.id)">	
	</div>
	<hr>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Cese</label>
	  <input class="form-control" id="fecha_baja" size="10" maxlength="10" name="fecha_baja" value="<?php echo ffec($r['fecha_baja'])?>" onblur="vbaja(this.id)">
        </div>&nbsp;&nbsp;
        <div class="form-group has-warning">
	  <label class="label-form">Motivo Cese</label>
	  <select id="motivo_baja" name="motivo_baja" class="form-control">
	  <option value=""></option>
	  <?php echo opc_tabla("FVMB");?>
	  </select>	
	</div>
<input name="id" value="<?php echo $id?>" hidden>
<hr>
<button class="btn-primary" type="submit">Actualizar</button>
</form>
</div>
<script>
function valta(id){
  valida_fecha(id);
  if(document.getElementById(id).value==""){return false;};
  if(fsql(document.getElementById(id).value)>fsql("<?php echo $_SESSION['DiaHoy']?>")){document.getElementById(id).value="";return false;};
  return true;
}
function vbaja(id){
  valida_fecha(id,1);
  if(document.getElementById(id).value==""){return true;};
  if(fsql(document.getElementById(id).value)>fsql("<?php echo $_SESSION['DiaHoy']?>")){document.getElementById(id).value="";return false;};
  return true;
}


function valida(){
 if(!valta("fecha_ingreso")){status("Error:fecha_ingreso"); return false;};
 if(!valta("fecha_condiciones")){status("Error:fecha_p/asignar"); return false;};
 if(!valta("fecha_asignacion")){status("Error:fecha_asignacion"); return false;};
 if(document.getElementById("m_asig1").value==document.getElementById("m_asig2").value && document.getElementById("m_asig1").value!=""){
  status("motivos 1 y 2 duplicados");return false;};
 if(document.getElementById("m_asig1").value==document.getElementById("m_asig3").value && document.getElementById("m_asig1").value!=""){
   status("motivos 1 y 3 duplicados");return false;};
 if(document.getElementById("m_asig1").value==document.getElementById("m_asig4").value && document.getElementById("m_asig1").value!=""){
   status("motivos 1 y 4 duplicados");return false;};
 if(document.getElementById("m_asig2").value==document.getElementById("m_asig3").value && document.getElementById("m_asig2").value!=""){
   status("motivos 2 y 3 duplicados");return false;};
 if(document.getElementById("m_asig2").value==document.getElementById("m_asig4").value && document.getElementById("m_asig2").value!=""){
   status("motivos 2 y 4 duplicados");return false;};
 if(document.getElementById("m_asig3").value==document.getElementById("m_asig4").value && document.getElementById("m_asig3").value!=""){
   status("motivos 3 y 4 duplicados");return false;};
 if(!vbaja("fecha_baja")){status("Error:fecha_cese");return false;};
 if(fsql(document.getElementById("fecha_condiciones").value)<fsql(document.getElementById("fecha_ingreso").value)){
  status("Error:fecha_p/asignar anterior a fecha_ingreso");
  return false;
 }; 
 if(fsql(document.getElementById("fecha_asignacion").value)<fsql(document.getElementById("fecha_condiciones").value)){
  status("Error:fecha_asignacion anterior a fecha_p/asignar");
  return false;
 };
 if(document.getElementById("fecha_baja").value!=""){
   if(fsql(document.getElementById("fecha_baja").value)<fsql(document.getElementById("fecha_asignacion").value)){
     status("Error:fecha_cese anterior a fecha_asignacion");
     return false;
   };
  if(document.getElementById("motivo_baja").value==""){
     status("Error:debes completar el motivo de cese en los ceses");
     return false;
  };
 };

 status("");
 return true;
}
seleccionar("m_asig1","<?php echo $r['m_asig1']?>");
seleccionar("m_asig2","<?php echo $r['m_asig2']?>");
seleccionar("m_asig3","<?php echo $r['m_asig3']?>");
seleccionar("m_asig4","<?php echo $r['m_asig4']?>");
seleccionar("motivo_baja","<?php echo $r['motivo_baja']?>");
</script>
<?php
function efectorespropios(){
  $s="";
  $reg=registros("select id, denominacion from sectores where programa=9 order by denominacion");
  while($r=mysqli_fetch_assoc($reg)){
    $s=$s."<option value=".$r["id"].">".$r["denominacion"]."</option>";
  };
  return $s;
}
?>

</body>
</html>