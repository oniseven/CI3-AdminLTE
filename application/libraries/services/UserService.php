<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserService {
  protected $ci;

  public function __construct() {
    // Get CodeIgniter instance
    $this->ci =& get_instance();

    // Load necessary models/library/helper
    $this->ci->load->model('users');
  }
}