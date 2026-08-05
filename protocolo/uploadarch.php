<?php
include("funciones.php");
session_start();
$_SESSION['DiaHoy']=ffec(un_campo("select curdate() as hoy"));
tranca();
$status = "Es obligatorio indicar una descripción del archivo";
if ($_POST["descripcion"]!="") {
    // obtenemos los datos del archivo
    $descripcion=$_POST["descripcion"];
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = normaliza($_FILES["archivo"]['name']);
    $caso=$_POST["id"];
	$fecha=fsql($_POST["fecha_archivo"]);
    $origen=$_POST["origen"];
    $id=inserte("insert into archivos(descripcion,caso,fecha,usuario,origen,fecha_alta) values('".$descripcion."',".$caso.",".$fecha.",".$_SESSION["usuario"].",".$origen.",curdate())");
    
    $carpeta = "repositorio/".substr($_SESSION["DiaHoy"],-4)."/".substr($_SESSION["DiaHoy"],3,2);

    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0775, true);
    }

$destino = $carpeta."/".$id."_".$archivo;
if (
    isset($_FILES["archivo"]) &&
    $_FILES["archivo"]["error"] === UPLOAD_ERR_OK &&
    is_uploaded_file($_FILES["archivo"]["tmp_name"]) &&
    move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)
) {
            $status = "Archivo subido: ".$archivo;

            $status = "Archivo subido: ".$archivo;
            ejecute("update archivos set ruta=".tsql($destino)." where idarchivos=".$id);
	    loguea("Subir Documento",$caso,$id);	
            Redirect("documentacion");
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
        $status = "El nombre de archivo está vacío";
    
};


echo $status;

function normaliza($texto){
 $t=strtolower($texto);
 $largocadena=strlen($t);
 $salida="";
 for ($i = 0; $i < $largocadena; $i++) {
    $l=substr($t,$i,1);
    if(!esletnum($l)) $l="x";
    $salida=$salida.$l;
 };
return $salida;
}

function esletnum($letra){
if(($letra<"a"||$letra>"z"))
 {
    if($letra!="." && $letra!="\\"&& $letra!=":" && $letra!=" " && $letra!="_" && $letra!="-" && $letra!="+") {
      if(($letra<"0"||$letra>"9")) {
         return false;
      };
    };
 };
return true;
}


?>
</body>
</html>