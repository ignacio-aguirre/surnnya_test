<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Subida de Archivos";
include("encabezado.php");
$status = "Es obligatorio indicar el tipo de archivo y una descripción del mismo";

if (
    ($_POST["action"] ?? "") == "upload" &&
    ($_POST["tipoarchivo"] ?? "-1") != "-1" &&
    ($_POST["descripcion"] ?? "") != ""
) 
{

    // obtenemos los datos del archivo

    $fechadoc=fsql($_POST["fecha"]);

    $tipoarchivo=$_POST["tipoarchivo"];

    $descripcion=$_POST["descripcion"];

    $tamano = $_FILES["archivo"]['size'];

    $tipo = $_FILES["archivo"]['type'];

    $archivo = normaliza($_FILES["archivo"]['name']);

    $random=substr(md5(uniqid(rand())),0,10);

    $prefijo=substr($random,0,4);

    $destino = "repositorio/".substr($_SESSION["DiaHoy"],-4)."/".substr($_SESSION["DiaHoy"],3,2)."/".$prefijo."_".$archivo;

    $ret=$_POST["ret"];



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

            $sql="insert into archivos_subidos(as_path,as_tipo,as_descripcion,as_fecha,as_usuario,as_dispositivo,as_random,as_fechadoc) values('".$destino."',".$tipoarchivo.",'".$descripcion."', curdate(),'".$_SESSION['glusua']."', ".$_SESSION['gldispo'].",'".$random."',".$fechadoc.")";

            $id=inserte($sql);

            if($_POST["legajo"]!="") {

              ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'S',".$_POST["legajo"].")");
              if($_POST["tipoarchivo"]==186){
		verificarecurso($_POST["legajo"],$_POST["fecha"]);
              };

	      Redirect("memorizar?tipo=ARC&valor=".$id."&descripcion=".$descripcion."&retorno=S".$_POST["legajo"]);

             };

            if($_POST["grupo"]!="") {

             ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'G',".$_POST["grupo"].")");

             $legajos=registros("select grupo_legajo from grupos_legajos where grupo=".$_POST["grupo"]);

	     while($leg=mysqli_fetch_assoc($legajos)){

              ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'S',".$leg["grupo_legajo"].")");       
              if($_POST["tipoarchivo"]==186){
		verificarecurso($leg["grupo_legajo"],$_POST["fecha"]);
              };
		
             };

             Redirect("memorizar?tipo=ARC&valor=".$id."&descripcion=".$descripcion."&retorno=G".$_POST["grupo"]);

            };

            
            

            if($_POST["hogar"]!="") {

             ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'H',".$_POST["hogar"].")");

             Redirect("memorizar?tipo=ARC&valor=".$id."&descripcion=".$descripcion."&retorno=H".$_POST["hogar"]);

            };



            if($_POST["familia"]!="") {

             ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'F',".$_POST["familia"].")");

             Redirect("memorizar?tipo=ARC&valor=".$id."&descripcion=".$descripcion."&retorno=F".$_POST["familia"]);

            };



            if($_POST["visita"]!="") {

             ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'V',".$_POST["visita"].")");

             Redirect("supervisita?id=".$_POST["visita"]);

            };

  	    if($_POST["ong"]!="") {

             ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'O',".$_POST["ong"].")");

             Redirect("ongs_archivos?id=".$_POST["ong"]);

            };

 


           if($_POST["personal"]!="") {

             ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'P',".$_POST["personal"].")");

             Redirect("unpersonal?iid=".$_POST["personal"]);

            };



           if($_POST["dispositivo"]!="") {

             ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'D',".$_POST["dispositivo"].")");

             Redirect("subir_archivos_dispositivo");

            };



           if($_POST["altabaja"]!="") {

             ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'A',".$_POST["altabaja"].")");

             ejecute(si($tipoarchivo=="23","update altasybajas set nota=","update altasybajas set nota_derivacion=").$id." where idaltasybajas=".$_POST["altabaja"]);

             $leg=un_campo("select legajo from altasybajas where idaltasybajas=".$_POST["altabaja"]);

	     if($leg!="") ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$id.",'S',".$leg.")");       



             Redirect($ret);

            };

           

           



        } else {

            $status = "Error al subir el archivo. Código: ".($_FILES["archivo"]["error"] ?? "sin archivo");

        }

    } else {

        $status = "El nombre de archivo está vacío";

    }

};





Alerte($status);



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



function verificarecurso($legajo,$fecha){
$id=un_campo("select idhogares_admision from hogares_admision where admi_legajo=".$legajo." and admi_susp is null and admi_fderiv is null limit 1");
if(!$id>"0"){$id=inserte("insert into hogares_admision(admi_fped,admi_legajo) values(".fsql($fecha).",".$legajo.")");};
return true;
}

?>

</body>

</html>