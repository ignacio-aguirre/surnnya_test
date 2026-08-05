<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Consulta de Usuarios Activos";
include("encabezado.php");
$frase="";
if (isset($_GET["frase"])) $frase=trim($_GET["frase"]);
?>
</div>
<div class="container">
<h3>Encontr&aacute; el legajo de un usuario LUNNA a partir de un texto</h3>
<form class="form-inline" method="get">

<div class="form-group has-warning">
<input class="form-control" type="text" size='60' maxlength='60' name="frase" id='frase' required autofocus value="<?php echo $frase;?>" placeholder="
Pod&eacute;s buscar por nombre y apellido, usuario SADE y CUIL" />
</div><br>
<br>
<input class="form-control btn-primary" type="submit" value="Buscar" />
</form>
<h4>Registros encontrados (primeros 15)</h4>
<div class='table-responsive'>
<table class='table table-striped table-bordered table-condensed'>
<thead><tr class='bg-primary'><th align='left'>Apellidos, Nombres</th><th align='left'>CUIL</th><th>Usuario SADE</th><th>Email</th><th>Perfil LUNNA</th></thead>
<tbody>
<?php

if (isset($_GET["frase"])){
 $reg = registros("select * from lunna_activos where (nombre like '%".$frase."%' or cuil like '%".$frase."%' or usuario like '%".$frase."%') and baja is null order by nombre limit 15");
 while($r=mysqli_fetch_assoc($reg)){
    $url="navega('lunna_unactivo?id=".$r["id"]."')";
    echo cf($url)."<td>".$r["nombre"]."</td><td>".$r["cuil"]."</td><td>".$r["usuario"]."</td><td>".$r["mail"]."</td><td>".$r["perfil"]."</td></tr>";
 };
};
?>
</tbody>
</table>
</div>
</div>
</body>
</html>