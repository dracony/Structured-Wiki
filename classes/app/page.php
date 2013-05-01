<?php
namespace App;
class Page extends \PHPixie\Controller {
    public $id;            // The current ID
    
    public $template;      // The html template to use
    public $view;          // The loaded view
    public $pageView;      // The page content template to use
    public $attributeView; // The page attribute template to use
    
    public $appTitle;
    public $pageTitle;
    
    public function before() {
        $this->startTime = microtime();
        
        // Grab the ID
        // TODO: Make unicode safe
        $this->id = strtolower($this->request->param('id', 'Welcome'));
        
        // This will be our global view
        $this->view = $this->pixie->view($this->template);
        
        // Make sure the application has been configured
        if ($this->pixie->config->get('application.initilized', false) === false) {
            $this->response->redirect('/~installer');
 
            // Prevent action and after() from firing
            $this->execute=false;
            return;
        }
        
        // Grab the application configuration
        $this->appTitle = $this->pixie->config->get('application.name', 'Wiki Title');
        $this->view->appLicense = $this->pixie->config->get('application.license', '');
        
        // Set the page default rites
        $this->view->canEdit = true;
        $this->view->canTalk = true;
        
        // Setup page defaults
        $this->view->mode = 'view';
        $this->view->id = $this->id;
        $this->view->pageImage = '/defaultPageImage.jpg';
        
        // Setup the default layout
        $this->view->cssLayout = "layoutLeft";
    }
 
 
    //This will execute after an action is completed
    public function after() {
        // If no attribute view set to full width page
        if ($this->attributeView === '') {
            $this->view->cssLayout = "layoutFull";
        }
        
        // Fixup the layout css
        $this->view->cssLayout .= '.css';
        
        // Update the title
        $this->view->browserTitle = $this->appTitle . ': ' . $this->view->pageTitle;
        $this->view->appTitle = $this->appTitle;
        
        //We will find the file path to the view that will 
        //be specified as $subview by the actual controller
        $this->view->pageView = $this->pixie->find_file('views', $this->pageView);
        $this->view->pageFooter = $this->pixie->find_file('views', 'pageFooter');
        $this->view->attributeView = $this->pixie->find_file('views', $this->attributeView);
 

        $this->view->timeSpent = microtime() - $this->startTime;
        
        //And now to render the main view
		$this->view->username = $this->pixie->session->get('username', false);
        $this->response->body = $this->view->render();
    }
    
    private function rutime($ru, $rus, $index) {
        return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
             -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
    }    
}
