<h1 class="nombre-pagina">Reestablecer password</h1>
<p class="descripcion-pagina">Ingresa un nuevo password a continuacion</p>
<?php
include_once __DIR__ . "/../templates/alertas.php";
if($error) return;
?>
<form class="formulario" method="post">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu nuevo password">
    </div>

    <input type="submit" class="boton" value="Reestablecer password">
</form>

<div class="acciones">
    <p>¿Ya tienes una cuenta? <a href="/">Haz click aqui para iniciar sesion</a></p>
    <p>¿Aún no tienes una cuenta? <a href="/create-account">Crea una aqui</a></p> 
</div>
