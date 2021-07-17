<?php 

require 'includes/funciones.php';

incluirTemplate('header', $inicio = false);

?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Guía para la decoración de tu hogar</h1>

        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada2.jpg" alt="imagen de la propiedad">
        </picture>

        <p class="informacion-meta">Escrito el <span>20/10/2021</span> por <span>Admin</span></p>

        <div class="resume-propiedad">


            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, ipsa animi? Laborum quos asperiores sit aperiam nobis saepe, sint dolor iste possimus! Totam illum minus commodi deleniti consequuntur doloribus ab.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium id magnam amet quas dolore accusamus eaque iusto. Nobis, distinctio. Quas doloremque neque quo modi repudiandae rem, asperiores dicta perspiciatis odit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium id magnam amet quas dolore accusamus eaque iusto. Nobis, distinctio. Quas doloremque neque quo modi repudiandae rem, asperiores dicta perspiciatis odit.</p>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sequi aliquid cumque dicta ullam ratione voluptas tempora, voluptate voluptatem recusandae ducimus consectetur facere veniam error. Officia corporis consequuntur eligendi ex excepturi.</p>
        </div>
    </main>

    <?php incluirTemplate('footer'); ?>