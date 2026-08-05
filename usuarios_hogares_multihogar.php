<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Funciones de Usuarios Multihogar";
include("encabezado.php");
$id=nget("id");
$reg=registros("select usuarios_hogares_roles.*, nombre,ong from usuarios_hogares_roles left join dispositivos on hogar=dispositivos.id where usuario=".
$id." order by nombre");
$nya=un_campo("select concat(apellidos,', ',nombres) from usuarios_hogares where id=".$id);
?>
</div>
<div class="container">
<h4>Funciones de <?php echo $nya?> en Dispositivos</h4>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Dispositivo</th><th>Funci&oacute;n</th></tr>
<?php
$ong="0";
while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["nombre"]."</td><td>".$r["funcion"]."</td></tr>";
  $ong=$r["ong"];
}
?>
</table>
</div>
<h4>Agregar o actualizar funci&oacute;n en dispositivo</h4>
<form class="form-inline" method="get" action="usuarios_hogares_multihogar_nuevo" onsubmit="return valida()">
   <div class="form-group has-warning">
     <label class="label-form">ONG</label>
     <select class="form-control" name="ong" id="ong" onblur="completa_hogares()" autofocus>
     <?php echo tbla("hogares_ong")?>
     </select>
     <?php if($ong>"0") {
      echo "<script>";
      echo "seleccionar('ong','".$ong."');";
      echo "</script>";
     }?>
   </div>
   <br><br>
   <div class="form-group has-warning">
     <label class="label-form">Dispositivo</label>
     <select class="form-control" name="hogar" id="hogar">
     </select>	
   </div> 
   <br><br>
   <div class="form-group has-warning">
     <label class="label-form">Funci&oacute;n (dejar en blanco para eliminar)</label>
     <input class="form-control" name="funcion" id="funcion" size="50" maxlength="50" onfocus="trae_funcion()" onblur="valida_0(this.id)">
     </select>	
   </div> 
   <input name="id" hidden value="<?php echo $id?>">;
   <hr>
   <input class="btn-primary" type="submit" value="Registrar">
</form>
</div>
<script>
function valida(){
  valida_0("funcion");
  if(!(document.getElementById("hogar").value>"0")){alert("hogar es obligatorio");return false;};
  if(document.getElementById("funcion").value==""){alert("se elimina el registro para ese hogar");};
  return true;
}
function completa_hogares(){
ong=document.getElementById("ong").value;
document.getElementById("hogar").innerHTML=ejec("ej","hogares_ong","&ong="+ong);
};

function trae_funcion(){
hogar=document.getElementById("hogar").value;
document.getElementById("funcion").value=ejec("ej","roles_funcion","&hogar="+hogar+"&usuario=<?php echo $id?>");
};

</script>
</body>
</html>


