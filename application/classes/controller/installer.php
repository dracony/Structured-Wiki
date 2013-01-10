<?php
class Installer_Controller extends Wizard {

	public function action_index(){
		$this->subview = 'start';
		$this->view->title = 'Welcome';

        // Buttons
		$this->urlNext = 'database';
    }
    

	public function action_database(){
		$this->subview = 'database';
		$this->view->title = 'Database Configuration';

        // Buttons
		$this->view->btnBack = true;
		$this->urlBack = '';
		$this->urlNext = 'application';
		
		// Set the current values
		$this->view->dbServer = Config::get('database.default.host', 'localhost');
		$this->view->dbName = Config::get('database.default.db', 'wiki');
		$this->view->dbUser = Config::get('database.default.user', 'root');
		$this->view->dbPass = Config::get('database.default.password', '');
	}
    

	public function action_application(){
		$this->subview = 'application';
		$this->view->title = 'Application Configuration';

        // Buttons
		$this->view->btnBack = true;
		$this->urlBack = 'database';
		$this->view->btnNext = false;
		$this->view->btnFinished = true;
	}
    

	public function action_save(){
		$this->subview = 'finish';
		$this->view->title = 'Thank You';
		$this->view->btnNext = false;

        // Save everything to the config
        Config::save();
	}
}

?>
