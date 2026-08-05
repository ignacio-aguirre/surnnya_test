<?php
session_start();
include("Funciones.php");
session_destroy();
Redirect("salir?mensaje=El  intento de ingreso al sistema ha fallado. Vuelva a intentar");
?>
