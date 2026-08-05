<?php
session_start();
include("funciones.php");
session_destroy();
Redirect(".");
?>