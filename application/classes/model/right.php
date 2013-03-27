<?php

class Right_Model extends ORM {
    // Table name
    public $table = 'rights';
    
    // Primary key
    public $id_field = 'id';
    
    protected $has_many = array (
        'rights' => array(
            'model' => 'right',
            'through' => 'user_rights',
            'key'=>'right_id', 
            'foreign_key'=>'user_id'
        )
    );
}
