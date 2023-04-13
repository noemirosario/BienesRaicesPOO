<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

//conectarnos a la bd
$db = conectarDB();

use App\Propiedad;

Propiedad::setDB($db);

// $propiedad = new Propiedad;

// var_dump($propiedad);