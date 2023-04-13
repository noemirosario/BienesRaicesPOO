<?php
// importar la conexion

require 'includes/app.php';
$db = conectarDB();
// crear un email y password
$email = "correo@correo.com";
$password = "1234";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// query para crear el usuario

$query= "INSERT INTO usuarios (email, password) values ('${email}', '${passwordHash}'); ";
// echo $query;
mysqli_query($db, $query);

// agregarlo a la base de datos

?>