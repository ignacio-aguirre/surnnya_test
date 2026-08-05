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
<form class="form-inline" method="POST" action="fv_solicitud3_do" onsubmit="return valida()">
        <div class="form-group has-warning">
   	  <label class="label-form">Derivante / Solicitante: <?php echo $r["derivante_especificar"]?></label>
	</div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Ingreso: <?php echo ffec($r["fecha_ingreso"])?></label>
        </div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Articulaci&oacute;n con DZ/Sector CDNNYA</label>
	  <input class="form-control" id="fecha_articulacion" size="10" maxlength="10" name="fecha_articulacion" autofocus value="<?php echo ffec($r["fecha_articulacion"])?>" onblur="valida_fecha(this.id,1)">
        </div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Informe/CCOO Articulaci&oacute;n</label>
	  <input class="form-control" id="ccoo_asignacion" name="ccoo_asignacion" size="45" maxlength="60" value="<?php echo $r['ccoo_asignacion']?>">	
        </div>
	<hr>
       
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
 valida_fecha("fecha_articulacion",1);
 if(document.getElementById("fecha_articulacion").value!=""){ 
  if(!valta("fecha_articulacion")){return false;};
 }; 
 return true;
}
</script>
</body>
</html>