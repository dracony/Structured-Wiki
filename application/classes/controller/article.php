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
		$this->articleData = ORM::factory('article')->where('title', $this->id)->find();


        // Set the mode to view
    		$this->view->mode = 'view';

	    if ($this->articleData->loaded()) {
            $this->pageView = 'article/View';
            $this->attributeView = 'attribute/View';
            $this->view->pageTitle = $this->articleData->title;

            $this->view->articleTitle = $this->articleData->title;
            $this->view->articleSummary = Util::TextToHtml($this->articleData->summary);
            $sectionList = array();
            $articleSections = $this->articleData->sections->find_all();
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
        // Find the template in the database
		$this->articleData = ORM::factory('article')->where('title', $this->id)->find();
	    
        $this->pageView = 'article/Edit';
        $this->attributeView = 'attribute/Edit';
        $this->view->mode = 'edit';

	    // If this is a post save the form
	    if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Save the article
            $this->articleData->title = $this->request->post('articleTitle', $this->id);
            $this->articleData->summary = $this->request->post('articleSummary', '');
            $this->articleData->template_id = $this->request->post('articleTemplate', '-1');
            $this->articleData->lastEditIP = $_SERVER['REMOTE_ADDR'];
            $this->articleData->lastEditDate = gmdate("Y-m-d\TH:i:s\Z");
	        $this->articleData->save();
	        
            // grab the selected template's sections
            $selectedTemplate = ORM::factory('template', $this->articleData->template_id);
            $sectionList = $selectedTemplate->sections->order_by('order', 'ASC')->find_all()->as_array(true);
            
            // Loop through the sections and save them
            foreach ($sectionList as $s) {
                $sID = 'section-' . $s->id;
                $sValue = $this->request->post($sID, '', false);
                $articleSection = $this->articleData->sections->where('section_id', $s->id)->find();
                $articleSection->article_id = $this->articleData->id;
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
            
            // Redirect to prevent browser reload issues
            $this->response->redirect('/' . $this->articleData->title);
	    }
	    
		// Setup the template sections
	    if ($this->articleData->loaded()) {
            $this->view->pageTitle = "Edit page " . $this->articleData->title;
            $this->view->articleTitle = $this->articleData->title;
            $this->view->articleSummary = $this->articleData->summary;

            // grab the template sections
            $pageHasContent = false;
            $sectionList = array();
            $selectedTemplate = ORM::factory('template', $this->articleData->template_id);
            $articleSections = $selectedTemplate->sections->order_by('order', 'ASC')->find_all()->as_array(true);
            foreach ($articleSections as $s) {
                $articleSection = $this->articleData->sections->where('section_id', $s->id)->find();
    		        $object = (object)array('id' => $s->id,
    		                                'type' => $s->type, 
    		                                'title' => $s->title,
    		                                'raw' => $articleSection->raw);
    		        array_push($sectionList, $object);
    		        
    		        if ($articleSection->raw != "") {
    		            $pageHasContent = true;
    		        }
            }
            $this->view->articleSections = $sectionList;
            
            // grab all templates
            if (!$pageHasContent) {
                $this->view->selectedTemplateID = $this->articleData->template_id;
                $this->view->templateList = ORM::factory('template')->find_all()->as_array();
            } else {
                $this->view->selectedTemplateID = -1;
                $this->view->templateList = [];
            }
	    } else {
            $this->view->pageTitle = "Edit page  " . $this->id;
            $this->view->articleTitle = $this->id;
            $this->view->articleSummary = "";
            
            // Grab templates
            $this->view->templateList = ORM::factory('template')->find_all()->as_array();
            $selectedTemplate = $this->view->templateList[0];
            $this->view->selectedTemplateID = $selectedTemplate->id;
            
            // grab the template sections
            $this->view->sectionList = $selectedTemplate->sections->order_by('order', 'ASC')->find_all()->as_array(true);
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
}
