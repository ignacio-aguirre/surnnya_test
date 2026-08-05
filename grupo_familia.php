<?php
include("Funciones.php");
session_start();
$id=$_GET["id"];
if($id!=""){
	$legajos=registros("select grupo_legajo from grupos_legajos where grupo=".$id);

	while ($le=mysqli_fetch_assoc($legajos)) {
		$legajos2=registros("select grupo_legajo,madre, apellidos, nombres,td.deno as tipodoc,sujetosdni as nrodoc,edadcalc(f_nacimiento,sujetosedad,sujetosactedad,null,curdate()) as edadhoy from grupos_legajos left join sujetos on sujetos.legajo=grupo_legajo left join tablas td on td.tipo='TD' and td.valo=tipodni where grupo=".$id);
		while($le2=mysqli_fetch_assoc($legajos2)) {
			if($le["grupo_legajo"]!=$le2["grupo_legajo"]) { 
				$cant=un_registro("select count(*) as cant from sujetos_familia where fami_legajo=".$le["grupo_legajo"]." and fami_lega=".$le2["grupo_legajo"]);
				if($cant["cant"]==0) ejecute("insert into sujetos_familia (fami_legajo, fami_lega, fami_paren, fami_apellidos, fami_nombres,fami_edad,fami_actedad,fami_obse) values("
				.$le["grupo_legajo"].",".$le2["grupo_legajo"].",'".si($le2["madre"]=="1","M","H")."','".$le2["apellidos"]."', '".$le2["nombres"]."',".nulea($le2["edadhoy"]).", curdate(),'".$le2["tipodoc"].$le2["nrodoc"]."')");
			};
		};
	};
};	
header('Location: grupos2?id=' . $id);
?>
</body>
</html>