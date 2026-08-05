<h4>Nuevo texto</h4>
<form method="get" action="guarda_texto">
<textarea name="texto" required cols="80" rows="5"></textarea>
<br>
<button>Guardar</button>
</form>
<table>
	<tr><th>Id</th><th>Texto</th></tr>

<?php
$cn_ip="p:localhost";
$cn_usuario="root";
$cn_password="Arg2_eX6nut";
$cn_base="testing_sql";
$link= mysqli_connect($cn_ip, $cn_usuario, $cn_password) or die(mysqli_error($link));
mysqli_select_db($link,$cn_base) or die(mysqli_error($link));
$sql="select * from textos order by id";
$datos=mysqli_query($link,$sql) or die(mysqli_error($link));
while($r=mysqli_fetch_assoc($datos)){
	echo "<tr><td>".$r["id"]."</td><td>".$r["texto"]."</td></tr>";
}
?>

</table>	