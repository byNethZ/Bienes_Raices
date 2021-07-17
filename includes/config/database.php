<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', '', 'bienes_raices');

    if(!$db){
        echo 'Error de conexión al servidor';
        exit;
    }

    return $db;
}