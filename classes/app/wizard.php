<?php
namespace App;
class Wizard extends \PHPixie\Controller {
    public $view;
    public $subview;
    public $urlNext;
    public $urlBack;
    public $base = 'wizard';
    
    public function before() {
        // Set the wizard template
        $this->view = $this->pixie->view($this->base . '/template');

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
        $this->view->subview = $this->pixie->find_file('views', $this->base . '/'.$this->subview);
         
        // button links
        $this->view->btnNextUrl = '/~' . $this->base . '/' . $this->urlNext;
        if ($this->urlBack != '') {
            $this->view->btnBackUrl = '/~' . $this->base . '/' . $this->urlBack;
        } else {
            $this->view->btnBackUrl = '/~' . $this->base . '';
        }
        $this->view->btnFinishUrl = '/~' . $this->base . '/save';
        
        // And now to render the main view
        $this->response->body = $this->view->render();
    }
}