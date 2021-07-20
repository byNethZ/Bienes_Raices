<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');
define('CARPETA_PERFILES', __DIR__ . '/../perfiles/');

function incluirTemplate(string $nombre, bool $inicio = false){
    include TEMPLATES_URL . "/${nombre}.php";
}

function authenticado () {
    session_start();

    if (!$_SESSION['login']){
        header('Location: /');
    }
}

function debug($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//Escape sanitizado HTML. funcion 's' significa sanitizar
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Validar tipo de contenido

function validarTipoContenido($tipo){
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

function mostrarMensajes($codigo){
    $mensaje = '';

    switch($codigo){
        case 1: $mensaje = 'Creado correctamente';
        break;
        case 2: $mensaje = 'Actualizado correctamente';
        break;
        case 3: $mensaje = 'Eliminado correctamente';
        break;
        default: $mensaje = false;
        break;
    }

    return $mensaje;
}