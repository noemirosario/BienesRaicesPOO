<?php
    require 'includes/app.php';
    incluirTemplate('header', $inicio = true);
?>

    <main class="contenedor seccion">
        <h2>Más Sobre Nosotros</h2>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt, ipsum aliquid adipisci quod animi iste quas quo quia nostrum vero est et ipsa, molestiae facere consectetur autem totam quam nam.</p>
            </div>

            <div class="icono">
                <img src="build/img/icono2.svg" alt="icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt, ipsum aliquid adipisci quod animi iste quas quo quia nostrum vero est et ipsa, molestiae facere consectetur autem totam quam nam.</p>
            </div>

            <div class="icono">
                <img src="build/img/icono3.svg" alt="icono tiempo" loading="lazy">
                <h3>A tiempo</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt, ipsum aliquid adipisci quod animi iste quas quo quia nostrum vero est et ipsa, molestiae facere consectetur autem totam quam nam.</p>
            </div>
        </div>
    </main>

    <section class="seccion contenedor">
        <h2>Casas y Depas en Venta</h2>

        <?php 
            include 'includes/templates/anuncios.php';
        ?>

        <div class="alinear-derecha">
            <a href="anuncios.php" class="boton btn-verde">
                Ver todas
            </a>
        </div>
    </section>

    <section class="img-contacto">
            <h2>Encuentra la casa de tus sueños</h2>
            <p>Llena el formulario de contacto y un asesor se pondrá en contacto contigo a la brevedad</p>

            <a href="contacto.html" class="btn-amarillo-inline">
                Contactános
            </a>

    </section>

    <section class="contenedor seccion seccion-inferior">
        <div class="blog">
            <h2>Nuestro blog</h2>

            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog1.webp" type="image/webp"> 
                        <source srcset="build/img/blog1.jpg" type="image/jpg"> 
                        <img loading="lazy" src="build/img/blog1.jpg" alt="imagen del blog">
                    </picture>
                </div>

                <div class="texto-entrada">
                    <a href="entrada.html">
                        <h4>Terraza en el techo de tu casa</h4>
                        <p class="info-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span> </p>
                        <p>
                            Consejos para construir una terraza en el techo de tu casa con los mejores materiales y ahorrando dinero
                        </p>
                    </a>
                </div>

                



            </article>

            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog2.webp" type="image/webp"> 
                        <source srcset="build/img/blog2.jpg" type="image/jpg"> 
                        <img loading="lazy" src="build/img/blog2.jpg" alt="imagen del blog">
                    </picture>
                </div>

                <div class="texto-entrada">
                    <a href="entrada.html">
                        <h4>Guía para la decoración de tu hogar</h4>
                        <p class="info-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span> </p>
                        <p>
                            Maximiza el espacio en tu hogar con esta guia, aprende a combinar muebles y colores para darle vida a tu espacio
                        </p>
                    </a>
                </div>
            </article>
        </div>

        <section class="testimoniales">
            <h2>Testimoniales</h2>
            <div class="testimonial">
                <blockquote>
                    El personal se comportó de una excelente forma, muy buena atención y la casa que me ofrecieron cumple con todas mis expectativas. 
                </blockquote>
                <p>- Noemi Rosario</p>
            </div>
        </section>
    </section>

    <?php
        incluirTemplate('footer');
    ?>

    <script src="build\js\bundle.min.js"></script>
</body>
</html>