<?php
class Article_Controller extends Page {

	public function action_view() {
		$this->pageView = 'pageView';
		$this->attributeView = 'attributeView';
		$this->view->mode = 'view';
		$this->view->title = 'Home page';
		$this->view->message = 'Have fun coding!';
	}

	public function action_edit() {
		$this->pageView = 'pageEdit';
		$this->attributeView = 'attributeEdit';
		$this->view->mode = 'edit';
		$this->view->title = 'Home page';
		$this->view->message = 'Have fun coding!';
	}

	public function action_talk() {
		$this->pageView = 'pageTalk';
		$this->attributeView = 'attributeTalk';
		$this->view->mode = 'talk';
		$this->view->title = 'Home page';
		$this->view->message = 'Have fun coding!';
	}
}
