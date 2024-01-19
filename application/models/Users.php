<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
  class Users extends MY_Model {
    public $table = "users";
    public $alias = "u";
    public $allowed_columns = [
      'id', 
      'fullname', 
      'username', 
      'password',
      'email', 
      'is_active'
    ];
  }