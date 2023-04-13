<?php

define('TEMPLATES_URL',  __DIR__. '/templates');
define('FUNCIONES', __DIR__. 'funciones.php');

function incluirTemplate (string $nombre, bool $inicio = false){
    include TEMPLATES_URL . "/${nombre}.php";
}

function estadoAutenticado() : bool {
    session_start();

    if (!$_SESSION['login']){
        return header('Location: /');
    }
    return false;

}


function debug ($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}