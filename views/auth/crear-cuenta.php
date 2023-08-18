<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Ingresa los siguiente datos para crear una cuenta</p>
<?php
include_once __DIR__ . "/../templates/alertas.php"
?>
<form action="/create-account" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?= s($usuario->nombre) ?>" placeholder="Tu Nombre">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" value="<?= s($usuario->apellido) ?>" placeholder="Tu Apellido">
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" name="telefono" id="telefono" value="<?= s($usuario->telefono) ?>" placeholder="Tu Telefono">
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= s($usuario->email) ?>" placeholder="Tu Email">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu Password">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">
</form>

<div class="acciones">
    <p>¿Ya tienes una cuenta? <a href="/">Haz click aqui para iniciar sesion</a></p>
    <p>¿Olvidaste tu contraseña? <a href="/forgot">Haz click aqui</a></p>
</div>
