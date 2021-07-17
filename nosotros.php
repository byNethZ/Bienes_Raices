<?php 

require 'includes/funciones.php';

incluirTemplate('header', $inicio = false);

?>

    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="sobre Nosotros">
                </picture>
            </div>
            <div class="texto-nosotros">
                <blockquote>25 años de experiencia</blockquote>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium id magnam amet quas dolore accusamus eaque iusto. Nobis, distinctio. Quas doloremque neque quo modi repudiandae rem, asperiores dicta perspiciatis odit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium id magnam amet quas dolore accusamus eaque iusto. Nobis, distinctio. Quas doloremque neque quo modi repudiandae rem, asperiores dicta perspiciatis odit.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sequi aliquid cumque dicta ullam ratione voluptas tempora, voluptate voluptatem recusandae ducimus consectetur facere veniam error. Officia corporis consequuntur eligendi ex excepturi.</p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más sobre nosotros</h1>
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="icono Seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda a fugiat, aliquam debitis odio modi at non, qui rerum ducimus expedita itaque, pariatur magnam. Officiis voluptates beatae vel id vero.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="icono Precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda a fugiat, aliquam debitis odio modi at non, qui rerum ducimus expedita itaque, pariatur magnam. Officiis voluptates beatae vel id vero.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="icono Tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda a fugiat, aliquam debitis odio modi at non, qui rerum ducimus expedita itaque, pariatur magnam. Officiis voluptates beatae vel id vero.</p>
            </div>
        </div>
    </section>

    <?php incluirTemplate('footer'); ?>