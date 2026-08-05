<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Subir Medida";
include("encabezado-test.php");
$status = "Es obligatorio indicar la fecha de la medida y los d&iacute;as";

if ($_POST["fecha"]!="" ) {
    // obtenemos los datos del archivo
    $tipoarchivo="13";
    $descripcion="Medida";
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = normaliza($_FILES["archivo"]['name']);
    $random=substr(md5(uniqid(rand())),0,10);
    $prefijo=substr($random,0,4);
    $destino = "repositorio/".substr($_SESSION["DiaHoy"],-4)."/".substr($_SESSION["DiaHoy"],3,2)."/".$prefijo."_".$archivo;


    if ($archivo != "") {
       
        $carpeta = "repositorio/".substr($_SESSION["DiaHoy"],-4)."/".substr($_SESSION["DiaHoy"],3,2);

if (!is_dir($carpeta)) {
    mkdir($carpeta, 0775, true);
}

$destino = $carpeta."/".$prefijo."_".$archivo;

if (
    isset($_FILES["archivo"]) &&
    $_FILES["archivo"]["error"] === UPLOAD_ERR_OK &&
    is_uploaded_file($_FILES["archivo"]["tmp_name"]) &&
    move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)
) {
            $status = "Archivo subido: ".$archivo;

        
            $sql="insert into archivos_subidos(as_path,as_tipo,as_descripcion,as_fecha,as_usuario,as_dispositivo,as_random) values('".$destino."',".$tipoarchivo.",'".$descripcion."', curdate(),'".$_SESSION['glusua']."', ".$_SESSION['gldispo'].",'".$random."')";
            ejecute($sql);
            $id=un_campo("select idarchivos_subidos from archivos_subidos where as_path='".$destino."' and as_random='".$random."'");
            ejecute("update archivos_subidos set as_random=null where idarchivos_subidos=".$id);
            ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'S',".$_POST["legajo"].")");
            $paramail=ejecute("insert into sujetos_medidas(legajo,fecha,dias,archivo,acto_administrativo) values(".$_POST["legajo"].",".fsql($_POST["fecha"]).",".$_POST["dias"].",".$id.",".tpost("acto_administrativo").")");
	    Redirect("medida_grupo?archivo=".$id."&legajo=".$_POST["legajo"]."&fecha=".$_POST["fecha"]."&dias=".$_POST["dias"]."&noinno=".$noinno);
        } else {
            $status = "Error al subir el archivo. Código: ".($_FILES["archivo"]["error"] ?? "sin archivo");

        }
    } else {
        $status = "El nombre de archivo está vacío";
    }
};


Alerte($status);
Redirect("Suje_Cons_Juridicos?legajo=".$_POST["legajo"]);
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