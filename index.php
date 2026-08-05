<?php
include("Funciones.php");

session_start();
session_destroy();
session_start();

include("encabezado-index.php");
?>

<style>
body {
    min-height: 100vh;
    margin: 0;
    font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    background:
        linear-gradient(rgba(5,54,66,.72), rgba(6,95,110,.62)),
        url("imagenes/fondo-surnnya.jpg") center center / cover fixed;
    color:#17333a;
}
.portal-surnnya{
    min-height:calc(100vh - 20px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:30px 15px;
}
.login-card{
    width:100%;
    max-width:470px;
    background:rgba(255,255,255,.96);
    border-radius:18px;
    box-shadow:0 18px 45px rgba(0,45,55,.28);
    overflow:hidden;
}
.login-header{
    padding:32px;
    text-align:center;
    background:linear-gradient(135deg,#087f8c,#0a6675);
    color:#fff;
}
.login-logo{
    width:76px;height:76px;
    margin:0 auto 18px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(255,255,255,.17);
    border:2px solid rgba(255,255,255,.45);
    font-size:26px;
    font-weight:bold;
}
.login-body{padding:32px 38px;}
.login-message{text-align:center;margin-bottom:24px;color:#526a70;}
.form-group-surnnya{margin-bottom:20px;}
.form-group-surnnya label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}
.form-control-surnnya{
    width:100%;
    height:48px;
    box-sizing:border-box;
    padding:10px 14px;
    border:1px solid #b7cdd1;
    border-radius:9px;
    font-size:16px;
}
.form-control-surnnya:focus{
    outline:none;
    border-color:#078494;
    box-shadow:0 0 0 3px rgba(7,132,148,.15);
}
.btn-ingresar{
    width:100%;
    height:48px;
    border:none;
    border-radius:9px;
    background:linear-gradient(135deg,#078694,#076775);
    color:#fff;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
}
.password-area{text-align:center;margin-top:22px;}
.btn-olvido{
    background:none;
    border:none;
    color:#087988;
    cursor:pointer;
}
.login-footer{
    padding:16px;
    text-align:center;
    background:#f4fafb;
    border-top:1px solid #e0ecee;
    font-size:12px;
}
</style>

<script>
function olvido(){
    navega("envio_password");
    return false;
}
</script>

<main class="portal-surnnya">
<section class="login-card">
<header class="login-header">
<div class="login-logo">S</div>
<h1>SURNNYA</h1>
<p>Consejo de los Derechos de Niñas, Niños y Adolescentes</p>
</header>

<div class="login-body">

<div class="login-message">
Ingrese sus datos para acceder al sistema
</div>

<form method="post" action="validaingreso">

<div class="form-group-surnnya">
<label for="mail">Correo electrónico</label>
<input class="form-control-surnnya" type="email" maxlength="100" name="mail" id="mail" autofocus required>
</div>

<div class="form-group-surnnya">
<label for="password">Contraseña</label>
<input class="form-control-surnnya" type="password" maxlength="45" name="password" id="password" required>
</div>

<button class="btn-ingresar" type="submit">Ingresar</button>

</form>

<div class="password-area">
<button class="btn-olvido" type="button" onclick="olvido()">No recuerdo mi contraseña</button>
</div>

</div>

<footer class="login-footer">
Sistema Único de Registro de Niñas, Niños y Adolescentes
</footer>

</section>
</main>

<?php include("footer.php"); ?>

</body>
</html>
