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
		$qs = new QuackService();

		$this->registry->template->title = 'Following';
		$this->registry->template->quackList = $qs->getQuacksFromFollowees();

		$this->registry->template->show( 'quacks_followees' );
	}

	public function updateFollowees(){
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$qs = new QuackService();

		if( !isset( $_POST['username'] ) || !preg_match( '/^[a-zA-Z ,-.]+$/', $_POST['username'] ) )
		{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
			exit();
		}
		else {
			if($qs->getIdOfUser($_POST['username']) === null || $_SESSION['username'] === $_POST['username'])
			{
				header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
				exit();
			}
			else
			{
				if($_POST['action'] === 'follow'){
					if($qs->checkIfIFollow($_POST['username'])){
						header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
						exit();
					}
					else{
						$qs->followUser($_POST['username']);
						header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
						exit();
					}
				}
				else if($_POST['action'] === 'unfollow'){
					if($qs->checkIfIFollow( $_POST['username'])) {
						$qs->unfollowUser($_POST['username']);
						header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
						exit();
					}
					else{
						header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
						exit();
					}
				}
			}
		}
	}

	public function followers(){
		$qs = new QuackService();

		$this->registry->template->title = 'Followers';
		$this->registry->template->followers = $qs->getFollowers();

		$this->registry->template->show( 'quacks_followers' );
	}

	public function quacksWhereMyUsernameAppears(){

		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$qs = new QuackService();

		$this->registry->template->title = 'Quacks @' . $_SESSION['username'];
		$this->registry->template->quackList = $qs->getQuacksWhereMyUsernameAppears();

		$this->registry->template->show( 'quacks_index' );
	}

	public function search()
	{
		$this->registry->template->title = '#Search';
		$this->registry->template->show( 'quacks_search' );
	}

	public function searchResults(){

		$qs = new QuackService();

		if( !isset( $_POST['criteria'] ) || !preg_match( '/^#[a-zA-Z]+$/', $_POST['criteria'] ) )
		{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/search');
			exit();
		}
		else{
			$this->registry->template->title = 'Search results';
			$this->registry->template->quackList = $qs->getQuacksThatContain($_POST['criteria']);

			$this->registry->template->show( 'quacks_index' );
		}
	}
}; 

?>
