<?php

class Article_Model extends ORM {
    // Table name
    public $table = 'articles';
    
    // Primary key
    public $id_field = 'id';    
    
    // Each article can have many sections
    protected $has_many=array(
        'sections'=>array(
            'model'=>'ArticleSection',
            'key'=>'article_id'
        ),
        'attributes'=>array(
            'model'=>'ArticleAttribute',
            'key'=>'attribute_id'
        )
    );
    
    // Each article belongs to a template
    protected $belongs_to=array(
        'template'=>array(
            'model'=>'template',
            'key'=>'template_id'
        )
    );
}
