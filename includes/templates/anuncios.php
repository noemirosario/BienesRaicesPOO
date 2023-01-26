<?php
    // importar la bd
    require __DIR__ . '/../config/database.php';
    $db = conectarDB();

    $limite = 10;
    
    //consultar
    $querySelect = "select * from propiedades LIMIT ${limite}";

    // obtener resultados
    $resultadoSelect = mysqli_query($db, $querySelect);
    
?>

<div class="contenedor-anuncios">
    <?php 
    while ($propiedad = mysqli_fetch_assoc($resultadoSelect)) :
    ?>

    <div class="anuncio">
        <picture>
            <!-- <source srcset="build/img/anuncio1.webp" type="image/webp">
            <source srcset="build/img/anuncio1.jpg" type="image/jpg"> -->
            <img class="img-anuncio" loading="lazy" src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="anuncio">
        </picture>

        <div class="contenido-anuncio">
            <h3>
                <?php echo $propiedad['nombre']; ?>
            </h3>
            <p>
                <?php echo $propiedad['descripcion']; ?>
            </p>
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
                </li>

                <li>
                    <img src="build/img/icono_dormitorio.svg" alt="icono_dormitorio">
                    <p>
                        <?php echo $propiedad['habitaciones']; ?>
                    </p>
                </li>
            </ul>

            <a href="anuncio.php?id=<?php echo $propiedad['idPropiedad']; ?>" class="btn-amarillo-block">
                Ver propiedad
            </a>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php
    // cerrar conexion
    mysqli_close($db);
?>

