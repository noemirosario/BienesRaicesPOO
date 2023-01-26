<?php
    // importar conexion
    require 'includes/config/database.php';
    $db = conectarDB ();
        
    // auntenticar el usuario

    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        //* SANITIZAMOS, VALIDAMOS Y PASAMOS DATOS A POST. 
        $email = mysqli_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ;
        // var_dump($email);
        $password = mysqli_escape_string($db, $_POST['password']);

        if (!$email){
            $errores[] = "El email es obligatorio";
        } 
        
        if (!$password){
            $errores[] = "El password es obligatorio";
        }

        if (empty($errores)){
            // revisar si el usuaio existe
            $queryEmail = "Select * from usuarios where email  = '${email}'";
            $resultado = mysqli_query($db, $queryEmail);

            if ($resultado -> num_rows){
                // revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                
                //verificar si el pasword es correcto o no
                $auth = password_verify($password, $usuario['password']);
                
                if ($auth){
                    // el usuario esta autenticado
                    session_start();

                    //llenar el array de la sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    // sesion activa
                    $_SESSION['login'] = true;

                    header('Location: /admin');

                    
                } else {
                    $errores[] = "El password es incorrecto";
                }

            } else {
                $errores[] = "El usuario no existe";
            }
        }

    }

    require 'includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <header class="login__header">
        <h2>
            <svg class="icon">
                <use xlink:href="#icon-lock" />
            </svg>
            Iniciar sesión
        </h2>
    </header>

    

    <div class="login">
        <form  class="login__form" method="POST" novalidate>
            <div>
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="correo@correo.com" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Tu password" required>
            </div>

            <div>
                <input class="button" type="submit" value="Iniciar sesión">
            </div>
        </form>
    </div>

    <?php
        foreach ($errores as $error ): ;
    ?>
        <div class="alerta error">
            <?php
                echo $error  ;
            ?>
        </div>
    <?php
        endforeach;
    ?>

    <svg xmlns="http://www.w3.org/2000/svg" class="icons">
        <symbol   symbol id="icon-lock" viewBox="0 0 448 512">
            <path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z" />
        </symbol>
    </svg>

    <!-- <form class="formulario" action="">
    <fieldset>
                <legend>Email y Password</legend>

                <label for="email">Email</label>
                <input type="email" placeholder="Tu email" id="email">

                <label for="password">Password</label>
                <input type="password" placeholder="Tu Password" id="password">

            </fieldset>
    </form> -->
</main>

<?php
    incluirTemplate('footer');
?>
