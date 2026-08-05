<?php 
include("funciones.php");
session_start();
tranca();
if(!isset($_GET["id"])) Redirect(".");
$id=$_GET["id"];
$r=un_registro("select * from usuarios where idusuarios=".nulea($id));
?>
<html>
<head>
<title>Consulta de un Usuario</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
</head>
<body>
<script>
function cpass(id){
 pass=document.getElementById("pass").value;
 navega("cpassword?id="+id+"&pass="+pass);
 return true;
}
</script>
<div class="container" align="right">
<a href="menu"><img width="20" height="20" src="imagenes/menu.png">Men&uacute;</a>&nbsp;&nbsp;<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a>
</div>
<div class="container" align="center">
<h1>Consulta de Datos de Usuario</h1>
<?php if($_SESSION["escritura"]==1) echo "<a href='editausuario?id=".$id."'><img width='20' height='20' src='imagenes/editar.png'>&nbsp;Editar</a>";?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover table-condensed">
<tr class="info">
<th>Apellidos</th><th>Nombres</th><th>Email</th><th>Organismo</th><th>Sector</th><th>Grupal</th>
</tr>
<?php echo "<tr><td>",$r["apellidos"],"</td><td>",$r["nombres"],"</td><td>",$r["email"],"</td><td>",$r["reparticion"],"</td><td>",$r["sector"],"</td><td>",$r["grupal"],"</td></tr>";
?>

</table>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover table-condensed">
<tr class="info">
<th>Carga</th><th>Sistema</th><th>Contrase&ntildea</th>
</tr>
<?php echo "<tr><td>",$r["supervisa_sector"],"</td><td>",$r["supervisa_sistema"],"</td><td><input name='pass' id='pass' size='15' maxlength='15'><button class='btn btn-primary' onclick='script:cpass(",$r['idusuarios'],")'>Cambiar</button></td></tr>";
?>
</table>
</div>
<?php if(!$r["clausula"]>0){?>
<div class="container">
<section class="col-xs-12 col-sm-6">
<h4>Subir Cl&aacute;usula de Confidencialidad</h4>
<form class="" action="uploadclausula" onsubmit="return esta_archivo" method="POST" enctype="multipart/form-data">
<div class="form-group">
<input type="file" id="archivo" name="archivo">
<p class="help-block">Maximo 50MB</p>
</div>
<input type="hidden" name="id" value="<?php echo $id;?>">
<button class="btn btn-primary" name="action">Subir Archivo</button>
</form>
</section>
</div>
<?php }
else{?>
<div class="container">
<section class="col-xs-12 col-sm-6">
<strong>Descargar cl&aacute;usula de confidencialidad</strong>&nbsp;<a href='<?php echo un_campo("select ruta from archivos where idarchivos=".$r["clausula"])?>'><img src='imagenes/pdf-icon.png' height='25' width='25'></a>
&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn-danger" onclick="clau_eliminar(<?php echo $id?>)">Eliminar</button>
<?php };?>
</div>
<script src="../bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="js/generales.js"></script>
<script>
function esta_archivo(){
 return (document.getElementById("archivo").value!="");
};
function clau_eliminar(id){
   if(confirm("Confirmas la baja de la cl/confidencialidad")){
     navega("clausula_eliminar?id="+id);
   };
  return true;	
}
</script>
</body>
</html>

