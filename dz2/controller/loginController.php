<?php 

class LoginController extends BaseController
{
	public function index() 
	{
		$this->registry->template->show( 'login_index' );
	}
	
	public function processLogin()
	{
		echo 'proba';
	}
}; 

?>
