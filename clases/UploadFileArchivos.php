<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UploadFileArchivos
 *
 * @author Juanka
 */

class UploadFileArchivos {
    private $parametrosOrdenados,$po;
    //probamos po para que solo me de el nombre del archivo
    //parametros ordenados son lo único que quiero de mi archivo (nombre,tipo)
    private $destino = './repositorio/', $nombre, $tamaño = 1000000000000,
            $extension=Array(),$usuario="";
    //es el conjuntos de archivos ->Coger con un $_FILE
    private $parametro;
    private $archivosUsuario = Array();
    /*Usuario va a ser único para cada tipo*/
    /*$parametro es el name*/
    const CONSERVAR = 1,REMPLAZAR = 2, RENOMBRAR = 3;//politica de subida de archivos
    //estas variables son siempre staticas y publicas
    /*tipo de arvhivos se controlara despues*/
    private $error = true, $politica = self::RENOMBRAR,$subido=false;
    private $arrayDeTipos = Array(
        "mp3" =>1
    );
    function __construct($parametro,$usuario) {
        $this->parametro=$parametro;
        $this->usuario = $usuario;
        $this->destino.='usuarios/';
        $miArray = Array();
        if(isset($parametro)){
            $this->parametrosOrdenados =  Ordenar::reconstruirArchivo
                    ($parametro, $miArray);
            for ($index = 0; $index < count($this->parametrosOrdenados); $index++) {
                $this->archivosUsuario[$index]["nombre"] = 
                        $this->parametrosOrdenados[$index]["name"];
                $this->archivosUsuario[$index]["tipo"] = 
                        $this->parametrosOrdenados[$index]["type"];

            }
            $this->po = Ordenar::reconstruirArchivoSubir($parametro, $miArray);
            }else{
                $this->error = false;
            }
        /*Extensión*/
        for ($index1 = 0; $index1 < count($this->po); $index1++) {
                $this->extension[$index1] = 
                       $this->po[$index1]["tipo"];
        }
        for ($index1 = 0; $index1 < count($this->po); $index1++) {
                $this->nombre[$index1] = 
                       trim($this->po[$index1]["nombre"]);
        }
    }
    function getPo() {
        return $this->po;
    }

    function setPo($po) {
        $this->po = $po;
    }

    function getParametrosOrdenados() {
        return $this->parametrosOrdenados;
    }
    function getArchivosUsuario() {
        return $this->archivosUsuario;
    }

    function setArchivosUsuario($archivosUsuario) {
        $this->archivosUsuario = $archivosUsuario;
    }

    function getDestino() {
        return $this->destino;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getTamaño() {
        return $this->tamaño;
    }

    function getParametro() {
        return $this->parametro;
    }

    function getExtension() {
        return $this->extension;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getError() {
        return $this->error;
    }

    function getPolitica() {
        return $this->politica;
    }

    function getSubido() {
        return $this->subido;
    }

    function getArrayDeTipos() {
        return $this->arrayDeTipos;
    }

    function setParametrosOrdenados($parametrosOrdenados) {
        $this->parametrosOrdenados = $parametrosOrdenados;
    }

    function setDestino($destino) {
        $this->destino = $destino;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setTamaño($tamaño) {
        $this->tamaño = $tamaño;
    }

    function setParametro($parametro) {
        $this->parametro = $parametro;
    }

    function setExtension($extension) {
        $this->extension = $extension;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setError($error) {
        $this->error = $error;
    }

    function setPolitica($politica) {
        $this->politica = $politica;
    }

    function setSubido($subido) {
        $this->subido = $subido;
    }

    function setArrayDeTipos($arrayDeTipos) {
        $this->arrayDeTipos = $arrayDeTipos;
    }
    
    public function upload(){
        if($this->subido){
            return false;
        }
        if($this->error == false)//valida que el archivo exista
            return false;
        /*Subida de Error*/
        for ($index = 0; $index < count($this->parametrosOrdenados); $index++) {
             if($this->parametro["error"][$index] != UPLOAD_ERR_OK)
                return false;
        }
        /*Tamaño*/
        for ($index = 0; $index < count($this->parametrosOrdenados); $index++) {
             if($this->parametro["size"][$index] > $this->tamaño)
                return false;
        }
        /*Extension*/
        for ($index = 0; $index < count($this->extension); $index++) {
             if(!$this->isTipo($this->extension[$index]))
                return false;
        }
       
        if(!(is_dir($this->destino) && substr($this->destino, -1) === "/"))
        //para evitar otros directorios
            return false;
//        if($this->politica === self::CONSERVAR && file_exists($this->destino.$this->nombre . "." . $this->extension))
//            return false;
        //Poner el nombre del archivo
        /*--------------------------------------------------------------------*/
//        $nombre = $this->nombre;
//        if($this->politica === self::RENOMBRAR && file_exists($this->destino.$this->nombre . "." . $this->extension)){
//            $nombre = $this->remplazar(file_exists($this->destino.$this->nombre . "." . $this->extension));
//        }
//        $this->subido=true;
        for ($index1 = 0; $index1 < count($this->parametrosOrdenados); $index1++) {
            move_uploaded_file($this->parametro['tmp_name'][$index1], 
                    $this->destino. $this->nombre[$index1] . "." . $this->extension[$index1]);
        }
       
    }

    public function isTipo($tipo){
        return isset($this->arrayDeTipos[$tipo]);
    }
    public function addTipo($tipo){
        if(!$this->isTipo($tipo)){
            $this->arrayDeTipos[$tipo]=1;
            return true;
        }
        return false;
    }
    
    public function removeTipo($tipo){
        if($this->isTipo($tipo)){
            unset($this->arrayDeTipos[$tipo]);
            return true;
        }
        return false;
    }
}
