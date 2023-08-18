<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu email a continuacion</p>
<?php
include_once __DIR__ . "/../templates/alertas.php"
?>
<form action="/forgot" method="POST" class="formulario">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu Email">
    </div>

    <input type="submit" class="boton" value="Reestablecer Password">
</form>

<div class="acciones">
    <p>¿Ya tienes una cuenta? <a href="/">Haz click aqui para iniciar sesion</a></p>
    <p>¿Aún no tienes una cuenta? <a href="/create-account">Crea una aqui</a></p> 
</div>