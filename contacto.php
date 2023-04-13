<?php
    require 'includes/app.php';
    
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h2>Contacto</h2>
        <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpg" type="image/webjpg">
            <img src="build/img/destacada.jpg" alt="destacada">
        </picture>

        <h2>Llene el formulario de Contacto</h2>

        <form action="" class="formulario">
            <fieldset>
                <legend>Información Personal</legend>

                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Tu nombre" id="nombre">

                <label for="email">Email</label>
                <input type="email" placeholder="Tu email" id="email">

                <label for="telefono">Teléfono</label>
                <input type="tel" placeholder="Tu Teléfono" id="telefono">

                <label for="mensaje:">Mensaje</label>
                <textarea name="" id="mensaje" cols="30" rows="10"></textarea>
            </fieldset>

            <fieldset>
                <legend>Información sobre la propiedad</legend>
                <label for="opciones">Vende o Compra</label>
                <select name="" id="opciones">
                    <option value="" disabled="" selected="">-- Seleccione --</option>
                    <option value="Compra">Compra</option>
                    <option value="Vende">Vende</option>
                </select>

                <label for="precio">Precio o Presupuesto</label>
                <input type="number" placeholder="Tu Precio o Presupuesto" id="precio">
            </fieldset>

            <fieldset>
                <legend>Información sobre la propiedad</legend>
                <p>Como desea ser contactado</p>
                <div class="forma-contacto">
                    <label for="contactar-telefono">
                        Telefono
                    </label>
                    <input type="radio" value="Telefono" name="contacto" id="contactar-telefono">

                    <label for="contactar-email">
                        E-mail
                    </label>
                    <input type="radio" value="E-mail" name="contacto" id="contactar-email">
                </div>

                <p>Si eligió teléfono, elija la fecha y la hora</p>

                <label for="fecha">Fecha</label>
                <input type="date" id="fecha">

                <label for="hora">Hora</label>
                <input type="time" id="hora" min="09:00" max="18:00">
            </fieldset>

            <input type="submit" value="Enviar" class="btn-verde">
        </form>



    </main>
    
    <?php
    incluirTemplate('footer');
    ?>


    <script src="build\js\bundle.min.js"></script>
</body>
</html>