<?php
foreach ($alertas as $key => $mesajes) :
    foreach ($mesajes as $mensaje) :
?>
<div class="alerta <?= $key ?>">
        <?= $mensaje ?>
</div>
<?php
    endforeach;
endforeach;
?>
