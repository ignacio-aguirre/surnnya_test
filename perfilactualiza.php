<?php 
session_start();
include("Funciones.php");
if (!isset($_SESSION['gldispo'])||!isset($_POST["id"])) {Redirect("salir");};
$id=$_POST["id"];
$denominacion=tpost("denominacion");
$menu_nuevo=npost("menu_nuevo");
$soloconsulta=npost("soloconsulta");
$acciones=npost("acciones");
$nuevo_sujeto=npost("nuevo_sujeto");
$editar_sujeto=npost("editar_sujeto");
$todos_dispo=npost("todos_dispo");
$admision=npost("admision");
$super_supervisar=npost("super_supervisar");
$usuarios=npost("usuarios");
$tabla_hogares=npost("tabla_hogares");
$tabla_ongs=npost("tabla_ongs");
$editar_dispositivos=npost("editar_dispositivos");
$definicion=tpost("definicion");
$menu=tsql(un_campo("select descripcion from menues where idmenues=".$menu_nuevo));
if ($id==0) {
   $sql="insert into perfiles (denominacion, menu_nuevo, menu, soloconsulta,  acciones, nuevo_sujeto,editar_sujeto,todos_dispo,admision,
    super_supervisar,editar_dispositivos,usuarios,tabla_hogares,tabla_ongs,definicion) values(".$denominacion.",".$menu_nuevo.",".$menu.",".$soloconsulta.","
    .$acciones.",".$nuevo_sujeto.",".$editar_sujeto.",".$todos_dispo.",".$admision.",".$super_supervisar.", ".$editar_dispositivos.
    ",".$usuarios.",".$tabla_hogares.",".$tabla_ongs.",".$definicion.")";}
else{
   $sql="update perfiles set denominacion=".$denominacion.
   ",menu_nuevo=".$menu_nuevo.
   ",menu=".$menu.
   ",soloconsulta=".$soloconsulta.
   ",acciones=".$acciones.
   ",nuevo_sujeto=".$nuevo_sujeto.
   ",editar_sujeto=".$editar_sujeto.
   ",todos_dispo=".$todos_dispo.
   ",admision=".$admision.
   ",super_supervisar=".$super_supervisar.
   ",usuarios=".$usuarios.
   ",tabla_hogares=".$tabla_hogares.
   ",tabla_ongs=".$tabla_ongs.
   ",editar_dispositivos=".$editar_dispositivos.
   ",definicion=".$definicion.
   " where id=".$id;
};

ejecute($sql);

Redirect("perfiles"); 
?>
