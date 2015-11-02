<?php
require './clases/AutoCarga.php';
$sesion = new Session();
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
        <title>Reproductor Personal</title>
    </head>
    <body>
        <div id="contendor">
        <?php
            if(!$sesion->isLogged()){
        ?>
        <div class="formulario">
            <form action="phplogin.php" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Usuario </legend>
                    <label for="usuario">Usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="text" name="usuario" id="usuario"
                           placeholder="Introduce el nombre de usuario" />
                    <br>
                    <label for="pass">Contraseña</label>
                    <input type="password" name="pass" id="pass" />
                    <input type="submit" value="Enviar"/>
                </fieldset>
            </form>
            <?php
            }else{
            ?>
            <a href="phplogin.php">Login</a>
            <?php
            }
            ?>
        </div>
    </div>
    </body>
</html>
