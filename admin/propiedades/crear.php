<?php
    require '../../includes/app.php';
    $auth = estadoAutenticado();
    use App\Propiedad;

    // $propiedad = new Propiedad;

    // debug($propiedad);
    estadoAutenticado();

    // base de datos
    $db = conectarDB ();

    // consulta para obtener los vendedores
    $queryVendedor = "select * from vendedores";
    $resultadoVendedor = mysqli_query($db, $queryVendedor);

    //array con mensaje de errores
    $errores = [];

    $nombre = '';
    $precio = '';
    $imagen= '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $idVendedor = '';

    // ejectuta el codigo despues de que el usuario envia el fromulario
    if($_SERVER["REQUEST_METHOD"] === 'POST'){

        $propiedad = new Propiedad($_POST);
        $propiedad -> guardar();

        // debug($propiedad);


        $nombre = mysqli_real_escape_string( $db, $_POST['nombre'] );
        $precio =  mysqli_real_escape_string($db,  $_POST['precio']);
        $descripcion =  mysqli_real_escape_string($db,  $_POST['descripcion']);
        $habitaciones =  mysqli_real_escape_string($db,  $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db,  $_POST['wc']);
        $estacionamiento =  mysqli_real_escape_string($db,  $_POST['estacionamiento']);
        $idVendedor =  mysqli_real_escape_string($db,  $_POST['vendedor']);
        $creado = date('Y/m/d');

        // asignar files hacia una variable 
        $imagen = $_FILES['imagen'];

        echo "<pre>";
        var_dump($imagen);        
        echo "</pre>";
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

        if (!$imagen['name'] || $imagen['error']){
            $errores[] = 'La imagen es obligatoria';
        }

        // validar por tamaño (1mb maximo)
        $medida = 1000 * 1000;

        if ($imagen['size'] > $medida){
            $errores[] = 'La imagen es muy pesada';        
        }


        // echo "<pre>";
        // var_dump(($errores));
        // echo "</pre>";

        // revisa si el array esta vacio
        if (empty($errores)){

            // subida de archivos
            // crear carpeta

            $carpetaImagenes = '../../imagenes/';
            if (!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            //Define la extensión para el archivo
            if ($imagen['type'] === 'image/jpeg') {
                $exten = '.jpg';
            } else{
                $exten = '.png';
            }

            // generar nombre unico
            $nombreImagen = md5(uniqid( rand(), true )) . $exten  ;

            // subir la imagen al servidor
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );

            

            // echo $query;
    
            $resultado = mysqli_query($db, $query);
            if ($resultado){
                // Redireccionar al usuario.
                header('Location: /admin?resultado=1');
            }
    
        } 

        // para probar la consulta
        // echo $query;
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion"> 
    <h2>Crear</h2>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach ?>

    

    <a href="/admin" class="boton btn-verde-inline">Volver</a>

    <form method="POST" action="/admin/propiedades/crear.php" class="formulario" enctype="multipart/form-data">
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

        <select name="idVendedor" id="nombre_vendedor">
            <option value="">--Seleccione</option>
            <?php while($row = mysqli_fetch_assoc($resultadoVendedor)) : ?>
            <option 
                <?php 
                // mantener seleccionado una opcion
                echo $vendedor === $row['idVendedor'] ? 'selected' : '';
                ?> value="<?php echo $row['idVendedor']  ?>">
                <?php 
                echo 
                    $row['nombre'] 
                    . " ". 
                    $row['apellidoPaterno']
                    . " ". 
                    $row['apellidoMaterno'];
                ?>
            </option>

            <?php endwhile;?>
            <!-- <option value="1">Noemi</option>
            <option value="2">Angela</option> -->
        </select>
    </fieldset>

    <input type="submit" value="Crear propiedad" class="btn-verde-block" >


    </form>
</main>

<?php
incluirTemplate('footer');
?>

