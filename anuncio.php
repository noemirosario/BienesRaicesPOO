<?php

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    
    if (!$id){
        header('Location: /');
    }

    require 'includes/app.php';

    // importar la bd
    $db = conectarDB();

    //consultar
    $querySelect = "select * from propiedades where idPropiedad = ${id}";

    // obtener resultados
    $resultadoSelect = mysqli_query($db, $querySelect);

    // valida que la url tengta un id que exista sino lo redirecciona a la pag principal
    if (!$resultadoSelect -> num_rows){
        header('Location: /');
    }
    $propiedad = mysqli_fetch_assoc($resultadoSelect);

    incluirTemplate('header');

?>

<main class="contenedor seccion contenido-centrado">
    <h2>
        <?php echo $propiedad['nombre']; ?>
    </h2>

    <img loading="lazy"src="/imagenes/<?php echo $propiedad['imagen']?>" alt="destacada">
    
    <div class="resumen-propiedad">
        <p class="precio">
            $ <?php echo number_format($propiedad['precio']); ?>
        </p>
        <ul class="iconos-caracteristicas">
            <li>
                <img src="build/img/icono_wc.svg" alt="icono wc">
                <p>
                    <?php echo $propiedad['wc']; ?>
                </p>
            </li>

            <li>
                <img src="build/img/icono_estacionamiento.svg" alt=" icono_estacionamiento">
                <p>
                    <?php echo $propiedad['estacionamiento']; ?>
                </p>
            </li>

            <li>
                <img src="build/img/icono_dormitorio.svg" alt="icono_dormitorio">
                <p>
                    <?php echo $propiedad['habitaciones']; ?>
                </p>
            </li>
        </ul>
        <p>
            <?php echo $propiedad['descripcion']; ?>
        </p>
    </div>
</main>


    <script src="build\js\bundle.min.js"></script>

</body>

</html>


<?php
    mysqli_close($db);
    incluirTemplate('footer');
?>
