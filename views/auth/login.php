<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>
<?php
include_once __DIR__ . "/../templates/alertas.php"
?>
<form action="/" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu Email" value="<?= s($usuario->email) ?>">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu Password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <p>¿Aún no tienes una cuenta? <a href="/create-account">Crea una aqui</a></p> 
    <p>¿Olvidaste tu contraseña? <a href="/forgot">Haz click aqui</a></p>
</div>