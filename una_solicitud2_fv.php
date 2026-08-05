<?php
include("Funciones.php");
session_start();
$id=$_GET["id"];
$r=un_registro("select * from fv_participaciones where id=".$id);
$_SESSION["prestacion"]="Solicitud Intervenci&oacute;n con la Familia ".un_campo("select descripcion from fv_familias where idfv_familias=".$r["familia"]);
include("encabezado-test.php");
?>
</div>
<div class="container">
<form class="form-inline" method="POST" action="fv_solicitud2_do" onsubmit="return valida()">
        <div class="form-group has-warning">
   	  <label class="label-form">Derivante / Solicitante: <?php echo un_campo("select info from tablas where tipo='CM' and valo=".$r["derivante"])?></label>
	</div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Ingreso: <?php echo ffec($r["fecha_ingreso"])?></label>
        </div><br><br>
        <div class="form-group has-warning">
   	  <label class="label-form">Expediente</label>
	  <input class="form-control" id="expediente" name="expediente" size="50" maxlength="100" value="<?php echo $r['expediente']?>" required autofocus>	
	</div><br><br>	
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Condiciones para Asignar</label>
	  <input class="form-control" id="fecha_condiciones" size="10" maxlength="10" name="fecha_condiciones" value="<?php echo ffec($r["fecha_condiciones"])?>" onblur="sale_condiciones()">
        </div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha Asignaci&oacute;n</label>
	  <input class="form-control" id="fecha_asignacion" size="10" maxlength="10" name="fecha_asignacion" value="<?php echo ffec($r["fecha_asignacion"])?>" onblur="sale_asignacion()">
          <script>if(document.getElementById("fecha_condiciones").value==""){
             document.getElementById("fecha_asignacion").value="";
             document.getElementById("fecha_asignacion").disabled=true;}
          </script>
        </div><br><br>
        <div class="form-group has-warning">
	  <label class="label-form">Centro Zonal</label>
	  <select id="efector" name="efector" class="form-control" >
	 <?php echo efectorespropios()?>
          </select>
	<script>if(document.getElementById("fecha_asignacion").value==""){
             document.getElementById("efector").value="";
             document.getElementById("ccoo_asignacion").value="";
             document.getElementById("efector").disabled=true;
             document.getElementById("ccoo_asignacion").disabled=true;
             }
             else{seleccionar("efector","<?php echo $r['efector']?>");};
          </script>

        </div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Informe/CCOO Asignaci&oacute;n</label>
	  <input class="form-control" id="ccoo_asignacion" name="ccoo_asignacion" size="45" maxlength="60" value="<?php echo $r['ccoo_asignacion']?>">	
        </div>
		<hr>
       
<input name="id" value="<?php echo $id?>" hidden>
<button class="btn-primary" type="submit">Guardar Cambios</button>
</form>
</div>
<script>
function sale_condiciones(){
 valida_fecha("fecha_condiciones",1);
 if(document.getElementById("fecha_condiciones").value!=""){
  valta("fecha_condiciones");
  if(document.getElementById("fecha_condiciones").value!=""){document.getElementById("fecha_asignacion").disabled=false;}
   else{document.getElementById("fecha_asignacion").disabled=true;document.getElementById("fecha_asignacion").value="";};
  }
 else{
  document.getElementById("fecha_asignacion").disabled=true;document.getElementById("fecha_asignacion").value="";
};
}

function sale_asignacion(){
 valida_fecha("fecha_asignacion","1");
 if(document.getElementById("fecha_asignacion").value!=""){
  valta("fecha_asignacion");
  if(document.getElementById("fecha_asignacion").value!=""){document.getElementById("efector").disabled=false;document.getElementById("ccoo_asignacion").disabled=false;}
   else{document.getElementById("efector").disabled=true;document.getElementById("efector").value="";document.getElementById("ccoo_asignacion").disabled=true;document.getElementById("ccoo_asignacion").value="";};
  }
 else{
  document.getElementById("efector").disabled=true;document.getElementById("efector").value="";
  document.getElementById("ccoo_asignacion").disabled=true;document.getElementById("ccoo_asignacion").value="";
};
}

function valta(id){
  valida_fecha(id);
  if(document.getElementById(id).value==""){return false;};
  if(fsql(document.getElementById(id).value)>fsql("<?php echo $_SESSION['DiaHoy']?>")){document.getElementById(id).value="";return false;};
  return true;
}

function valida(){
 if(!valta("fecha_ingreso")){return false;};
 sale_condiciones();
 sale_asignacion(); 
 return true;
}
</script>
<?php
function efectorespropios(){
  $s="<option value=''></option>";
  $reg=registros("select id, denominacion from sectores where programa=9 order by denominacion");
  while($r=mysqli_fetch_assoc($reg)){
    $s=$s."<option value=".$r["id"].">".$r["denominacion"]."</option>";
  };
  return $s;
}
?>

</body>
</html>