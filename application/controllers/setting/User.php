<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	private string $page_model = 'users';

	public function __construct() {
		parent::__construct();

		$this->load->library('services/userservice');
	}

  public function index() {
    $this->response->redirect('setting/privileges');
  }

  public function save() {
    // check if its ajax request
		if(!$this->request->is_ajax()){
			return show_404();
		}

    // validate user request
    list(
      $valid,
      $err_message
    ) = $this->userservice->input_validation();
    if(!$valid) {
			return $this->response
				->metadata(false, $err_message)
				->json();	
		}

    list(
      $status,
      $message
    ) = $this->userservice->save();

    return $this->response
      ->metadata($status, $message)
      ->json();
  }

  public function datatable() {
    // check if its ajax request
		if(!$this->request->is_ajax()){
			return show_404();
		}

		$select = [
			'id', 
			'fullname', 
			'username',
			'email',
			'is_active',
		];

		$data = $this->datatables
			->select($select)
			->search_type("column")
			->load($this->page_model);

		return $this->response->json($data);
  }
}