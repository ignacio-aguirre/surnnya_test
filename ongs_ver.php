<?php
include("Funciones.php");
session_start();
$id=nget("id");
$r=un_registro("select hogares_ong.*, (select count(*) from dispositivos 
where baja is null and ong=hogares_ong.id) as cantidad, barrios_caba.barrio as dlocalidad,formas.deno as dtipo, estados.deno as destado from hogares_ong 
 left join tablas estados on estados.tipo='EONG' and estados.valo=estado
 left join tablas formas on formas.tipo='TENT' and formas.valo=tipo_entidad
 left join barrios_caba on idbarrios_caba=hogares_ong.barrio
 where hogares_ong.id=".$id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Ficha ONG</title>
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
		
		<h2 class="">Ficha de Datos ONG</h2>
	</header>
	<main>
		<section>
			<h3>Datos de Inscripci&oacute;n</h3>
			<ul class="list-group">
				<li class="list-group-item text-primary">Legajo <span><strong><?php echo $r["legajo"]?></strong></span>&nbsp;
				Raz&oacute;n Social<span><strong><?php echo $r["nombre"]?></strong></span></li>
				<li class="list-group-item">Personer&iacute;a Jur&iacute;dica - IGJ <span><strong><?php echo $r["igj"]?></strong></span>&nbsp;
				Forma Jur&iacute;dica<span><strong><?php echo $r["dtipo"]?></strong></span>&nbsp;
				CUIT<span><strong><?php echo $r["cuit"]?></strong></span></li>
				<li class="list-group-item">Resoluci&oacute;n Alta <span><strong><?php echo $r["resolucion_alta"]?></strong></span>&nbsp;
				Fecha<span><strong><?php echo ffec($r["fecha_alta"])?></strong></span></li>
				<li class="list-group-item">Referente Institucional <span><strong><?php echo $r["referente"]?></strong></span>&nbsp;
				Celular <span><strong><?php echo $r["celular_referente"]?></strong></span></li>
				<li class="list-group-item">Domicilio Legal<span><strong><?php echo $r["domicilio_legal"]." ".$r["piso_departamento"]?></strong></span>&nbsp;
				Localidad <span><strong><?php echo $r["localidad"]?></strong></span></li>
				<li class="list-group-item">Barrio <span><strong><?php echo $r["barrio"]?></strong></span>Comuna <span><strong><?php echo $r["comuna"]?></strong></span></li>
                                <li class="list-group-item">
				<button class="btn-success" onclick='mapea("<?php echo $r["domicilio_legal"],",".$r["localidad"]?>",<?php echo $r["geo_x"]?>,<?php echo $r["geo_y"]?>)'>Mapa</button>
                                <li class="list-group-item">
				
				<li class="list-group-item">Tel&eacute;fonos <span><strong><?php echo $r["telefonos"]?></strong></span>&nbsp;
				Email <span><strong><?php echo $r["email"]?></strong></span></li>


			</ul>
		</section>
		<section>
			<h3>Situaci&oacute;n Actual</h3>
			<ul class="list-group">
				<li class="list-group-item">Estado <span><strong><?php echo $r["destado"]?></strong></span>&nbsp;
				Convenia c/GCABA<span><strong><?php echo si($r["conveniada"]==1,"SI","NO")?></strong></span>
				Repartici&oacute;n<span><strong><?php echo $r["reparticion_convenio"]?></strong></span></li>
				<li class="list-group-item">Resoluci&oacute;n Baja <span><strong><?php echo $r["resolucion_baja"]?></strong></span>&nbsp;
				Fecha<span><strong><?php echo ffec($r["baja"])?></strong></span></li>
			</ul>
                        <h3>Areas</h3>
			<ul class="list-group">
                        <?php 
			echo item_nocero("Atenci&oacute;n Directa",$r["atencion_directa"]);
			echo item_nocero("Necesidades Especiales",$r["necesidades_especiales"]);
			echo item_nocero("Promoci&oacute;n",$r["promocion"]);
			echo item_nocero("Acad&eacute;micas / Investigaci&oacute;n",$r["academicas_investigacion"]);
			echo item_nocero("G&eacute;nero",$r["genero"]);
                        echo item_nocero("&Aacute;rea Plenario: ".un_campo("select deno from tablas where tipo='AONG' and valo=".$r["area_plenario"]),$r["area_plenario"]);
			?>
			</ul>
			<h3>Dispositivos</h3>
			<ul class="list-group">
			<?php
			  $dis=registros("select nombre,deno from dispositivos left join tablas on tipo='DITIP' and valo=tipo_dispositivo where dispositivos.baja is null and ong=".$id." order by nombre");
			  while($d=mysqli_fetch_assoc($dis)){
			   echo item_nocero($d["nombre"]." ".$d["deno"],1);
			  };
			?>	
				
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
?>



           