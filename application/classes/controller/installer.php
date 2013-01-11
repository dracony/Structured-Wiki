<?php
class Installer_Controller extends Wizard {

	public function action_start() {
		$this->subview = 'start';
		$this->view->title = 'Welcome';

        // Buttons
		$this->urlNext = 'database';
    }
    

	public function action_database() {
		$this->subview = 'database';
		$this->view->title = 'Database Configuration';

        // Buttons
		$this->view->btnBack = true;
		$this->urlBack = '';
		$this->urlNext = 'application';
		
		// Set the current values
		if (Session::get('temp.dbServer', '--__--None--__--') == '--__--None--__--') {
		    $this->view->dbServer = Config::get('database.default.host', 'localhost');
		} else {
		    $this->view->dbServer = Session::get('temp.dbServer');
		}
		if (Session::get('temp.dbName', '--__--None--__--') == '--__--None--__--') {
		    $this->view->dbName = Config::get('database.default.db', 'localhost');
		} else {
		    $this->view->dbName = Session::get('temp.dbName');
		}
		$this->view->dbUser = Config::get('database.default.user', 'root');
		$this->view->dbPass = '';
	}
    

	public function action_application() {
		$this->subview = 'application';
		$this->view->title = 'Application Configuration';
		
		// Validate input
		Session::set('temp.dbServer', $this->request->post('dbServer', ''));
		Session::set('temp.dbName', $this->request->post('dbName', ''));
		Session::set('temp.dbUser', $this->request->post('dbUser', ''));
		Session::set('temp.dbPass', $this->request->post('dbPass', ''));
		
	    if (Session::get('temp.dbServer', '') == '' || 
	        Session::get('temp.dbName', '') == '' || 
	        Session::get('temp.dbUser', '') == '')
	    {
            $this->response->redirect('/installer/database');
            $this->execute=false;
            return;
	    }
	    
	    // Set the config to the new information
        Config::set('database.default.host', Session::get('temp.dbServer'));
        Config::set('database.default.db', Session::get('temp.dbName'));
        Config::set('database.default.user', Session::get('temp.dbUser'));
        Config::set('database.default.password', Session::get('temp.dbPass'));
        Config::set('database.default.connection', 'mysql:host='.Session::get('temp.dbServer').';dbname='.Session::get('temp.dbName').'');
        Config::write('database');
        
        // Buttons
		$this->view->btnBack = true;
		$this->urlBack = 'database';
		$this->view->btnNext = false;
		$this->view->btnFinished = true;
	}
    

	public function action_save() {
		$this->subview = 'finish';
		$this->view->title = 'Thank You';
		$this->view->btnNext = false;
        $this->view->btnReturn = true;
        
        // Set as application initilaze
        Config::set('application.initilized', true);

        // Save everything to the config
        Config::write('application');
	}
}

?>
