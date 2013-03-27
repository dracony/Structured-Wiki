<?php
class Api_Controller extends Controller {
    public $view;
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
                break;
                
            case 'logout':
                $this->api_logout();
                break;
                
	        default:
                $this->view = View::get('api/help');
                $this->view->commands = $this->knownCommands;
                break;
	    }
	 
        //And now to render the main view
        $this->response->body = $this->view->render();
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
        
        $this->view = View::get('api/login');
        $this->view->auth = $auth;
        if ($auth === true) {
            // Setup session
            Session::set('auth', true);
            if ($user->nickname != '') {
                Session::set('username', $user->nickname);
            } else {
                Session::set('username', $user->email);
            }
	    } else {
	        // Clear session
	        Session::reset();
            Session::set('auth', false);
	    }
    }
    
    
    function api_logout() {
	        // Clear session
	        Session::reset();
            Session::set('auth', false);

            // Prevent action and after() from firing
            $this->view = View::get('api/logout');
    }
}
