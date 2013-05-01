<?php
namespace App\Controller;
class Api extends \PHPixie\Controller {
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
                $help = $this->pixie->view('api/help');
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
        $user = $this->pixie->orm->get('user')->where('email', $username)
                                    ->where('passwordHash', hash("sha512", $password))
                                    ->find();
        if($user->loaded()) {
            $auth = true;
        }
        
        if ($auth === true) {
            // Setup session
            $this->pixie->session->set('auth', true);
			$this->pixie->session->set('username', $user->nickname?:$user->email);
	    } else {
	        // Clear session
	        $this->pixie->session->reset();
			
			//Why set auth to false in an empty session?
            $this->pixie->session->set('auth', false);
	    }
		
    }
    
    
    function api_logout() {
	        // Clear session
	        $this->pixie->session->reset();
            $this->pixie->session->set('auth', false);

            
    }
	
	function update_top_bar() {
		$bar = $this->pixie->view('pageTopBar');
		$bar->auth = $this->pixie->session->get('auth',false);
		$this->response->body=json_encode(array(
			'auth' => $this->pixie->session->get('auth', false),
			'username' => $this->pixie->session->get('username', false),
			'bar' => $bar->render()
		));
	}
}
