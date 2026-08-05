<?php
/*
 * Menú de consulta de sujetos compatible con Bootstrap 4.
 * Mantiene la lógica original y muestra los ítems en una sola línea.
 *
 * Requisitos:
 * - Bootstrap 4 cargado en la página.
 * - Variables disponibles: $_SESSION y $lega.
 * - Funciones disponibles: un_campo() y un_registro().
 */

$posicion = isset($_SESSION["posicion"]) ? (string) $_SESSION["posicion"] : "";
$perfil   = isset($_SESSION["glidperfil"]) ? (string) $_SESSION["glidperfil"] : "";

/**
 * Devuelve las clases correspondientes para cada opción del menú.
 */
function claseMenu($numero, $posicion)
{
    return ((string) $numero === (string) $posicion)
        ? 'nav-item active nav-item-active'
        : 'nav-item';
}
?>

<style>
/* Mantiene todos los elementos del menú en una sola línea. */
.navbar-sujetos {
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
}

.navbar-sujetos .navbar-nav {
    flex-direction: row;
    flex-wrap: nowrap;
}

.navbar-sujetos .nav-item {
    white-space: nowrap;
}

/* Clase personalizada conservada del código original. */
.navbar-sujetos .nav-item-active > .nav-link,
.navbar-sujetos .nav-item.active > .nav-link {
    font-weight: 600;
}
</style>

<nav class="navbar navbar-expand navbar-light bg-light navbar-sujetos">

    <a class="navbar-brand" href="consultasujetos">
        B&uacute;squeda
    </a>

    <div class="navbar-collapse">
        <ul class="navbar-nav flex-row flex-nowrap">

            <li class="<?php echo claseMenu(1, $posicion); ?>">
                <a class="nav-link" href="suje_cons_duros?legajo=<?php echo urlencode($lega); ?>">
                    Principal
                </a>
            </li>

            <li class="<?php echo claseMenu(2, $posicion); ?>">
                <a class="nav-link" href="suje_cons_alojamiento?legajo=<?php echo urlencode($lega); ?>">
                    Alojamiento
                </a>
            </li>

            <li class="<?php echo claseMenu(3, $posicion); ?>">
                <a class="nav-link" href="suje_cons_familiaescuela?legajo=<?php echo urlencode($lega); ?>">
                    Familia/Escolaridad
                </a>
            </li>

            <li class="<?php echo claseMenu(4, $posicion); ?>">
                <a class="nav-link" href="suje_cons_juridicos?legajo=<?php echo urlencode($lega); ?>">
                    Jur&iacute;dicos
                </a>
            </li>

            <li class="<?php echo claseMenu(5, $posicion); ?>">
                <a class="nav-link" href="suje_cons_archivos?legajo=<?php echo urlencode($lega); ?>">
                    Archivos
                </a>
            </li>

            <li class="<?php echo claseMenu(6, $posicion); ?>">
                <a class="nav-link" href="suje_cons_trimestrales?legajo=<?php echo urlencode($lega); ?>">
                    Trimestrales
                </a>
            </li>

            <li class="<?php echo claseMenu(7, $posicion); ?>">
                <a class="nav-link" href="suje_cons_salud?legajo=<?php echo urlencode($lega); ?>">
                    Salud
                </a>
            </li>

            <li class="<?php echo claseMenu(8, $posicion); ?>">
                <a class="nav-link" href="suje_cons_vivienda?legajo=<?php echo urlencode($lega); ?>">
                    Vivienda
                </a>
            </li>

            <li class="<?php echo claseMenu(10, $posicion); ?>">
                <a class="nav-link" href="suje_otros?legajo=<?php echo urlencode($lega); ?>">
                    Otros
                </a>
            </li>

            <?php if ($perfil === "47") { ?>
                <li class="<?php echo claseMenu(11, $posicion); ?>">
                    <a class="nav-link" href="suje_cons_pae?legajo=<?php echo urlencode($lega); ?>">
                        Datos PAE
                    </a>
                </li>
            <?php } ?>

            <?php
            $datosSujeto = un_campo(
                "select concat(apellidos,', ',nombres,' ',legajo) as cosa
                 from sujetos
                 where legajo=" . (int) $lega
            );
            ?>

            <li class="nav-item nav-item-active">
                <a class="nav-link" href="#">
                    <?php echo htmlspecialchars($datosSujeto, ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </li>

            <?php
            $grup = un_registro(
                "select *
                 from grupos
                 left join grupos_legajos on idgrupos=grupo
                 where grupo_legajo=" . (int) $lega
            );

            if (!is_null($grup)) {
            ?>
                <li class="nav-item nav-item-active">
                    <a class="nav-link" href="grupos2?id=<?php echo urlencode($grup["idgrupos"]); ?>">
                        Grupo de hermanos
                    </a>
                </li>
            <?php } ?>

            <?php
            $fami = un_registro(
                "select *
                 from fv_familias_miembros
                 left join fv_familias on familia=idfv_familias
                 where legajo=" . (int) $lega
            );

            if (!is_null($fami)) {
            ?>
                <li class="nav-item nav-item-active">
                    <a class="nav-link" href="#">
                        Grupo familiar
                        <?php echo htmlspecialchars($fami["descripcion"], ENT_QUOTES, 'UTF-8'); ?>
                        Legajo
                        <?php echo htmlspecialchars($fami["legajomanual"], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
            <?php } ?>

        </ul>
    </div>
</nav>
