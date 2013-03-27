<?php
class Page extends Controller {
    public $id;            // The current ID
    
    public $template;      // The html template to use
    public $view;          // The loaded view
    public $pageView;      // The page content template to use
    public $attributeView; // The page attribute template to use
    
    public $appTitle;
    public $pageTitle;
    
    public function before() {
        // Grab the ID
        // TODO: Make unicode safe
        $this->id = strtolower($this->request->param('id', 'Welcome'));
        
        // This will be our global view
        $this->view = View::get($this->template);
        
        // Make sure the application has been configured
        if (Config::get('application.initilized', false) === false) {
            $this->response->redirect('/~installer');
 
            // Prevent action and after() from firing
            $this->execute=false;
            return;
        }
        
        // Grab the application configuration
        $this->appTitle = Config::get('application.name', 'Wiki Title');
        
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
        // Fixup the layout css
        $this->view->cssLayout .= '.css';
        
        // Update the title
        $this->view->browserTitle = $this->appTitle . ': ' . $this->view->pageTitle;
        
        //We will find the file path to the view that will 
        //be specified as $subview by the actual controller
        $this->view->pageView = Misc::find_file('views', $this->pageView);
        $this->view->attributeView = Misc::find_file('views', $this->attributeView);
 
        //And now to render the main view
        $this->response->body = $this->view->render();
    }
}
