<?php

namespace App\Models;

class Criptografia {
    public static function md5($texto) {
        
        return md5(Config::show('md5_salt') . '_' . $texto);
    }
}
