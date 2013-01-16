<?php
class Installer_Controller extends Wizard {
    
    // Set the base URL for the wizard
    function __construct() {
        parent::__construct();
        $this->base = 'installer';
        
        // If we are already initilized then back out to the website
        if (Config::get('application.initilized', false) === true) {
            $this->response->redirect('/');
 
            // Prevent action and after() from firing
            $this->execute=false;
            return;
        }
    }
   
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
		if (Session::get('temp.dbUser', '--__--None--__--') == '--__--None--__--') {
    		    $this->view->dbUser = Config::get('database.default.user', 'root');
		} else {
		    $this->view->dbUser = Session::get('temp.dbUser');
		}
		$this->view->dbPass = '';
	}
    

	public function action_application() {
		$this->subview = 'application';
		$this->view->title = 'Application Configuration';
		
		// Validate input
		Session::set('temp.dbServer', $this->request->post('dbServer', Session::get('temp.dbServer', '')));
		Session::set('temp.dbName', $this->request->post('dbName', Session::get('temp.dbName', '')));
		Session::set('temp.dbUser', $this->request->post('dbUser', Session::get('temp.dbUser', '')));
		Session::set('temp.dbPass', $this->request->post('dbPass', Session::get('temp.dbPass', '')));
		
	    if (Session::get('temp.dbServer', '') == '' || 
	        Session::get('temp.dbName', '') == '' || 
	        Session::get('temp.dbUser', '') == '')
	    {
            $this->response->redirect('/~installer/database');
            $this->execute=false;
            return;
	    }
	    
	    // Set the database temp config to the new information
        Config::set('database.test.host', Session::get('temp.dbServer'));
        Config::set('database.test.db', Session::get('temp.dbName'));
        Config::set('database.test.user', Session::get('temp.dbUser'));
        Config::set('database.test.password', Session::get('temp.dbPass'));
        Config::set('database.test.connection', 'mysql:host='.Session::get('temp.dbServer').';dbname='.Session::get('temp.dbName').'');

        // Test the connection
        $valid = true;

        if ($valid === true) {
            // Write it to file
            Config::set('database.test.host', '');
            Config::set('database.test.db', '');
            Config::set('database.test.user', '');
            Config::set('database.test.password', '');
            Config::set('database.test.connection', '');

            Config::set('database.default.host', Session::get('temp.dbServer'));
            Config::set('database.default.db', Session::get('temp.dbName'));
            Config::set('database.default.user', Session::get('temp.dbUser'));
            Config::set('database.default.password', Session::get('temp.dbPass'));
            Config::set('database.default.connection', 'mysql:host='.Session::get('temp.dbServer').';dbname='.Session::get('temp.dbName').'');
            Config::write('database');
        } else {
            // Couldn't connect
            $this->response->redirect('/~installer/database');
            $this->execute=false;
            return;
        }

        
		// Set the current values
		if (Session::get('temp.appName', '--__--None--__--') == '--__--None--__--') {
		    $this->view->appName = Config::get('application.name', 'Wiki');
		} else {
		    $this->view->appName = Session::get('temp.appName');
		}
		if (Session::get('temp.appEmail', '--__--None--__--') == '--__--None--__--') {
		    $this->view-> appEmail = '';
		} else {
		    $this->view->appEmail = Session::get('temp.appEmail');
		}
		if (Session::get('temp.appNickname', '--__--None--__--') == '--__--None--__--') {
		    $this->view-> appNickname = '';
		} else {
		    $this->view->appNickname = Session::get('temp.appNickname');
		}

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
        
        // Read in the application settings
        $appName = $this->request->post('appName', '');
        $appEmail = $this->request->post('appEmail', '');
        $appPass = $this->request->post('appPassword', '');
        $appNickname = $this->request->post('appNickname', '');

		Session::set('temp.appName', $appName);
		Session::set('temp.appEmail', $appEmail);
		Session::set('temp.appNickname', $appNickname);
        
	    if ($appName == '' || $appEmail == '' || $appPass == '')
	    {
            $this->response->redirect('/~installer/application');
            $this->execute=false;
            return;
	    }
	    
	    // Write config to file
        Config::set('application.name', $appName);
        Config::write('application');

        // Install the database
        $migrate = Migrate::factory('default');
        $last_version=end($migrate->versions)->name;
        $migrate->migrate_to($last_version);
        
        // Update the system table with the new database scheme version
        $system = ORM::factory('system')->where('name','db_scheme_version')->find();
        $system->name = 'db_scheme_version';
        $system->value = $migrate->current_version;
        $system->save();
        
        // Create the admin account
        $admin=ORM::factory('user');
        $admin->email = $appEmail;
        $admin->nickname = $appNickname;
        $admin->passwordHash = hash("sha512", $appPass);
        $admin->save();
        
        // Set as application initilaze
        Config::set('application.initilized', true);
        Config::write('application');
	}
}

?>
