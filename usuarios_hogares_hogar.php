<?php
include("Funciones.php");
session_start();

$_SESSION["prestacion"]="Dispositivo y Funci&oacute;n de usuario de hogar";
include("encabezado.php");
$id=nget("id");
$r=un_registro("select * from usuarios_hogares where baja is null and id=".$id);
?>
</div>
<div class="container">
<h4>Dispositivo y Funci&oacute;n de <?php echo $r["apellidos"]." , ".$r["nombres"]?></h4>
<form class="form-inline" method="get" action="usuarios_hogares_hogar_do" onsubmit="return valida()">
<div class="form-group has-warning">
 <label class="label-form">Dispositivo</label>
 <select class="form-control" name="hogar" id="hogar" autofocus>
  <?php if($r["hogar"]==398){ echo "<option value='398'>Supervisi&oacute;n</option>";}
 else{
echo $_SESSION["Opc_Hoga"];}?>
 </select>
 <script>
 seleccionar("hogar","<?php echo $r["hogar"]?>");
 </script>
</div>
<br><br>
<div class="form-group has-warning">
 <label class="label-form">Funci&oacute;n</label>
 <input class="form-control" name="funcion" id="funcion" size="50" maxlength="50" onblur="valida_0(this.id)" value="<?php echo $r["funcion"]?>">
</div>
<hr>
<input hidden name="id" value="<?php echo $id?>">
<input class="bg-primary" type="submit" value="Registrar">
</form>
</div>
<script>
function valida(){
 valida_0("funcion");
 if(!(document.getElementById("hogar").value>"0")){alert("hogar es obligatorio");return false;};
 if(document.getElementById("funcion").value==""){alert("funcion es obligatorio");return false;};

 return true;
}
</script>
</body>
</html>