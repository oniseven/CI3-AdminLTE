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
			'u.id', 
			'fullname', 
			'username',
			'email',
      'p.name as privilege',
			'u.is_active',
      'p.id as privilege_id'
		];

    $joins = [
      [
        'user_privileges as up',
        'up.user_id = u.id',
        'inner'
      ],
      [
        'privileges as p',
        'p.id = up.privilege_id',
        'inner'
      ]
    ];

		$data = $this->datatables
			->select($select)
      ->joins($joins)
			->search_type("column")
			->load($this->page_model);

		return $this->response->json($data);
  }
}