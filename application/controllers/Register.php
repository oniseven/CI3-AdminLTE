<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
  public function index()
  {
    $this->template
      ->page_type('blank')
      ->page_title('Register Page')
      ->tag_class('body', 'hold-transition register-page')
      ->load('register');
  }
}
