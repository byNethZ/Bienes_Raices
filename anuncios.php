<?php 

require 'includes/app.php';

incluirTemplate('header', $inicio = false);

?>

<main class="contenedor seccion">
    <h2>Casas y Departamentos en Venta</h2>
    
    <?php
        $limite = 10;
        include 'includes/templates/anuncios.php';
    ?>

</main>

    <?php incluirTemplate('footer'); ?>