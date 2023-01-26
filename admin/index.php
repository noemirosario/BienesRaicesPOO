<?php
    require '../includes/funciones.php';
    $auth = estadoAutenticado();

    if (!$auth){
        header('Location: /');
    }

    // importar conexion
    require '../includes/config/database.php';
    $db = conectarDB ();

    // escribir el query
    $querySelect = "select * from propiedades";

    // consultar la bd
    $resultadoSelect = mysqli_query($db, $querySelect);

    // muestra msj condicional
    $resultado = $_GET['resultado'] ?? null;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT) ;

        if ($id){
            // eliminar el archivo

            $queryDelete = "SELECT imagen from propiedades WHERE idPropiedad = ${id}";
            $resultadoDelete = mysqli_query($db, $queryDelete);
            $propiedad = mysqli_fetch_assoc($resultadoDelete);

            unlink('../imagenes/' . $propiedad['imagen']);

            // eliminar propiedad
            $queryDelete = "DELETE from propiedades WHERE idPropiedad = ${id}";
            $resultadoDelete = mysqli_query($db, $queryDelete);

            if ($resultadoDelete){
                header('Location: /admin?resultado=3');
            }
        }
        // var_dump($id);
    }

    // incluye un template
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h2>Administrador de bienes y raices</h2>
    
    <?php if (intval($resultado)  === 1) : ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    
    <?php elseif (intval($resultado)  === 2) : ?>
        <p class="alerta exito">Anuncio actualizado correctamente</p>

    <?php elseif (intval($resultado)  === 3) : ?>
    <p class="alerta exito">Anuncio eliminado correctamente</p>

    <?php endif; ?>

    <a href="/admin/propiedades/crear.php" class="boton btn-verde-inline">Nueva Propiedad</a>

    <table class="propiedades"  >
    <!-- border="1" rules=all -->
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>IMAGEN</th>
                <th>PRECIO</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody> <!-- mostrar los resultados -->
        <!-- sirve para recorrer los resultados de la bd -->
        <?php 
            while ($propiedad = mysqli_fetch_assoc($resultadoSelect)) :
        ?>
            <tr>
                <td>
                    <?php echo $propiedad['idPropiedad']; ?>
                </td>
                <td>
                    <?php echo $propiedad['nombre']; ?>
                <td>
                    <img class="imagen-tabla" src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="">
                </td>
                <td>
                    $ <?php echo $propiedad['precio']; ?>
                </td>
                <td>
                    <form method="POST" class="w-100" action="">
                        <input type="hidden" name="id" value="<?php echo $propiedad['idPropiedad']; ?>">
                        <input type="submit" class="btn-rojo-block" value="Eliminar">
                    </form>
                    
                    <a class="btn-amarillo-block" href="../admin/propiedades/actualizar.php?id=<?php echo $propiedad['idPropiedad'] ; ?>">Actualizar</a>
                </td>
            </tr>

            <?php endwhile; ?>
        </tbody>

    </table>
</main>

<?php

    // cerrar la conexion
    mysqli_close($db);

    incluirTemplate('footer');
?>
