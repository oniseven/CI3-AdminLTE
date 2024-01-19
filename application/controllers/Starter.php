<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Starter extends CI_Controller {
	public function index()
	{
		$this->template
      ->page_title('Starter Page')
      ->load('starter');
	}
}
