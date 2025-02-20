<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralService {
  protected $ci;

  public function __construct() {
    // Get CodeIgniter instance
    $this->ci =& get_instance();

    // Load necessary models/library/helper
    
  }

  public function input_id_validation($field = 'id', $message = '%s tidak boleh kosong'): array {
    $this->ci->load->library('form_validation');

    $this->ci->form_validation->set_rules($field, 'ID', 'required|integer', [
      'required' => $message
    ]);

    if($this->ci->form_validation->run() == FALSE){
      return [false, validation_errors()];
    }

    return [true, null];
  }
}