<?php
class Wizard extends Controller {
    public $view;
    public $subview;
    public $urlNext;
    public $urlBack;
        
    public function before() {
        // Set the wizard template
        $this->view = View::get('installer/template');
        
        // If we are already initilized then back out to the website
        if (Config::get('application.initilized', false) === true) {
            $this->response->redirect('/');
 
            // Prevent action and after() from firing
            $this->execute=false;
            return;
        }

        // Default button states
        $this->view->btnBack = false;
        $this->view->btnNext = true;
        $this->view->btnFinished = false;
        $this->view->btnReturn = false;
    }
 
    //This will execute after an action is completed
    public function after() {
        //We will find the file path to the view that will 
        //be specified as $subview by the actual controller
        $this->view->subview = Misc::find_file('views', 'installer/'.$this->subview);
 
        // Can't continue if we can't write the config
//        if ($this->view->configWrite === false) {
//            $this->view->btnNext = false;
//        }
        
        // button links
        $this->view->btnNextUrl = '/installer/' . $this->urlNext;
        if ($this->urlBack != '') {
            $this->view->btnBackUrl = '/installer/' . $this->urlBack;
        } else {
            $this->view->btnBackUrl = '/installer';
        }
        $this->view->btnFinishUrl = '/installer/save';
        
        //And now to render the main view
        $this->response->body = $this->view->render();
    }
}