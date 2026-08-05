<?php 
include("Funciones.php"); 
session_start();
$legajo=nget("legajo");
$r=un_registro("select apellidos,nombres from sujetos where legajo=".$legajo);
$prestacion="Ingreso en Dispositivo de Pre egreso";
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
include("encabezado-test.php");
$fech=$_SESSION["DiaHoy"];
?>

<script type="text/javascript">
function valida() {
valida_fecha("fecha");
legajo="<?php echo $legajo;?>";
if(document.getElementById("fecha").value=="") {alert("complete la fecha de Alta");return false;};
fecha=fsql(document.getElementById("fecha").value);
fechahoy=fsql('<?php echo $_SESSION["DiaHoy"];?>');
if(fecha>fechahoy) {alert("Lo siento, no se permiten altas con fechas futuras. Gracias");return false;};
cantidad=ejec("sq_altasbajas","1","&legajo="+legajo);
if(parseInt(cantidad)>0) {alert("hay un alojamiento en curso no puede procesarse un nuevo ingreso");return false;};
ultimabaja=ejec("sq_altasbajas","2","&legajo="+legajo);
if(ultimabaja!=""){
  if(fsql(ultimabaja)>fecha){alert("la ultima baja es mayor a la fecha de alta");return false;};
};
return true;
}
</script>
</div>
<div class="container">
 <div class="row">
   <div class="col-md-12">
    Apellidos: <strong><?php echo $r["apellidos"];?></strong>
   &nbsp;Nombres: <strong><?php echo $r["nombres"];?></strong>
   </div>
 </div>
 <hr>
 <form class="form-inline" action='alpre_alta_do' onsubmit='return valida()'>
  <div class="form-group has-warning">
   <label class="label-form" for="admi_hogar">Dispositivo</label>
   <select class="form-control" name="admi_hogar" id="admi_hogar" required autofocus>
	<option></option>
        <?php
          $hg=registros("select id, nombre from dispositivos where tipo_dispositivo=12 order by nombre");
	  while($h=mysqli_fetch_assoc($hg)){
            echo "<option value='".$h["id"]."'>".$h["nombre"]."</option>";
	  };
        ?>
   </select>
 </div>
 <br><br>
 <div class="form-group has-warning">
   <label class="label-form" for="fecha">Fecha de Alta</label>
   <input class="form-control" size="10" maxlength="10" name="fecha" id='fecha' onblur='valida_fecha(this.id,1)' value='<?php echo $fech;?>' required>
 </div>
 <input hidden name="legajo" value="<?php echo $legajo;?>">
 <br><br>
 <button class="btn-primary">Registrar Alta</button>
</form>
<hr>

<script type="text/javascript">
function aceptar(){
  if(valida_campos()){
	idh_ad="<?php echo $iid;?>";
	fecha=document.getElementById("fecha").value;
        navega("admialta_do?id="+idh_ad+"&fecha="+fecha);
  };
}
</script>
</div>
</body>
</html>