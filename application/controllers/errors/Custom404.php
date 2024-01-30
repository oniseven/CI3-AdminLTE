<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom404 extends CI_Controller {
	public function index()
	{
		$this->template
      ->page_type('blank')
      ->page_title('404 Not Found')
      ->load('errors/custom/error_404');
	}
}
