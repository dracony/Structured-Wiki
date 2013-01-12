<?php

class Article_Model extends ORM {
    // Table name
    public $table = 'atricles';
    
    // Primary key
    public $id_field = 'id';
    
    // Create the needed table if it doesn't already exist
    public static function install() {
    }
    
}
