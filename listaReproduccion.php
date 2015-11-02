<?php
require '../clases/AutoCarga.php';
$sesion = new Session();

$user = $sesion->getUser();
if ($user == null) {
    $sesion->sendRedirect("login.php");
}
$usuarioAnfitrion = $user->getNombre();
if (Request::post("usuario") == "") {
    $usuarioReproductor = Request::get("usuario");
} else {
    $usuarioReproductor = Request::post("usuario");
}
//Si no tengo usuarios veo los archivos de mi usuario
if ($usuarioReproductor == "") {
    $usuarioReproductor = $usuarioAnfitrion;
}
//Analizo los posibles directorios del usuario 
//del cual quiero visualizar las canciones
if (is_dir("repositorio/usuarios/" . $usuarioReproductor .
                "/publico")) {
    $public = scandir("repositorio/usuarios/" . $usuarioReproductor .
            "/publico");
} else {
    $public = null;
}
if (is_dir("repositorio/usuarios/" . $usuarioReproductor .
                "/privado")) {
    $private = scandir("repositorio/usuarios/" . $usuarioReproductor .
            "/privado");
} else {
    $private = null;
}

/* Ruta publicas y privadas */
$dirPublic = "repositorio/usuarios/" . $usuarioReproductor . "/publico/";
$dirPrivate = "repositorio/usuarios/" . $usuarioReproductor . "/privado/";
$publicType = null;
$privateType = null;

/* Variables de musica */
$rock = "rock";
$metal = "metal";
$pop = "pop";
/*Visualización de los archivos del usuario*/
if (count($public) <= 2 && count($private) <= 2) {
    //echo "<h1>No tiene " . $usuarioReproductor . " canciones</h1>";
} else {
    if (count($public) > 2)
        $publicType = scandir($dirPublic);
    if (count($private) > 2)
        $privateType = scandir($dirPrivate);
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
        <title>Lista de Reproducción</title>
    </head>
    <body> 
        <div id="contendor">
            <div class="formulario">
                <h2>Bienvenido <?php echo $usuarioAnfitrion ?></h2>
                <?php
                if (count($public) <= 2 && count($private) <= 2) {
                    echo "<h2>No tiene " . $usuarioReproductor . " canciones</h2>";
                }
                ?>
                <h2>Lista de Reproducción de<?php echo ' ' . $usuarioReproductor
                ?> </h2>



                <?php
                if ($publicType != null) {
                    echo '<div id = "divPublico">';
                    echo '<h3> Lista Publica </h3>';
                    if (is_dir($dirPublic . '/' . $pop)) {
                        echo '<p>' . $pop . '</p>';
                        echo '<ul>';
                        $dir = scandir($dirPublic . '/' . $pop);
                        $directorio = $dirPublic . $pop . '/';
                        for ($index = 2; $index < count($dir); $index++) {
                            //echo '<li>' . $dir[$index] . '<audio src="' . $directorio . $dir[$index] . '"  controls/></li>'
                            echo '<a href="?src=' . $directorio . $dir[$index] . '&usuario=' . $usuarioReproductor . '"><li>' . $dir[$index] . '</li></a>';
                        }
                        echo '</ul>';
                    }
                    if (is_dir($dirPublic . '/' . $metal)) {
                        echo '<p>' . $metal . '</p>';
                        echo '<ul>';
                        $dir = scandir($dirPublic . '/' . $metal);
                        $directorio = $dirPublic . $metal . '/';
                        for ($index = 2; $index < count($dir); $index++) {
                            //echo '<li>' . $dir[$index] . '<audio src="' . $directorio . $dir[$index] . '"  controls/></li>';
                            echo '<a href="?src=' . $directorio . $dir[$index] . '&usuario=' . $usuarioReproductor . '"><li>' . $dir[$index] . '</li></a>';
                        }
                        echo '</ul>';
                    }
                    if (is_dir($dirPublic . '/' . $rock)) {
                        echo '<p>' . $rock . '</p>';
                        echo '<ul>';
                        $dir = scandir($dirPublic . '/' . $rock);
                        $directorio = $dirPublic . $rock . '/';
                        for ($index = 2; $index < count($dir); $index++) {
                            //echo '<li>' . $dir[$index] . '<audio src="' . $directorio . $dir[$index] . '"  controls/></li>';
                            echo '<a href="?src=' . $directorio . $dir[$index] . '&usuario=' . $usuarioReproductor . '"><li>' . $dir[$index] . '</li></a>';
                        }
                        echo '</ul>';
                    }
                    echo '</div>';
                }
                ?>
                <?php
                if ($privateType != null) {
                    if ($usuarioAnfitrion == $usuarioReproductor || $usuarioAnfitrion == "admin") {
                        echo '<div id = "divPrivado">';
                        echo '<h3>Lista Privada</h3>';
                        if (is_dir($dirPrivate . '/' . $pop)) {
                            echo '<p>' . $pop . '</p>';
                            echo '<ul>';
                            $dir = scandir($dirPrivate . '/' . $pop);
                            $directorio = $dirPrivate . $pop . '/';
                            for ($index = 2; $index < count($dir); $index++) {
                                //echo '<li>' . $dir[$index] . '<audio src="' . $directorio . $dir[$index] . '"  controls/></li>';
                                echo '<a href="?src=' . $directorio . $dir[$index] . '&usuario=' . $usuarioReproductor . '"><li>' . $dir[$index] . '</li></a>';
                            }
                            echo '</ul>';
                        }
                        if (is_dir($dirPrivate . '/' . $metal)) {
                            echo '<p>' . $metal . '</p>';
                            echo '<ul>';
                            $dir = scandir($dirPrivate . '/' . $metal);
                            $directorio = $dirPrivate . $metal . '/';
                            for ($index = 2; $index < count($dir); $index++) {
                                //echo '<li>' . $dir[$index] . '<audio src="' . $directorio . $dir[$index] . '"  controls/></li>';
                                echo '<a href="?src=' . $directorio . $dir[$index] . '&usuario=' . $usuarioReproductor . '"><li>' . $dir[$index] . '</li></a>';
                            }
                            echo '</ul>';
                        }
                        if (is_dir($dirPrivate . '/' . $rock)) {
                            echo '<p>' . $rock . '</p>';
                            echo '<ul>';
                            $dir = scandir($dirPrivate . '/' . $rock);
                            $directorio = $dirPrivate . $rock . '/';
                            for ($index = 2; $index < count($dir); $index++) {
                                //echo '<li>' . $dir[$index] . '<audio src="' . $directorio . $dir[$index] . '"  controls/></li>';
                                echo '<a href="?src=' . $directorio . $dir[$index] . '&usuario=' . $usuarioReproductor . '"><li>' . $dir[$index] . '</li></a>';
                            }
                            echo '</ul>';
                        }
                        echo '</div>';
                    }
                }
                $cancion = Request::get('src');
                ?>
                <br/>
                <div id="reproductor">
                    <h2>Reproductor de Música</h2>
                    <audio src="<?php echo $cancion ?>" controls autoplay/>
                </div>

            </div>
            <div id ="volver">
                <form action="user.php" method="post" enctype="multipart/form-data">
                    <input type="submit" value="Volver a Usuario" />
                </form>
            </div>
        </div>    

    </body>
</html>
