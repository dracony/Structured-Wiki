<?php
class Article_Controller extends Page {

	public function action_view() {
		$this->subview = 'view';
		$this->view->mode = 'view';
		$this->view->title = 'Home page';
		$this->view->message = 'Have fun coding!';
	}

	public function action_edit() {
		$this->subview = 'edit';
		$this->view->mode = 'edit';
		$this->view->title = 'Home page';
		$this->view->message = 'Have fun coding!';
	}

	public function action_talk() {
		$this->subview = 'talk';
		$this->view->mode = 'talk';
		$this->view->title = 'Home page';
		$this->view->message = 'Have fun coding!';
	}
}
?>