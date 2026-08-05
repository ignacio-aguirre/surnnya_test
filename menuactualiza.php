<?php 
session_start();
include("Funciones.php");
if (!isset($_SESSION['gldispo'])||!isset($_POST["id"])) {Redirect("salir");};
$id=$_POST["id"];
$descripcion=tpost("descripcion");
$nombre=tpost("nombre");
if ($id==0) {
   $sql="insert into menues (descripcion, nombre) values(".$descripcion.",".$nombre.")";}
else{
   $sql="update menues set descripcion=".$descripcion.
   ",nombre=".$nombre.
   " where idmenues=".$id;
};
ejecute($sql);
Redirect("menues"); 
?>
