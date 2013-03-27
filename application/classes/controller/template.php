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
        		$this->view->templateSections = $this->templateData->sections->order_by('order', 'ASC')->find_all()->as_array(true);
        		$this->pageView = 'template/View';
        		$this->set_common_items();
        		$this->view->message = 'Have fun coding!';
        } else {
        		$this->pageView = 'template/New';
        		$this->view->pageTitle = 'Create template ' . $this->id . '?';
        		$this->view->pageSummary = '';
        		$this->view->templateSections = [];
        }
	}
	

	public function action_edit() {
        // Find the template in the database
		$this->templateData = ORM::factory('template')->where('name', $this->id)->find();
	    
	    // If this is a post save the form
	    if($_SERVER['REQUEST_METHOD'] == 'POST') {
	        // Set the easy stuff
        		$this->templateData->name  = $this->request->post('templateName', '');
             $this->templateData->description = $this->request->post('templateDescription', '');
             $this->templateData->lastEditIP = $_SERVER['REMOTE_ADDR'];
             $this->templateData->lastEditDate = $_SERVER['REMOTE_ADDR'];
             $this->templateData->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
             
             // Set the sections
             $sections = json_decode($this->request->post('templateSections', '[]'));
             // Add/Update sections
             foreach ($sections as $s) {
                 $order = $s[0];
                 $orig = $s[1];
                 $title = $s[2];
                 $type = $s[3];
                 
                 $sectionData = $this->templateData->sections->where('title', $orig)->find();
                 $sectionData->template = $this->templateData;
                 $sectionData->title = $title;
                 $sectionData->order = $order;
                 $sectionData->type = $type;
                 $sectionData->save();
             }
             $currentSections = $this->templateData->sections->find_all();
             foreach ($currentSections as $cs) {
                 $found = false;
                 foreach ($sections as $s) {
                     $title = $s[2];
                     if ($cs->title == $title) {
                         $found = true;
                     }
                 }
                 
                 // Remove old
                 if ($found === false) {
                     $cs->delete();
                 }
             }
             
        		$this->templateData->save();
        		
        		// Redirect to prevent browser reload issues
        		$this->response->redirect('/edit/!' . $this->templateData->name);
    		}

        // Set the mode to view
		$this->view->mode = 'edit';

        // Set page variables
		$this->pageView = 'template/Edit';
		
		// Setup the template sections
	    if ($this->templateData->loaded()) {
        		$this->view->pageTitle = 'Editing template ' . $this->templateData->name;
        		$this->view->templateName = $this->templateData->name;
        		$this->view->templateDescription = $this->templateData->description;
        		$this->view->templateSections = $this->templateData->sections->order_by('order', 'ASC')->find_all()->as_array(true);
        		if (count($this->view->templateSections) == 0) {
            		$this->view->templateSections = array(
            		    (object)array('title' => 'Content', 'type' => 'mu')
            		);
        		}
        		$this->view->templateAttributes = array();
	    } else {
        		$this->view->pageTitle = 'Editing template ' . $this->id;
        		$this->view->templateName = $this->id;
        		$this->view->templateDescription = "";
        		$this->view->templateSections = array(
        		    (object)array('title' => 'Content', 'type' => 'mu')
        		);
        		$this->view->templateAttributes = array();
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
