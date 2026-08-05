<?php 
include("funciones.php");
session_start();
tranca();?>
<html lang="es">
<head>
<title>Usuarios</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
</head>
<body>
<script>
function unusuario(id){
navega("unusuario?id="+id);
}
</script>
<div class="container" align="right">
<a href="menu"><img width="20" height="20" src="imagenes/menu.png">Men&uacute;</a>&nbsp;&nbsp;<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a>
</div>
<div class="container" align="center">
<h1>Usuarios</h1>
<?php if($_SESSION["escritura"]==1) echo "<a href='nuevousuario'><img width='20' height='20' src='imagenes/mas.png'>&nbsp;Agregar</a>";?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table table-stripped table-bordered table-hover table-condensed">
<tr class="info">
<th>Email</th><th>Grup.</th><th>Apellidos</th><th>Nombres</th><th>Organismo</th><th>Sector</th><th>Carga</th><th>Adm<br>Sis</th><th>Clau<br>Conf</th><th>Ver</th><th>Baja</th>
</tr>
<?php
$cas=registros("select idusuarios,email,grupal, apellidos,nombres,reparticion,sector,supervisa_sector,supervisa_sistema,clausula from usuarios where baja is null order by reparticion,sector,apellidos, nombres");
while($c=mysqli_fetch_assoc($cas)){
 echo "<tr><td>",$c["email"],"</td><td>",si($c["grupal"]==1,"Si","No"),"</td><td>",$c["apellidos"],"</td><td>",$c["nombres"],"</td><td>",$c["reparticion"],"</td><td>",$c["sector"],"</td><td>",si($c["supervisa_sector"]==1,"Si","No"),"</td><td>",si($c["supervisa_sistema"]==1,"Si","No"),
 "</td><td>",si($c["clausula"]>0,"Si","No"),"</td><td><btn class='btn-sm btn-primary' onclick='ver(".$c["idusuarios"].")'>Ver</btn></td><td>
<btn class='btn-sm btn-danger' onclick='baja(".'"'.$c["apellidos"].'",'.$c["idusuarios"].")'>Baja</btn></td></tr>";
};
?>
</table>
</div>
</div>
<script src="../bootstrap-3.3.6-dist/js/jquery.js"></script>
<script>
function ver(id){
  navega("unusuario?id="+id);
}
function baja(apellido,id){
 if(confirm("Confirmas la baja del usuario "+apellido)){navega("usuario_baja?id="+id);};
 return false;
};
</script>
<script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="js/generales.js"></script>
</body>
</html>
