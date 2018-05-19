<?php 

class QuackController extends BaseController
{
	public function index() 
	{
		// Samo preusmjeri na users podstranicu.
		header( 'Location: ' . __SITE_URL . '/index.php?rt=users' );
	}

	//TODO update controllers, these are only placeholders.
	public function myQuacks(){
		$qs = new QuackService();

		$this->registry->template->title = 'My Quacks';
		$this->registry->template->quackList = $qs->getMyQuacks();

		$this->registry->template->show( 'quacks_index' );
	}

	public function quacksFromFollowees(){
		echo 'quacksFromFollowees';
	}

	public function followers(){
		echo 'followers';
	}

	public function postsWhereMyUsernameAppears(){
		echo 'postsWhereMyUsernameAppears';
	}

	public function search(){
		echo 'search';
	}
}; 

?>
