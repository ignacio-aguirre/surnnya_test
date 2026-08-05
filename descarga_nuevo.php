<?php
include("Funciones.php");
session_start();
$id=$_GET['id'];
//$r=un_registro("select case when fileserver is null then as_path else concat('https://undato.ar/fileserv/',fileserver) end as path,as_path as nombre  from archivos_subidos where idarchivos_subidos=".$id);
$r=un_registro("select as_path as path, as_path as nombre  from archivos_subidos where idarchivos_subidos=".$id);
$orig=$r["path"];
$nomb=substr($r["nombre"],25);
if(!empty($orig)){
    $fileName = basename($nomb);
    $filePath = $orig;
    if(!empty($fileName)){
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        
        // Read the file
        readfile($filePath);
        exit;
    }else{
        echo 'No existe el archivo.';
        echo '<br>'.$fileName;
        echo '<br>'.$filePath;

    }
}
?>