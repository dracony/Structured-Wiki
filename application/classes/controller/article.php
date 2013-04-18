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
        $this->init_article();


        // Set the mode to view
    		$this->view->mode = 'view';

	    if ($this->loaded) {
            $this->pageView = 'article/View';
            $this->attributeView = 'attribute/View';

            $this->view->pageTitle = $this->title;
            $this->view->articleTitle = $this->title;
            $this->view->articleSummary = Util::TextToHtml($this->summary);
            $this->view->articleTemplate = $this->template->name;
            $this->view->lastUpdated = $this->lastUpdated;
            
            // Load in sections
            $sectionList = array();
            $articleSections = $this->articleORM->sections->find_all();
            foreach ($articleSections as $s) {
    		        $object = (object)array('title' => $s->template->title,
    		                                'html' => $s->html);
    		        array_push($sectionList, $object);
            }
            $this->view->articleSections = $sectionList;
            

	    } else {
            $this->pageView = 'article/New';
            $this->attributeView = 'attribute/New';
            $this->view->pageTitle = 'Create article ' . $this->id . '?';
	    }
	}

	public function action_edit() {
        $this->init_article();
        
        // If the article does not exist offer to create a new one
        // if we can't create a new one, bounce over to the template
        // because its missing
	    if (!$this->loaded) {
	        if(!$this->create_article()) {
                return $this->response->redirect('/!Default');
             }
	    } else {
    
        	    // Setup basic article items
            $this->view->pageTitle = "Edit page " . $this->title;
            $this->view->articleTitle = $this->title;
            $this->view->articleSummary = $this->summary;
    	    
        	    // If this is a post save the form just save it
        	    // and move along
        	    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        	        $this->save_article();
                 return $this->response->redirect('/' . $this->title);
        	    }
        	    
        	    // Setup the article for editing
            $this->pageView = 'article/Edit';
            $this->attributeView = 'attribute/Edit';
            $this->view->mode = 'edit';
    
            $pageHasContent = false;
    
            // grab the template attributes
            $arrtibuteList = array();
            $articleAttributes = $this->template->attributes->order_by('order', 'ASC')->find_all()->as_array(true);
            foreach ($articleAttributes as $s) {
                $articleAttribute = $this->articleORM->attributes->where('attribute_id', $s->id)->find();
                $raw = "";
                if ($articleAttribute->loaded()) {
                }
            }
    	    
    	    
            // grab the template sections
            $sectionList = array();
            $articleSections = $this->template->sections->order_by('order', 'ASC')->find_all()->as_array(true);
            foreach ($articleSections as $s) {
                $articleSection = $this->articleORM->sections->where('section_id', $s->id)->find();
                $raw = "";
                if ($articleSection->loaded()) {
                    $raw = $articleSection->raw;
                }
    		        $object = (object)array('id' => $s->id,
    		                                'type' => $s->type, 
    		                                'title' => $s->title,
    		                                'raw' => $raw);
    		        array_push($sectionList, $object);
    		        
    		        if ($raw != "") {
    		            $pageHasContent = true;
    		        }
            }
            $this->view->articleSections = $sectionList;
            
            // grab all templates
            if (!$pageHasContent) {
                $this->view->selectedTemplateID = $this->templateID;
                $this->view->templateList = ORM::factory('template')->find_all()->as_array();
            } else {
                $this->view->selectedTemplateID = -1;
                $this->view->templateList = [];
            }
	    }
	}

	public function action_talk() {
        // Find the template in the database
		$this->articleData = ORM::factory('article')->where('title', $this->id)->find();

		$this->pageView = 'article/Talk';
		$this->attributeView = 'attribute/Talk';
		$this->view->mode = 'talk';
		$this->view->message = 'Have fun coding!';
	}
	
	
	/**
	 * Load the article's data from the databsae and setup
	 * the class variables for access elsewhere. This is done
	 * here so there is no need to check for the loaded state
	 * all over the place.
	 *
	 * @return void
	 * @access private
	 */
	private function init_article() {
        // Find the article in the database
		$this->articleORM = ORM::factory('article')->where('title', $this->id)->find();
		
		// Initilize article variable
	    if ($this->articleORM->loaded()) {
	        $this->loaded = true;
	        $this->title = $this->articleORM->title;
	        $this->summary = $this->articleORM->summary;
	        $this->template = $this->articleORM->template->find();
	        $this->templateID = $this->articleORM->template_id;
	        $this->templateName = $this->template->name;
	        $this->lastUpdated = $this->articleORM->lastEditDate;
	    } else {
	        $this->loaded = false;
	        $this->title = "Article Not Loaded";
	        $this->summary = "";
	        $this->template = null;
	        $this->templateID = -1;
	        $this->templateName = "";
	        $this->lastUpdated = "";
	    }
    }
	
	
	/**
	 *
	 *
	 */
	private function save_article() {
        // Save the article
        $this->articleORM->title = $this->request->post('articleTitle', $this->id);
        $this->articleORM->summary = $this->request->post('articleSummary', $this->summary);
        $this->articleORM->template_id = $this->request->post('articleTemplate', $this->templateID);
        $this->articleORM->lastEditIP = $_SERVER['REMOTE_ADDR'];
        $this->articleORM->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
	    $this->articleORM->save();
	    
        // grab the selected template's sections
        $selectedTemplate = ORM::factory('template', $this->articleORM->template_id);
        $sectionList = $selectedTemplate->sections->order_by('order', 'ASC')->find_all()->as_array(true);
        
        // Loop through the sections and save them
        foreach ($sectionList as $s) {
            $sID = 'section-' . $s->id;
            $sValue = $this->request->post($sID, '', false);
            $articleSection = $this->articleORM->sections->where('section_id', $s->id)->find();
            $articleSection->article_id = $this->articleORM->id;
            $articleSection->section_id = $s->id;
            $articleSection->raw = trim($sValue);
            switch($s->type) {
                case 'mu':
                    $articleSection->html = util::MarkupToHtml($sValue);
                    break;
                case 'txt':
                default:
                    $articleSection->html = util::TextToHtml($sValue);
                    break;
            }
            $articleSection->lastEditIP = $_SERVER['REMOTE_ADDR'];
            $articleSection->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
            $articleSection->save();
        }
	}
	
	
	/**
	 * Deal with creating a new article. This is only dealing with
	 * setting up the title and template.
	 *
	 * @return void
	 * @access private
	 */
	private function create_article() {
        $this->view->pageTitle = "Create page  " . $this->id;
        $this->view->articleTitle = $this->id;
        $this->view->articleSummary = "";

    	    if($_SERVER['REQUEST_METHOD'] == 'POST') {
    	        $this->save_article();
            return $this->response->redirect('/' . $this->title);
    	    }
        
        // Grab templates
        $this->view->templateList = ORM::factory('template')->find_all()->as_array();
        if (count($this->view->templateList) == 0) {
            // There are no templates
            return false;
        }
        
        // Setup the view for creating a new article
        $this->pageView = 'article/Create';
        $this->attributeView = 'attribute/Create';
        $this->view->mode = 'edit';

        $selectedTemplate = $this->view->templateList[0];
        $this->view->selectedTemplateID = $selectedTemplate->id;
        
        // grab the template sections
        $this->view->sectionList = $selectedTemplate->sections->order_by('order', 'ASC')->find_all()->as_array(true);
        return true;
	}
}
