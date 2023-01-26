<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h2>Casas y Depas en Venta</h2>

        <?php
            // limite de mostar en la seccion
            $limite = 10;
            include 'includes/templates/anuncios.php'
        ?>
    </main>


    <?php
    incluirTemplate('footer');
    ?>

    <script src="build\js\bundle.min.js"></script>
</body>
