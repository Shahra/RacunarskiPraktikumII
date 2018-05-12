<?php 

class QuackController extends BaseController
{
	public function index() 
	{
		// Samo preusmjeri na users podstranicu.
		header( 'Location: ' . __SITE_URL . '/index.php?rt=users' );
	}
}; 

?>
