<?php
class Template_Controller extends Page {
    public $templateData;

    function __construct() {
        parent::__construct();
        
        $this->template = 'tempTemplate';
        
    }
    
	public function action_view() {
        // Find the template in the database
		$this->templateData = ORM::factory('template')->where('name', $this->id)->find();

        // Set the mode to view
    		$this->view->mode = 'view';

	    if ($this->templateData->loaded()) {
        		$this->view->pageTitle = 'Template: ' . $this->templateData->name;
        		$this->view->pageSummary = $this->templateData->description;
        		$this->pageView = 'template/View';
        		$this->set_common_items();
        		$this->view->message = 'Have fun coding!';
        } else {
        		$this->pageView = 'template/New';
        		$this->view->pageTitle = 'Create template ' . $this->id . '?';
        		$this->view->pageSummary = '';
        }
	}

	public function action_edit() {
        // Find the template in the database
		$this->templateData = ORM::factory('template')->where('name', $this->id)->find();

	    
	    // If this is a post save the form
	    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        		$this->templateData->name  = $this->request->post('templateName', '');
             $this->templateData->description = $this->request->post('templateDescription', '');
             $this->templateData->lastEditIP = $_SERVER['REMOTE_ADDR'];
             $this->templateData->lastEditDate = $_SERVER['REMOTE_ADDR'];
             $this->templateData->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
             
        		$this->templateData->save();
        		$this->response->redirect('/edit/!' . $this->templateData->name);
    		}

        // Set the mode to view
		$this->view->mode = 'edit';

        // Set page variables
		$this->pageView = 'template/Edit';
    		$this->view->pageTitle = 'Editing template ' . $this->templateData->name;
		$this->view->templateName = $this->templateData->name;
		$this->view->templateDescription = $this->templateData->description;
		
		// Setup the template sections
	    if ($this->templateData->loaded()) {
        		$this->view->templateSections = $this->templateData->sections->find_all()->as_array();
        		if (count($this->view->templateSections) == 0) {
            		$this->view->templateSections = array(
            		    array('name' => 'Content', 'type' => 'markup')
            		);
        		}
	    } else {
        		$this->view->templateSections = array(
        		    array('name' => 'Content', 'type' => 'markup')
        		);
	    }
	}

	public function action_talk() {
		$this->pageView = 'pageTalk';
		$this->attributeView = 'attributeTalk';
		$this->view->mode = 'talk';
		$this->set_common_items();
		$this->view->message = 'Have fun coding!';
	}
	
	
	private function set_common_items() {
	}
}
