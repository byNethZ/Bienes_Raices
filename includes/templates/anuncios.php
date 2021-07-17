<?php
    //importar bd
    require __DIR__ .  '/../config/database.php';
    $db = conectarDB();

    //consultar bd
    $query = "SELECT * FROM propiedades LIMIT ${limite}";

    //obtener resultado de bd
    $resultado = mysqli_query($db, $query);

?>

<div class="contenedor-anuncios">
    <?php while($propiedad = mysqli_fetch_assoc($resultado)): ?>
    <div class="anuncio">
        <picture>
            <img loading ="lazy" src="imagenes/<?php echo $propiedad['imagen'] ?>" alt="anuncio">
        </picture>
        <div class="contenido-anuncio">
            <h3><?php echo $propiedad['titulo'] ?></h3>
            <p><?php echo $propiedad['descripcion'] ?></p>
            <p class="precio">$<?php echo $propiedad['precio'] ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc'] ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento'] ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                    <p><?php echo $propiedad['habitaciones'] ?></p>
                </li>
            </ul>
            <a href="anuncio.php?id=<?php echo $propiedad['id'] ?>" class="boton-amarillo-block">
                Ver propiedad
            </a>
        </div><!-- Contenido Anuncio -->
    </div><!-- Anuncio -->
    <?php endwhile; ?>
</div><!-- Contenedor Anuncios -->


<?php
    //cerrar conexion
        mysqli_close($db);
?>