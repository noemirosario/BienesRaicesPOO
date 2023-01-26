<?php
    require '../../includes/funciones.php';
    $auth = estadoAutenticado();

    if (!$auth){
        header('Location: /');
    }

    // validar que sea un id valido en la URL
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id){
        header('Location: /admin');
    }

    // base de datos
    require '../../includes/config/database.php';
    $db = conectarDB ();

    // consulta para obtener los datos de la propiedad
    $queryPropiedad = "select * from propiedades where idPropiedad = ${id}";
    // echo $queryPropiedad;
    $resultadoPropiedad = mysqli_query($db, $queryPropiedad);
    $propiedad = mysqli_fetch_assoc($resultadoPropiedad);

    // var_dump($propiedad);

    // consulta para obtener los vendedores
    $queryVendedor = "select * from vendedores";
    $resultadoVendedor = mysqli_query($db, $queryVendedor);

    //array con mensaje de errores
    $errores = [];

    $nombre = $propiedad['nombre'];
    $precio = $propiedad['precio'];
    $imagen= $propiedad['imagen'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $idVendedor = $propiedad['idVendedor'];

    // ejectuta el codigo despues de que el usuario envia el fromulario
    if($_SERVER["REQUEST_METHOD"] === 'POST'){
        // MUESTRA EL ARRAY
        // echo "<pre>";
        // var_dump(($_POST));
        // echo "</pre>";

        // exit;

        // echo "<pre>";
        // var_dump(($_FILES));descripcion
        // echo "</pre>";

        // https://www.php.net/manual/es/filter.filters.sanitize.php

        $nombre = mysqli_real_escape_string( $db, $_POST['titulo'] );
        $precio =  mysqli_real_escape_string($db,  $_POST['precio']);
        $descripcion =  mysqli_real_escape_string($db,  $_POST['descripcion']);
        $habitaciones =  mysqli_real_escape_string($db,  $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db,  $_POST['wc']);
        $estacionamiento =  mysqli_real_escape_string($db,  $_POST['estacionamiento']);
        $idVendedor =  mysqli_real_escape_string($db,  $_POST['vendedor']);
        $creado = date('Y/m/d');

        // asignar files hacia una variable 
        $imagen = $_FILES['imagen'];

        // echo "<pre>";
        // var_dump($imagen);        
        // echo "</pre>";

        // exit;


        if (!$nombre){
            $errores[] = "Debes añadir un titulo";
        }
        if (!$precio){
            $errores[] = "precio obligatorio";
        }
        if ( strlen($descripcion) < 50){
            $errores[] = "la descripcion debe de ser de 50 caracteres";
        }
        if (!$habitaciones){
            $errores[] = "numero de habitaciones obligatorio";
        }
        if (!$wc){
            $errores[] = "numero de wc obligatorio";
        }
        if (!$estacionamiento){
            $errores[] = "numero de estacionamiento obligatorio";
        }
        if (!$idVendedor){
            $errores[] = "vendedor obligatorio";
        }

        // validar por tamaño (1mb maximo)
        $medida = 1000 * 100;
        if ($imagen['size'] > $medida){
            $errores[] = 'La imagen es muy pesada';        
        }


        // echo "<pre>";
        // var_dump(($errores));
        // echo "</pre>";

        // revisa si el array esta vacio
        if (empty($errores)){

            // subida de archivos
            // var_dump($imagen);
            // exit;

            // crear carpeta
            $carpetaImagenes = '../../imagenes/';
            if (!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';

            // subida de imagen
            if ($imagen['name']){
                // eliminar imagen previa
                unlink($carpetaImagenes . $propiedad['imagen']);

                // // generar nombre unico
                $nombreImagen = md5(uniqid( rand(), true )) . $exten  ;

                // // subir la imagen al servidor
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
            } else {
                $nombreImagen = $propiedad['imagen'];
            }
            
            // //Define la extensión para el archivo
            if ($imagen['type'] === 'image/jpeg') {
                $exten = '.jpg';
            } else{
                $exten = '.png';
            }

            

            // insertar en la base de datos
            $query = " UPDATE propiedades set
                nombre = '${nombre}', 
                precio = '${precio}', 
                imagen = '${nombreImagen}',
                descripcion = '${descripcion}', 
                habitaciones = ${habitaciones}, 
                wc = ${wc}, 
                estacionamiento = ${estacionamiento}, 
                creado = '${creado}', 
                idVendedor = ${idVendedor}

                WHERE idPropiedad = $id";

            // echo $query;
            // exit;

            // echo $query;
    
            $resultado = mysqli_query($db, $query);
            if ($resultado){
                // Redireccionar al usuario.
                header('Location: /admin?resultado=2');
            }
    
        } 

        // para probar la consulta
        // echo $query;
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion"> 
    <h2>Actualizar Propiedad</h2>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach ?>

    

    <a href="/admin" class="boton btn-verde-inline">Volver</a>

    <form method="POST" class="formulario" enctype="multipart/form-data">
    <fieldset>
        <legend>Informacion general</legend>
        <label for="titulo">Titulo</label>
        <input 
            type="text" 
            name="titulo" 
            placeholder="Titulo propiedad" 
            id="titulo" value="<?php echo $nombre; ?>">

        <label for="precio">Precio</label>
        <input 
            type="number" 
            name="precio" 
            placeholder="Precio" 
            id="precio" value="<?php echo $precio; ?>">

        <label for="imagen">Imagen</label>
        <input 
            type="file" 
            id="imagen" 
            accept="image/jpeg, image/jpg"
            name="imagen">

        <img src="/imagenes/<?php echo $propiedad['imagen'] ?>" alt="imagen de la propiedad" class="imagen-small">

        <label for="descripcion">Descripcion</label>
        <textarea 
            name="descripcion" 
            id="descripcion"  >
            <?php echo $descripcion; ?>
        </textarea>
    </fieldset>

    <fieldset>
        <legend>Informacion de propiedad</legend>

        <label for="habitaciones">Habitaciones</label>
        <input 
            type="number" 
            id="habitaciones" 
            placeholder="Numero de habitaciones" 
            min="1" 
            name="habitaciones" 
            value="<?php echo $habitaciones; ?>">

        <label for="wc">baños</label>
        <input 
            type="number" 
            id="wc" 
            placeholder="Numero de baños" 
            min="1" 
            name="wc" 
            value="<?php echo $wc; ?>">

        <label for="estacionamiento">estacionamiento</label>
        <input 
            type="number" 
            id="estacionamiento" 
            placeholder="Numero de estacionamiento" 
            min="1" 
            name="estacionamiento" 
            value="<?php echo $estacionamiento; ?>">

    </fieldset>

    <fieldset>
        <legend>Vendedor</legend>

        <select name="vendedor" id="">
            <option value="">--Seleccione</option>
            <?php while($vendedor = mysqli_fetch_assoc($resultadoVendedor)) : ?>
            <option 
                <?php 
                // mantener seleccionado una opcion
                echo $idVendedor === $vendedor['idVendedor'] ? 'selected' : '';
                ?> value="<?php echo $vendedor['idVendedor']  ?>">
                <?php 
                echo 
                    $vendedor['nombre'] 
                    . " ". 
                    $vendedor['apellidoPaterno']
                    . " ". 
                    $vendedor['apellidoMaterno'];
                ?>
            </option>

            <?php endwhile;?>
            <!-- <option value="1">Noemi</option>
            <option value="2">Angela</option> -->
        </select>
    </fieldset>

    <input type="submit" value="Actualizar Propiedad" class="btn-verde-block" >


    </form>
</main>

<?php
incluirTemplate('footer');
?>
