<?php
class Page extends Controller {
    public $view;
    public $pageView;
    public $attributeView;
    
    public $appTitle;
    
    public function before() {
        //This will be our global view
        $this->view = View::get('template');
        
        // Make sure the application has been configured
        if (Config::get('application.initilized', false) === false) {
            $this->response->redirect('/installer');
 
            // Prevent action and after() from firing
            $this->execute=false;
            return;
        }
        
        // Grab the application configuration
        $this->appTitle = Config::get('application.title', 'Wiki Title');
        
        // Set the page defaults
        $this->view->canEdit = true;
        $this->view->canTalk = true;
        $this->view->mode = 'view';
        $this->view->id = $this->request->param('id', 'Welcome');
        $this->view->pageImage = '/defaultPageImage.jpg';
        
        // Setup the default layout
        $this->view->cssLayout = "layoutLeft";
        // $this->view->cssLayout = "layoutRight";
    }
 
 
    //This will execute after an action is completed
    public function after() {
        // Fixup the layout css
        $this->view->cssLayout .= '.css';
        
        // Update the title
        $this->view->title = $this->appTitle . ': ' . $this->view->title;
        
        //We will find the file path to the view that will 
        //be specified as $subview by the actual controller
        $this->view->pageView = Misc::find_file('views', $this->pageView);
        $this->view->attributeView = Misc::find_file('views', $this->attributeView);
 
        //And now to render the main view
        $this->response->body = $this->view->render();
    }
}
