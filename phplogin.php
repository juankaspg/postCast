<?php

require './clases/AutoCarga.php';

/*Usuarios*/
$users = Array(
"admin" => "admin",
"maria" => "maria",
"juan" => "juan",
"marta" => "marta",
"antonio" => "antonio"
);

$usuario = Request::post("usuario");
$contrasena = Request::post("pass");
$sesion = new Session();
if(isset($users[$usuario]) && $users[$usuario]==$contrasena){
    $user = new Usuario($usuario);
    $sesion->setUser($user);
    $sesion->sendRedirect("user.php");
}else{
    $sesion->destroy();
    $sesion->sendRedirect("login.php");
}

