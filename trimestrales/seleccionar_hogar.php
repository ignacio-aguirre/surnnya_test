<?php 
include("funciones.php");
session_start();
if($_SESSION["hogar"]>0){Redirect(".");};
$_SESSION["prestacion"]="Seleccionar Hogar";
$opc="";
if(!isset($_SESSION["usuario"]) && !isset($_SESSION["glidusua"])) {Redirect(".");};
if(!isset($_SESSION["menu"])){
$reg=registros("select nombre, hogar from usuarios_hogares_roles left join dispositivos on hogar=dispositivos.id where usuario=".$_SESSION["usuario"]." order by dispositivos.nombre");
while($r=mysqli_fetch_assoc($reg)){
 $opc=$opc."<option value=".$r["hogar"].">".$r["nombre"]."</option>";
};
}
else{
$_SESSION["usuario"]="0";
$par=un_registro("select * from parametros limit 1");
      $_SESSION["trimestre"]=$par["trimestre"];
      $_SESSION["anio"]=$par["trimestre_anio"];
$reg=registros("select nombre, id from dispositivos where (baja is null or datediff(curdate(),baja)<=120) and tipo_dispositivo=2 and nomina_hogares=1 order by nombre");

while($r=mysqli_fetch_assoc($reg)){
 $opc=$opc."<option value=".$r["id"].">".$r["nombre"]."</option>";
};

};
include("encabezado.php"); 

?>
</div>
<div class="container">
<form class="form-inline" method="get" action="seleccionar_hogar_do">
<div class="form-group has-warning">
<label class="label-form">Dispositivo</label>
<select name="hogar" id="hogar" class="form-control" autofocus>
<?php echo $opc?>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form">A&ntilde;o</label>
<select class="form-control" name="anio" id="anio" <?php echo si($_SESSION["usuario"]=="0" && substr($_SESSION["glperfil"],-2)=="PE",""," disabled")?>>
<option value="2022">2022</option>
<option value="2023">2023</option>
<option value="2024">2024</option>
<option value="2025">2025</option>
<option value="2026">2026</option>
</select>

</div>
<div class="form-group has-warning">

<label class="label-form">Trimestre</label>
<select class="form-control" name="trimestre" id="trimestre" <?php echo si($_SESSION["usuario"]=="0" && substr($_SESSION["glperfil"],-2)=="PE",""," disabled")?>>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
</select>
</div>
<script>
seleccionar("anio",'<?php echo $_SESSION["anio"]?>');
seleccionar("trimestre",'<?php echo $_SESSION["trimestre"]?>');
</script>

<hr>
<button class="btn-primary">Continuar</button>
</form>
</div>
</body>
</html>
