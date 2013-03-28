<?php

class TemplateSection_Model extends ORM {
    // Table name
    public $table = 'template_sections';
    
    // Primary key
    public $id_field = 'id';
    
    // Each section belongs to a template
    protected $belongs_to=array(
        'template'=>array(
            'model'=>'template',
            'key'=>'template_id'
        )
    );

    // Each template section can be used by many article sections
    protected $has_many=array(
        'sections'=>array(
            'model'=>'ArticleSection',
            'key'=>'section_id'
        )
    );
}
