<?php
require './clases/AutoCarga.php';
require './clases/UploadFileArchivos.php';
require './clases/Ordenar.php';

$archivo = $_FILES["archivos"];
$sesion = new Session();
//evita que cree carpetas sino has enviado ningún archivo
if($archivo == null){
    $sesion->sendRedirect("user.php");
}
$usuario = $sesion->getUser();
$fichero = new UploadFileArchivos($archivo,$usuario);
$privacidad = Request::post("tipo");
$categoria = Request::post("categoria");
$carpeta= $fichero->getDestino().$usuario.'/'.$privacidad.'/'.
        $categoria;
echo $carpeta;
//sino esta la carpeta la creo
if(!is_dir($carpeta)){
    mkdir($carpeta . "/", 0777,true);
}
echo '<hr/>';
$fichero->setDestino($carpeta.'/');
echo '<hr/>';
$fichero1 = $fichero->getParametrosOrdenados();
echo var_dump($fichero1);
echo '<hr/>';
$fichero2 = $fichero->getArchivosUsuario();
echo var_dump($fichero2);
echo '<hr/>';
$fichero3 = $fichero->getPo();
echo var_dump($fichero3);
echo '<hr/>';

echo var_dump($fichero->getDestino());
echo '<hr/>';
echo var_dump($fichero->getExtension());
echo '<hr/>';
echo var_dump($fichero->getNombre());
echo '<hr/>';
$fichero->upload();
$sesion->sendRedirect("user.php");
