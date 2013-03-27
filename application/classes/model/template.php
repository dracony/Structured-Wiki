<?php

class Template_Model extends ORM {
    // Table name
    public $table = 'templates';
    
    // Primary key
    public $id_field = 'id';
    
    // Each template can have many sections
    protected $has_many=array(
        'sections'=>array(
            'model'=>'TemplateSection',
            'key'=>'template_id'
        )
    );
}
