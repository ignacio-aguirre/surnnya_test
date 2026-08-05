<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Acceso no autorizado";
include("encabezado-test.php");
session_destroy();
?>
<h2 class="text-warning"></h2>
</body>
</html>