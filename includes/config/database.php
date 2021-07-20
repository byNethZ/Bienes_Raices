<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '', 'bienes_raices');

    if(!$db){
        echo 'Error de conexión al servidor';
        exit;
    }

    return $db;
}