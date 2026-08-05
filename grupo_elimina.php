<?php
include("Funciones.php");
session_start();
$id=$_GET["id"];
ejecute("delete from grupos where idgrupos=".nulea($id));
ejecute("delete from grupos_legajos where grupo=".nulea($id));
Redirect('grupos');
?>
</body>
</html>