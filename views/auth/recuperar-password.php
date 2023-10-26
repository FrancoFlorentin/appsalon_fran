<h1 class="nombre-pagina">Reestablecer Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuacion</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<?php if (!$error) :?>
    <form class="formulario" method="POST">
        <div class="campo">
            <div>
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password"
                    name="password"
                    placeholder="Escribe tu nuevo password"
                >
            </div>
        </div>

        <input type="submit" class="boton" value="Guardar password">
    </form>
<?php endif;?>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">Aún no tienes una cuenta? Regístrate</a>
</div>