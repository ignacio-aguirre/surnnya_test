<?php
include("funciones.php");
session_start();
if(isset($_GET["ruta"])){$_SESSION["ruta"]=$_GET["ruta"]; Redirect("descargar");};
$filePath = $_SESSION["ruta"];
if(file_exists($filePath)){
    $fileName=substr($filePath,-strrpos($filePath,"/"));
    // Define headers
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=".$fileName);
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");
    
    // Read the file
    readfile($filePath);
    exit;
}else{
    echo 'No existe el archivo '.$filePath;
};
?>