<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privileges extends CI_Controller {
	private string $page_model = 'privilege';

	public function __construct() {
		parent::__construct();

		$this->load->library('services/privilegeservice');
	}

	public function index() {
		$this->template
			->page_title('Setting Hak Akses')
      ->plugins(['datatables', 'jstree', 'validation'])
			->page_js('assets/dist/js/pages/setting/privileges.js')
      ->load('setting/privileges');
	}

	public function save_data() {
		// check if its ajax request
		if(!$this->request->is_ajax()){
			return show_404();
		}

		// input data
		$id = $this->input->post('id', TRUE);
		$name = $this->input->post('name', TRUE);
		$is_active = $this->input->post('is_active', TRUE);

		// input validation process
		list(
			$valid,
			$err_message
		) = $this->privilegeservice->input_validation($id);
		if(!$valid) {
			return $this->response
				->metadata(false, $err_message)
				->json();	
		}

		list(
			$status,
			$message,
			$error
		) = $this->privilegeservice->save((int) $id, $name, (int) $is_active);
		return $this->response
			->metadata($status, $message)
			->json($error);
	}

	public function delete_data() {
		// check if its ajax request
		if(!$this->request->is_ajax())
			return show_404();

		$id = $this->input->post('id', TRUE);

		// input validation
		list(
			$valid,
			$err_message
		) = $this->generalservice->input_id_validation();
		if(!$valid) {
			return $this->response
				->metadata(false, $err_message)
				->json();
		}

		list(
			$status,
			$message
		) = $this->privilegeservice->delete($id);

		return $this->response
			->metadata($status, $message)
			->json();
	}

	public function update_status()
	{
		// check if its ajax request
		if(!$this->request->is_ajax()) {
			return show_404();
		}
		
		$id = $this->input->post('id', TRUE);
		$checked = $this->input->post('checked', TRUE);

		// input validation method
		list(
			$is_pass,
			$err_message
		) = $this->generalservice->input_id_validation();
		if(!$is_pass) {
			return $this->response
				->metadata(false, $err_message)
				->json();
		}
			
		list(
			$status,
			$message
		) = $this->privilegeservice->update_status((int) $id, (int) $checked);
		return $this->response
			->metadata($status, $message)
			->json();
	}

	public function save_menu() {
		if(!$this->request->is_ajax()) {
			return show_404();
		}

		$params = $this->request->get_json(true);

		$this->load->model('lisrs/menuprivileges');
		list(
			$status,
			$error
		) = $this->privilegesservice->save_menu($params);

		return $this->response
			->metadata($status, $status ? 'Menu Berhasil Disimpan' : $error)
			->json();
	}

	public function datatable() {
		// check if its ajax request
		if(!$this->request->is_ajax()){
			return show_404();
		}

		$select = [
			'id', 
			'name', 
			'1 as menu',
			'is_active',
		];

		$data = $this->datatables
			->select($select)
			->search_type("column")
			->load($this->page_model);

		return $this->response->json($data);
	}
}