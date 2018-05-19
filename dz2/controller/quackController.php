<?php 

class QuackController extends BaseController
{
	public function index() 
	{
		// Samo preusmjeri na users podstranicu.
		if(ValidationService::loggedIn()){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=quacks/myQuacks' );
		}
		else{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login/index' );
		}

	}

	//TODO update controllers, these are only placeholders.
	public function myQuacks(){
		if(ValidationService::loggedIn()){
			$qs = new QuackService();

			$this->registry->template->title = 'My Quacks';
			$this->registry->template->quackList = $qs->getMyQuacks();

			$this->registry->template->show( 'quacks_myquacks' );
		}
		else{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login/index' );
		}
	}

	public function processSubmit(){
		if(ValidationService::loggedIn()){
			$qs = new QuackService();
			if(!isset($_POST['quack']) || !preg_match('/^.{1,140}$/', $_POST['quack'])){
				header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/myQuacks' );
				exit();
			}
			else{
				$qs->submitQuack($_POST['quack']);
				header( 'Location: ' . __SITE_URL . '/index.php?rt=quack/myQuacks' );
				exit();
			}
		}
		else{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login/index' );
		}
	}

	public function quacksFromFollowees(){
		if(ValidationService::loggedIn()){
			$qs = new QuackService();

			$this->registry->template->title = 'Following';
			$this->registry->template->quackList = $qs->getQuacksFromFollowees();

			$this->registry->template->show( 'quacks_followees' );
		}
		else{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login/index' );
		}
	}

	public function updateFollowees(){
		if(ValidationService::loggedIn()) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}

			$qs = new QuackService();

			if (!isset($_POST['username']) || !preg_match('/^[a-zA-Z ,-.]+$/', $_POST['username'])) {
				header('Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
				exit();
			} else {
				if ($qs->getIdOfUser($_POST['username']) === null || $_SESSION['username'] === $_POST['username']) {
					header('Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
					exit();
				} else {
					if ($_POST['action'] === 'follow') {
						if ($qs->checkIfIFollow($_POST['username'])) {
							header('Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
							exit();
						} else {
							$qs->followUser($_POST['username']);
							header('Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
							exit();
						}
					} else if ($_POST['action'] === 'unfollow') {
						if ($qs->checkIfIFollow($_POST['username'])) {
							$qs->unfollowUser($_POST['username']);
							header('Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
							exit();
						} else {
							header('Location: ' . __SITE_URL . '/index.php?rt=quack/quacksFromFollowees');
							exit();
						}
					}
				}
			}
		}
		else{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login/index' );
		}
	}

	public function followers(){
		if(ValidationService::loggedIn()) {
			$qs = new QuackService();

			$this->registry->template->title = 'Followers';
			$this->registry->template->followers = $qs->getFollowers();

			$this->registry->template->show('quacks_followers');
		}
		else{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login/index' );
		}
	}

	public function quacksWhereMyUsernameAppears(){
		if(ValidationService::loggedIn()) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}

			$qs = new QuackService();

			$this->registry->template->title = 'Quacks @' . $_SESSION['username'];
			$this->registry->template->quackList = $qs->getQuacksWhereMyUsernameAppears();

			$this->registry->template->show('quacks_index');
		}
		else{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login/index' );
		}
	}

	public function search()
	{
		if(ValidationService::loggedIn()) {
			$this->registry->template->title = '#Search';
			$this->registry->template->show('quacks_search');
		}
		else{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login/index' );
		}
	}

	public function searchResults(){
		if(ValidationService::loggedIn()) {

			$qs = new QuackService();

			if (!isset($_POST['criteria']) || !preg_match('/^#[a-zA-Z]+$/', $_POST['criteria'])) {
				header('Location: ' . __SITE_URL . '/index.php?rt=quack/search');
				exit();
			} else {
				$this->registry->template->title = 'Search results';
				$this->registry->template->quackList = $qs->getQuacksThatContain($_POST['criteria']);

				$this->registry->template->show('quacks_index');
			}
		}
		else {
			header('Location: ' . __SITE_URL . '/index.php?rt=login/index');
		}
	}
}; 

?>
