<?php
namespace SVP\Model;

class GlobalChanges{
    protected static $_instance = null;

    public function __construct(){
        
    }

    /**
     * create instance
     */
    public static function instance(){
        if(self::$_instance == null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

GlobalChanges::instance();