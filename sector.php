<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Sector";
include("encabezado.php");
if (!isset($_GET["id"])) {Redirect(".");};
$id=nget("id");
$r=un_registro("select * from sectores where id=".$id);
$deno=tget("deno");
$depe=nget("dependencia");
if($deno!=tsql("")){
   if ($id==0) {ejecute("insert into sectores(denominacion,dependencia) values(".$deno.",".$depe.")");}
  else {ejecute("update sectores set denominacion=".$deno.", dependencia=".$depe." where id=".$id);};
 Redirect("sectores");
};
?>
</div>
<div class="container">

<form class="form" method='get' onsubmit='return valida_datos()' enctype='multipart/form-data'>

<div class="form-group has-warning">
 <label class="label-form" for="deno">Denominaci&oacute;n</label>
 <input size='40' maxlength="45" class='form-control' onblur='valida_0(this.id)' name='deno' id='deno' value='<?php echo $r["denominacion"];?>'/>
</div>

<div class="form-group has-warning">
 <label class="label-form" for="tele">Dependencia</label>
 <select class="form-control" name='dependencia' id='dependencia'>
 <?php
  $sec=registros("select * from sectores where baja is null order by denominacion");
  while($s=mysqli_fetch_assoc($sec)){
    echo "<option value='".$s["id"]."'>".$s["denominacion"]."</option>";
  };
 ?>
 </select>
 <script>seleccionar("dependencia","<?php echo $r["dependencia"]?>")</script>
</div>

<input type='hidden' name='id' value='<?php echo $id;?>'/>

<input type='submit' name='Form' value='Aceptar'></td></tr>

</form>

<script>
enfoca("deno");
</script>
</div>
</body>
</html>