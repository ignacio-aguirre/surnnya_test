<?php 
include("funciones.php");
session_start();
if(!isset($_SESSION["usuario"])){Redirect("salir");};
$status="";
$_SESSION["prestacion"]="Informes";
include("encabezado.php");
?>
</div>
<div class="container">
<div class="table-responsive col-md-12 pre-scrollable">
<table  class="table table-hover table-condensed">
<thead id="enca">
<tr class="bg-primary"><th>A&ntilde;o</th><th>Trimestre</th><th>Apellidos y Nombres</th><th>Firmas</th><th>Acciones</th></tr>
</thead>
<tbody id="datos">
<?php
$reg=registros("select * from trimestrales 
 left join sujetos on sujetos.legajo=trimestrales.legajo_surnnya where hogar=".$_SESSION["hogar"]." order by anio desc,trimestre desc,apellidos,nombres");
while($r=mysqli_fetch_assoc($reg)){
  $ide=un_campo("select id from trim_identidad where trimestral=".$r["id"]);
  if($ide>0){
  echo "<tr><td>".$r["anio"]."</td><td>".$r["trimestre"]."</td><td>".$r["Apellidos"]." , ".$r["Nombres"]."</td><td>";  
  $usuarios=registros("select case when usuario=0 then 'DLABORDE' else usuarios_hogares.descripcion end as descr from trim_firmas left join usuarios_hogares on usuario=usuarios_hogares.id where trimestral=".$r["id"]." order by fecha, descripcion");
  $usu="";
  while($u=mysqli_fetch_assoc($usuarios)){
   $usu=$usu.$u["descr"]."<br>";
  };
  echo $usu."</td><td><button class='btn-success btn-md' onclick='ver(".$r["id"].")')>Ver</button>&nbsp;&nbsp;";
  if($r["trimestre"]==$_SESSION["trimestre"] && $r["anio"]==$_SESSION["anio"]){ echo "<input class='form-check-input' type='checkbox' id='f".$r["id"]."'><label class='form-check-label'>Firmar</label>";};
  echo "</td></tr>";
};
};
?>
</tbody>
</table>
</div>
<form class="form-inline" action="firma_varios_do" method="get" onsubmit="return valida_firma()">
<div class="form-group has-warning">
<label class="label-form">DNI</label>
<input class="form-control" id="dni" name="dni" size="8" maxlength="8" onblur="valida_entero(this.id)" autofocus>
</div>
<input name="ids" id="ids" >
<button class="btn-success" type="submit">Firmar Informes seleccionados</button>
</form>
</div>
<script>
function ver(informe){
naveganuevo("informe?id="+informe);
return true;
}
function firmar(informe){
navega("firma?id="+informe);
return true;
}
function valida_firma(){
  valida_entero("dni");
  if(document.getElementById("dni").value==""){alert("DNI es obligatorio");return false;};
  dnivalor=parseInt(document.getElementById("dni").value);
  if(dnivalor<1000000){alert("DNI es incorrecto");return false;};
  valores="";
  x=document.getElementsByClassName("form-check-input");
  for (let i = 0; i < x.length; i++) {
      if(x[i].checked) {valores=valores+x[i].id;};
  };
  document.getElementById("ids").value=valores;
  return true;
}
</script>
</body>
</html>