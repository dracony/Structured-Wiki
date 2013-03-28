<?php
class Article_Controller extends Page {
    public $article;

    function __construct() {
        parent::__construct();
        
        $this->template = 'tempArticle';
        // Find the page in the database
        $article = '';
    }
    
	public function action_view() {
        // Find the template in the database
		$this->articleData = ORM::factory('template')->where('name', $this->id)->find();


        // Set the mode to view
    		$this->view->mode = 'view';

	    if ($this->articleData->loaded()) {
            $this->pageView = 'article/View';
            $this->attributeView = 'attribute/View';
            $this->view->pageTitle = $this->articleData->title;
	    } else {
            $this->pageView = 'article/New';
            $this->attributeView = 'attribute/New';
            $this->view->pageTitle = 'Create article ' . $this->id . '?';
	    }
	}

	public function action_edit() {
        // Find the template in the database
		$this->articleData = ORM::factory('template')->where('name', $this->id)->find();

		$this->pageView = 'atricle/Edit';
		$this->attributeView = 'attribute/Edit';
		$this->view->mode = 'edit';
		$this->set_common_items();
		$this->view->message = 'Have fun coding!';
	}

	public function action_talk() {
        // Find the template in the database
		$this->articleData = ORM::factory('template')->where('name', $this->id)->find();

		$this->pageView = 'article/Talk';
		$this->attributeView = 'attribute/Talk';
		$this->view->mode = 'talk';
		$this->set_common_items();
		$this->view->message = 'Have fun coding!';
	}
	
	
	private function set_common_items() {
        $this->view->pageTitle = 'The Page Title Goes Here';
        $this->view->pageSummary = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut bibendum, ligula in congue rhoncus, sapien ante posuere arcu, sed imperdiet mi dui id urna. In id consequat dolor. Aliquam erat volutpat. Suspendisse eget felis ut leo elementum tempor. Pellentesque rutrum interdum placerat. Pellentesque consectetur leo vel neque hendrerit at aliquam dolor laoreet. Suspendisse potenti. Vivamus volutpat tempor lacus a ornare. Donec viverra iaculis tortor, fermentum consectetur ipsum aliquam at. Proin iaculis nulla sed mauris interdum accumsan. Aliquam arcu lacus, gravida a fermentum sed, ullamcorper quis velit.';
	}
}
