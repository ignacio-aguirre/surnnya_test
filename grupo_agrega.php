<?php

include("Funciones.php");

session_start();

$legajo=nget("legajo"); 

$grupo=nget("grupo");

$madre=nget("madre");

ejecute("insert into grupos_legajos(grupo, grupo_legajo,madre) values(".$grupo.",".$legajo.",".$madre.")");

Redirect("grupos2?id=" . $grupo);

?>

</body>

</html>