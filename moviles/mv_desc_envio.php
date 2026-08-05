<?php
include("funciones.php");
session_start();
$id=$_GET['id'];

$orig="subidas/mv_sup".$id.".xls";
$nomb="mv_sup".$id.".xls";
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