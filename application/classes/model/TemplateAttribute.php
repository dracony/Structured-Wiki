<?php

class TemplateAttribute_Model extends ORM {
    // Table name
    public $table = 'template_attributes';
    
    // Primary key
    public $id_field = 'id';
    
    // Each section belongs to a template
    protected $belongs_to=array(
        'template'=>array(
            'model'=>'template',
            'key'=>'template_id'
        )
    );
}
