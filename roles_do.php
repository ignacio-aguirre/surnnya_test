<?php 
include("Funciones.php");
session_start();
$perfil=nget("perfil");
$per=un_registro("select * from perfiles where id=".$perfil);
$_SESSION['glperfil']=$per['denominacion'];
$_SESSION['glidperfil']=$perfil;
//$_SESSION['glcons'] = "1";
$_SESSION['gl_acciones'] = $per['acciones'];
$_SESSION['gl_nuevo_sujeto']= $per['nuevo_sujeto'];
$_SESSION['gl_editar_sujeto']= $per['editar_sujeto'];
$_SESSION['gl_todos_dispo']= $per['todos_dispo'];
$_SESSION['gl_admi']= $per['admision'];
$_SESSION['gl_super_super']= $per['super_supervisar'];
$_SESSION['gl_usuarios']= $per['usuarios'];
$_SESSION['gl_tablahogares']=$per['tabla_hogares'];
$_SESSION['gl_tablaongs']=$per['tabla_ongs'];
$_SESSION['legajo']="";
$_SESSION['menu']=$per['menu'];
$_SESSION['mnu']=$per['menu_nuevo'];
Redirect($_SESSION["menu"]);
?>
    

    

