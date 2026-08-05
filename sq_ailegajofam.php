<?php
session_start();
include("Funciones.php");
$legajo=nget("legajo");
echo un_campo("select legajofamilia from ai_familias where legajofamilia=".$legajo);
exit;
?>