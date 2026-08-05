<?php
include("Funciones.php");
session_start();
$frase=$_GET["busqueda"];
$sql="select sujetos.legajo, apellidos, nombres,sexo from sujetos where cerrado<>1 ";
 if(intval($frase)!=0) {$sql=$sql." and (sujetos.legajo=".$frase." or sujetosDNI=".$frase." or rib_numero=".$frase.") ";}
 else {
 $salida=array();
 $palabras=parsea($frase);
 foreach ($palabras as &$palabra) {
    $da = un_registro("select lex_sonido('".$palabra."') as son");
    $sql=$sql." and sonidos like '%".$da['son']."%' ";};
 };
 $sql=$sql." order by apellidos, nombres limit 1";
$r=un_registro($sql);
echo $r["sexo"],$r["legajo"],$r["apellidos"],', ',$r["nombres"];
?>