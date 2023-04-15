<?php
    require '../../includes/app.php';
    $auth = estadoAutenticado();
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    // $propiedad = new Propiedad;

    // debug($propiedad);
    estadoAutenticado();

    // base de datos
    $db = conectarDB ();

    // consulta para obtener los vendedores
    $queryVendedor = "select * from vendedores";
    $resultadoVendedor = mysqli_query($db, $queryVendedor);

    //array con mensaje de errores
    $errores = Propiedad::getErrores();

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
        // se crea nueva instancia 
        $propiedad = new Propiedad($_POST);

        //Define la extensión para el archivo
        if ($imagen['type'] === 'image/jpeg') {
            $exten = '.jpg';
        } else{
            $exten = '.png';
        }

        // generar nombre unico
        $nombreImagen = md5(uniqid( rand(), true )) . $exten;

        // setear la img
        // realia un resize a la img  con invertation
        if ($_FILES['imagen']['tmp_name']){
            $imagen = Image::make($_FILES['imagen']['tmp_name']) -> fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

        $errores= $propiedad -> validar();
        // debug($propiedad);

        // revisa si el array esta vacio
        if (empty($errores)){

            // subida de archivos
            // crear carpeta
            if (!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }
            //save img server
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);

            // GUARDAR EN LA BD
            $resultado = $propiedad -> guardar();


            if ($resultado){
                // Redireccionar al usuario.
                header('Location: /admin?resultado=1');
            }
        } 
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

