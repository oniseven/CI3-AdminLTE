<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
  class Menus extends MY_Model {
    public $table = "menus";
    public $alias = "m";
    public $allowed_columns = [
      'id', 
      'parent_id', 
      'position', 
      'name', 
      'slug', 
      'link', 
      'icon', 
      'is_last', 
      'is_active'
    ];
  }