<?php 
// conexión con la base de datos
$cn_ip="p:localhost";
$cn_usuario="root";
$cn_password="Arg2_eX6nut";
$cn_base="testing_sql";
$link= mysqli_connect($cn_ip, $cn_usuario, $cn_password) or die(mysqli_error($link));
mysqli_select_db($link,$cn_base) or die(mysqli_error($link));

// lee la variable proveniente del formulario
$texto=$_GET["texto"];

// inserta en la tabla textos un nuevo registro con el texto recibido
$sql="insert into textos(texto) values('".$texto."')";

mysqli_query($link,$sql) or die(mysqli_error($link));

// redirecciona a index
Redirect("index");



function Redirect($Str_Location, $Bln_Replace = 1, $Int_HRC = NULL)
{  
        if(!headers_sent())
        {
            header('location: ' . urldecode($Str_Location), $Bln_Replace, $Int_HRC);
            exit;
        }
    exit('<meta http-equiv="refresh" content="0; url=' . urldecode($Str_Location) . '"/>'); # | exit('<script>document.location.href=' . urldecode($Str_Location) . ';</script>');
    return;

}

?>