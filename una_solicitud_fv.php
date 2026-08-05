<?php
include("Funciones.php");
session_start();
$id=$_GET["id"];
$r=un_registro("select * from fv_participaciones where id=".$id);
$_SESSION["prestacion"]="Solicitud Intervenci&oacute;n con la Familia ".un_campo("select descripcion from fv_familias where idfv_familias=".$r["familia"]);
include("encabezado.php");
?>
</div>
<div class="container">
<p class="text-danger">Se recomienda, una vez llegado a esta p&aacute;gina, salir Guardando Cambios, aunque no se haya completado ning&uacute;n dato</p>
<form class="form-inline" method="POST" action="fv_solicitud_do" onsubmit="return valida()">
        <div class="form-group has-warning">
   	  <label class="label-form">Derivante / Solicitante</label>
	  <select id="derivante" name="derivante" class="form-control" autofocus required>
          <option value=""></option>
	  <option value="-1">Otros Solicitantes a Especificar</option>
          <?php echo opc_tabla("CM");?>
          </select>
          <script>seleccionar("derivante","<?php echo $r['derivante']?>");</script>
	</div><br><br>
        <div class="form-group has-warning">
   	  <label class="label-form">Especificar (en caso de <br>Otros Solicitantes)</label>
	  <input class="form-control" id="derivante_especificar" name="derivante_especificar" size="50" maxlength="60" value="<?php echo $r['derivante_especificar']?>">	
	</div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Ingreso</label>
	  <input class="form-control" id="fecha_ingreso" size="10" maxlength="10" name="fecha_ingreso" value="<?php echo ffec($r["fecha_ingreso"])?>" required onblur="valta(this.id)">
        </div>
        <h4>Completar los dos campos siguientes solo en caso que se haya rechazado la solicitud</h4>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Rechazo</label>
	  <input class="form-control" id="fecha_rechazo" size="10" maxlength="10" name="fecha_rechazo" value="<?php echo ffec($r["fecha_rechazo"])?>" onblur="valida_fecha(this.id,1)">
        </div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Informe/CCOO Rechazo</label>
	  <input class="form-control" id="ccoo_asignacion" name="ccoo_asignacion" size="45" maxlength="60" value="<?php echo $r['ccoo_asignacion']?>">	
        </div><br><br>
	<h4>Completar el campo siguiente solo en caso que se haya cancelado la solicitud por parte del solicitante</h4>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Cancelaci&oacute;n</label>
	  <input class="form-control" id="fecha_cancelacion" size="10" maxlength="10" name="fecha_cancelacion" value="<?php echo ffec($r["fecha_cancelacion"])?>" onblur="valida_fecha(this.id,1)">
        </div><br><br>
	
<input name="id" value="<?php echo $id?>" hidden>
<button class="btn-primary" type="submit">Guardar Cambios</button>
</form>
</div>
<script>
function valta(id){
  valida_fecha(id);
  if(document.getElementById(id).value==""){return false;};
  if(fsql(document.getElementById(id).value)>fsql("<?php echo $_SESSION['DiaHoy']?>")){document.getElementById(id).value="";return false;};
  return true;
}

function valida(){
 if(!valta("fecha_ingreso")){return false;};
 return true;
}
</script>
</body>
</html>