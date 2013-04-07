<?php
class Api_Controller extends Controller {
    public $command = '';
    public $knownCommands = Array(
        'help' => 'Show this help', 
        'login' => 'Login as a user', 
        'logout' => 'Teminate a session'
    );
    
    
    function before() {
	    $this->command = strtolower($this->request->param('command', 'help'));
    }


	public function action_api() {
	    switch($this->command) {
            case 'login':
                $this->api_login();
				$this->update_top_bar();
                break;
                
            case 'logout':
                $this->api_logout();
				$this->update_top_bar();
                break;
                
	        default:
                $help = View::get('api/help');
                $help->commands = $this->knownCommands;
				$this->response->body = $help->render();
                break;
	    }
      
    }
    
    
    function api_login() {
	    $username = $this->request->post('user', '');
	    $password = $this->request->post('pass', '');
	    
	    // Authenticate the user
        $auth = false;
        $user = ORM::factory('user')->where('email', $username)
                                    ->where('passwordHash', hash("sha512", $password))
                                    ->find();
        if($user->loaded()) {
            $auth = true;
        }
        
        if ($auth === true) {
            // Setup session
            Session::set('auth', true);
			Session::set('username', $user->nickname?:$user->email);
	    } else {
	        // Clear session
	        Session::reset();
			
			//Why set auth to false in an empty session?
            Session::set('auth', false);
	    }
		
    }
    
    
    function api_logout() {
	        // Clear session
	        Session::reset();
            Session::set('auth', false);

            
    }
	
	function update_top_bar() {
		$bar = View::get('pageTopBar');
		$bar->auth = Session::get('auth',false);
		$this->response->body=json_encode(array(
			'auth' => Session::get('auth', false),
			'username' => Session::get('username', false),
			'bar' => $bar->render()
		));
	}
}
