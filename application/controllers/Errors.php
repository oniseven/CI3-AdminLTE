<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function page_missing()
	{
		$this->template
      ->page_type('blank')
      ->page_title('404 Not Found')
      ->load('errors/custom/error_404');
	}
}
