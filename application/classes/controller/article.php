<?php
class Article_Controller extends Page {
    public $article;

    function __construct() {
        parent::__construct();
        
        $this->template = 'templateArticle';
        // Find the page in the database
        $article = '';
    }
    
	public function action_view() {
		$this->pageView = 'pageView';
		$this->attributeView = 'attributeView';
		$this->view->mode = 'view';
		$this->set_common_items();
		$this->view->message = 'Have fun coding!';
	}

	public function action_edit() {
		$this->pageView = 'pageEdit';
		$this->attributeView = 'attributeEdit';
		$this->view->mode = 'edit';
		$this->set_common_items();
		$this->view->message = 'Have fun coding!';
	}

	public function action_talk() {
		$this->pageView = 'pageTalk';
		$this->attributeView = 'attributeTalk';
		$this->view->mode = 'talk';
		$this->set_common_items();
		$this->view->message = 'Have fun coding!';
	}
	
	
	private function set_common_items() {
        $this->view->pageTitle = 'The Page Title Goes Here';
        $this->view->pageSummary = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut bibendum, ligula in congue rhoncus, sapien ante posuere arcu, sed imperdiet mi dui id urna. In id consequat dolor. Aliquam erat volutpat. Suspendisse eget felis ut leo elementum tempor. Pellentesque rutrum interdum placerat. Pellentesque consectetur leo vel neque hendrerit at aliquam dolor laoreet. Suspendisse potenti. Vivamus volutpat tempor lacus a ornare. Donec viverra iaculis tortor, fermentum consectetur ipsum aliquam at. Proin iaculis nulla sed mauris interdum accumsan. Aliquam arcu lacus, gravida a fermentum sed, ullamcorper quis velit.';
	}
}
