<?php

class AutoCarga {
    static function cargar($clase){
        $clases = str_replace("\\", "/", $clase);
        $archivo = "clases/" . $clase . ".php";
        require $archivo;
    }
    
}
spl_autoload_register('AutoCarga::cargar');
