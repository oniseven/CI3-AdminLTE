<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
  class Test_crud extends MY_Model {
    public $table = "test_crud";
    public $alias = "td";
    public $allowed_columns = [
      'id', 
      'name', 
      'about', 
      'created_at',
    ];
  }