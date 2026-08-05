<?php
include("Funciones.php"); 
session_start();
$sent=$_GET["sent"];
$reg=ejecute($sent);
while($r=mysqli_fetch_assoc($reg)){
	echo "<tr>";
	foreach($r as $item){
		echo "<td>".$item."</td>";
	}
	echo "</tr>";
}
?>