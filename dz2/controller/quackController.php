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
		session_start();

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

	public function postsWhereMyUsernameAppears(){
		echo 'postsWhereMyUsernameAppears';
	}

	public function search(){
		echo 'search';
	}
}; 

?>
