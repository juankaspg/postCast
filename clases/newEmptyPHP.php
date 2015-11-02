<?php

class datos{
    private $destino = "./", $nombre = "", $tamaño = 1000000, $parametro, $extension;
    /*$parametro es el name*/
    const CONSERVAR = 1,REMPLAZAR = 2, RENOMBRAR = 3;//politica de subida de archivos
    //estas variables son siempre staticas y publicas
    /*tipo de arvhivos se controlara despues*/
    private $error = true, $politica = self::RENOMBRAR,$subido=false;
    private $arrayDeTipos = Array(
        "jpg"=>1,
        "gif"=>1,
        "png"=>1,
        "jpeg"=>1
    );
    
    
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


    
}


class UploadFile {
    private $vectorDatos= array(); //array con los datos que necesitamos
    
    function __construct($vectorArchivosSubir) {
        $this->vectorDatos=$vectorArchivosSubir;
    }

    public function testeo(){
        
        for($i=0; $i<count($vectorDatos);$i++){
        if(isset($_FILES[$vectorDatos[i]]) && $_FILES[$vectorDatos[i]]["name"] !== ""){
            $this->vectorDatos[i].setParametro($parametro);
            $nombre = $_FILES[$this->parametro]["name"];
            /*La linea de abajo da el nombre del archivo por defecto si no lo da el usuario*/
            $this->nombre = pathinfo($_FILES[$this->parametro]["name"])["filename"];
            $this->extension = pathinfo($_FILES[$this->parametro]["name"])["extension"];
        }else{
            $this->error = false;
        }
        
        }
   
    }
    
    
    
    
    
    public function upload(){
        if($this->subido){
            return false;
        }
        if($this->error == false)//valida que el archivo exista
            return false;
        if($_FILES[$this->parametro]["error"] != UPLOAD_ERR_OK)
            return false;
        if($_FILES[$this->parametro]["size"] > $this->tamaño)
            return false;
        if(!$this->isTipo($this->extension))
            return false;
        if(!(is_dir($this->destino) && substr($this->destino, -1) === "/"))//para evitar otros directorios
            return false;
        if($this->politica === self::CONSERVAR && file_exists($this->destino.$this->nombre . "." . $this->extension))
            return false;
        $nombre = $this->nombre;
        if($this->politica === self::RENOMBRAR && file_exists($this->destino.$this->nombre . "." . $this->extension)){
            $nombre = $this->remplazar(file_exists($this->destino.$this->nombre . "." . $this->extension));
        }
        $this->subido=true;
        return move_uploaded_file($_FILES[$this->parametro]['tmp_name'], $this->destino.$nombre . "." . $this->extension);
    }
    
    private function remplazar($nombre){
        $i = 1;
        while(file_exists($this->destino.$nombre."_".$i.".".$this->extension)){
            $i++;
        }
        return $nombre."_".$i;
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
    
    public function isTipo($tipo){
        return isset($this->arrayDeTipos[$tipo]);
    }
    
}
