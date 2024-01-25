<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index()
	{
		$this->template
      ->page_type('blank')
      ->page_title('Login page')
      ->tag_class('body', 'hold-transition login-page')
      ->load('login');
	}
}
