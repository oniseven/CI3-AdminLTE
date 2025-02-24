<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	private string $page_model = 'users';

	public function __construct() {
		parent::__construct();

		$this->load->library('services/userservice');
	}

  public function index() {
    if($this->request->is_ajax())
      return $this->response->not_found();

    return redirect('setting/privileges');
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