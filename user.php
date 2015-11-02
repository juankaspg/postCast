<?php
require '../clases/AutoCarga.php';
$sesion = new Session();
$user = $sesion->getUser();
if ($user == null) {
    $sesion->sendRedirect("login.php");
}
if (is_dir("repositorio/usuarios")) {
    $listaUsers = scandir("repositorio/usuarios");
} else {
    $listaUsers = null;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
        <title>Usuario Principal</title>
    </head>
    <body>
        <div id="contendor">
            <div class="formulario">
                <h2>Bienvenido <?php echo $user ?></h2>

                <form action="subir.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Formulario para la subidad de archivos</legend>

                        <label>Tipo de archivo</label>
                        <br>
                        <label for="publico">Publico</label>
                        <input type="radio" id="publico" name="tipo" value="publico"
                               checked="checked"/>
                        <label for="privado">Privado</label>
                        <input type="radio" id="privado" name="tipo" value="privado"/>
                        <br>
                        <label>Categoria</label>
                        <br>
                        <label for="rock">Rock</label>
                        <input type="radio" id="rock" name="categoria" value="rock"
                               checked="checked"/>
                        <label for="pop">Pop</label>
                        <input type="radio" id="pop" name="categoria" value="pop"/>
                        <label for="metal">Metal</label>
                        <input type="radio" id="metal" name="categoria" value="metal"/>
                        <br>
                        <input type="file" name="archivos[]" multiple />
                        <input type="submit" value="Enviar"/>
                    </fieldset>
                    
                </form>
                <br>
                <form action="listaReproduccion.php" method="post" enctype="multipart/form-data">
                    <fieldset  class="izquierda">
                        <legend>Formulario reproducción de archivos</legend>
                        <label for="usuario">Ver la lista de usuario de  </label>
                        <input type="text" name="usuario" id="usuario"
                               placeholder="Introduce el nombre de usuario" />
                        <input type="submit" value="Enviar"/>
                    </fieldset>
                    <fieldset class="derecha">
                        <legend>Lista de Usuarios</legend>
                        <select size="4">
                            <?php
                            for ($index = 2; $index < count($listaUsers); $index++) {
                                echo '<option value ="'.$listaUsers[$index].'">'.$listaUsers[$index].'</option>';
                            }
                            ?>
                        </select>
                    </fieldset>
                </form>
                <form action="phplogout.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <label for="usuario">Cerrar Sesion</label>
                        <input type="submit" value="Cerrar Sesión"/>
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>
