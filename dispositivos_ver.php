<?php
include("Funciones.php");
session_start();
$id=nget("id");
$r=un_registro("select dispositivos.*, hogares_ong.nombre as razon_social, legajo, hmod.deno as moda, ditip.deno as tipodispo, suput.deno as u_t, usuarios.apellido as uape,usuarios.nombre as unom, area.deno as agub   
 from dispositivos
 left join hogares_ong on ong=hogares_ong.id
 left join tablas hmod on hmod.tipo='HOMOD' and hmod.valo=modalidad 
 left join tablas area on area.tipo='AGUB' and area.valo=area_gubernamental 
 left join tablas ditip on ditip.tipo='DITIP' and ditip.valo=tipo_dispositivo
 left join tablas suput on suput.tipo='SUPUT' and suput.valo=unidad_tecnica
 left join usuarios on usuarios.id=usuario_monitoreo 
 where dispositivos.id=".$id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Ficha Dipositivo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<style type="text/css">
		header>div {
			display: flex;
			flex-direction: column;
			align-items: flex-end;
			font-size: 1.2em;
		}
		h1 {
			font-size: 1.2em;
		}
		h3 {
			font-size: 1.5em;
		}
		ul {
			list-style: none;
		}
		li, p {
			letter-spacing: 0.15em;
			text-align: justify;
		}
		span {
			margin: 0 0.5rem;
			font-weight: 550;
		}
	</style>
</head>
<body class="container">
	<header class="text-center">
		
		<h2 class="">Ficha de Datos Dispositivo</h2>
	</header>
	<main>
		<section>
			
			<ul class="list-group">
				<li class="list-group-item text-primary">Legajo <span><strong><?php echo $r["legajo"]?></strong></span>&nbsp;
				Nombre Dispositivo<span><strong><?php echo $r["nombre"]?></strong></span></li>
				<li class="list-group-item">ONG<span><strong><?php echo $r["razon_social"]?></strong></span>&nbsp;</li>
				<li class="list-group-item">&Aacute;rea Gubernamental<span><strong><?php echo $r["agub"]?></strong></span>&nbsp;
				Tipo Dispositivo<span><strong><?php echo $r["tipodispo"]?></strong></span></li>

				<li class="list-group-item">Referente<span><strong><?php echo $r["referente"]?></strong></span>&nbsp;
				Celular <span><strong><?php echo $r["celular_referente"]?></strong></span>&nbsp;
				DNI <span><strong><?php echo $r["dni_referente"]?></strong></span></li>
				<li class="list-group-item">Domicilio<span><strong><?php echo $r["domicilio"]." ".$r["piso_departamento"]?></strong></span>&nbsp;
				Localidad <span><strong><?php echo $r["localidad"]?></strong></span></li>
				<li class="list-group-item">Barrio <span><strong><?php echo $r["barrio"]?></strong></span>Comuna <span><strong><?php echo $r["comuna"]?></strong></span></li>
                                <li class="list-group-item">
				<button class="btn-success" onclick='mapea("<?php echo $r["domicilio"],",".$r["localidad"]?>",<?php echo $r["geo_x"]?>,<?php echo $r["geo_y"]?>)'>Mapa</button>
				<li class="list-group-item">Tel&eacute;fonos <span><strong><?php echo $r["telefonos"]?></strong></span>&nbsp;
				Email <span><strong><?php echo $r["email"]?></strong></span></li>
			</ul>
		</section>
		<section>
			<h3>Poblaci&oacute;n Objetivo</h3>
		<li class="list-group-item">G&eacute;nero <span><strong><?php echo si($r["genero_poblacion"]==1,"Femenino",si($r["genero_poblacion"]==2,"Masculino","Ambos"))?></strong></span>&nbsp;
				Franja etaria de <span><strong><?php echo $r["etaria_desde"]?></strong></span>&nbsp;
				 a <span><strong><?php echo $r["etaria_hasta"]?> a&ntilde;os</strong></span>&nbsp;
                Especificaci&oacute;n <span><strong><?php echo $r["poblacion"]?></strong></span> </li>

                </section>
		<section>
			<h3>Otras Caracter&iacute;sticas</h3>
			<ul class="list-group">
				<li class="list-group-item">Modalidad de Atenci&oacute;n<span><strong><?php echo $r["moda"]?></strong></span>&nbsp;
				Plazas <span><strong><?php echo $r["plazas"]?></strong></span></li>
				<li class="list-group-item">Frecuencia Monitoreo<span><strong><?php echo frecuencia($r["frecuencia"])?></strong></span>&nbsp;
				&Uacute;ltimo Monitoreo<span><strong><?php echo ffec($r["ultimo_monitoreo"])?></strong></span>&nbsp:
				Responsable Monitoreo<span><strong><?php echo $r["uape"].", ".$r["unom"]?></strong></span></li>
				<li class="list-group-item">
				Unidad T&eacute;cnica Supervisi&oacute;n<span><strong><?php echo $r["u_t"]?></strong></span></li>
                                <li class="list-group-item">
				  Tr&aacute;mite Eximici&oacute;n Habilitaci&oacute;n<span><strong><?php echo $r["tramite_eximicion"]?></strong></span></li>

				</li>

			</ul>
                        

		</section>

     </main>
<script src="generales.js"></script>
<script>
function mapea(d,x,y){
naveganuevo("https://google.com/maps/search/"+d+"/@"+y+","+x);
}
</script>
</body>

<?php
exit;

function item_nocero($rotulo,$campo){
 if(!$campo>"0"){return "";};
 return "<li class='list-group-item'>".$rotulo."</li>";
}
function frecuencia($f){
 if($f==3) {return "Trimestral";};
 if($f==4) {return "Cuatrimestral";};
 if($f==6) {return "Semestral";};
 if($f==12) {return "Anual";};

 return ""; 
}
?>



           