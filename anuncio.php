<?php 

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /');
    }

    //importar bd
    require 'includes/config/database.php';
    $db = conectarDB();

    //consultar bd
    $consulta = "SELECT * FROM propiedades WHERE id = ${id}";
    $resultado = mysqli_query($db, $consulta);

    if(!$resultado->num_rows){
        header('Location: /');
    }

    //obtener resultado de bd
    $propiedad = mysqli_fetch_assoc($resultado);


    require 'includes/funciones.php';

    incluirTemplate('header', $inicio = false);

?>

<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad['titulo'] ?></h1>

    <picture>
        <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen'] ?>" alt="imagen de la propiedad">
    </picture>

    <div class="resumen-propiedad">
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

        <p><?php echo $propiedad['descripcion'] ?></p>
    </div>
</main>

<?php

    mysqli_close($db);

    incluirTemplate('footer'); 

?>