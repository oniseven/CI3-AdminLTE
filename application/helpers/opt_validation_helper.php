<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('is_unique_exclude_id')) {
  function is_unique_exclude_id($value, $params) {
    $CI =& get_instance();

    list(
      $id,
      $table,
      $column
    ) = explode('.', $params);

    $CI->load->model($table, 'tb_model');
    $query = $CI->tb_model->find([
      'select' => 'id',
      'where' => [
        'id <>' => $id,
        $column => $value
      ]
    ]);

    if($query->num_rows() > 0){
      $CI->form_validation->set_message('is_unique_exclude_id', 'The {field} already exist in the specified table.');
      return FALSE;
    } else {
      return TRUE;
    }
  }
}