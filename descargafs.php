<?php
$orig=$_GET['link']; 
$nomb=$_GET['nombre'];
if(!empty($orig)){
    $fileName = basename($nomb);
    $filePath = "https://undato.ar/fileserv/".$orig;
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