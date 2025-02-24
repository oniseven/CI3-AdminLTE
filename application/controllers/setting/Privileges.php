<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privileges extends CI_Controller {
	private string $page_model = 'privilege';

	public function __construct() {
		parent::__construct();

		$this->load->library('services/privilegeservice');
	}

	public function index() {
		$data = [
			"group_section" => $this->load->view('setting/privileges/group_access', '',true),
			"user_section" => $this->load->view('setting/privileges/user', '',true),
		];

		$this->template
			->page_title('Setting Hak Akses')
      ->plugins([
				'datatables', 
				'jstree', 
				'select2', 
				'validation'
			])
			->page_js([
				'assets/dist/js/pages/setting/privileges.js',
				'assets/dist/js/pages/setting/user.js'
			])
      ->load('setting/privileges/main', $data);
	}

	public function menutree() {
		if(!$this->request->is_ajax()) 
			return show_404();

		$id = $this->input->post('id', TRUE);
		$id = $id === '#' ? NULL : $id;
		$group_id = (int) $this->input->post('group_id', TRUE);

		$this->load->model('menus');
		$configs = [
			'select' => 'm.*, IFNULL(mp.is_selected, 0) AS selected',
			'escape' => false,
			'where' => ['parent_id' => $id, 'is_active' => 1],
			'joins' => [
				[
					'table' => 'menu_privileges as mp',
					'on' => "mp.menu_id = m.id AND mp.privilege_id = {$group_id}",
					'type' => 'left'
				]
			],
			'order_by' => "m.parent_id ASC"
		];
		$query = $this->menus->find($configs);
		$menus = $query->status ? $query->result() : [];

		$data = [];
		foreach ($menus as $key => $menu) {
			$icon = $menu->is_last ? 'fa-file text-primary' : 'fa-folder text-warning';
			$data[$key] = [
				"id" => $menu->id,
				"text" => $menu->name,
				'icon' => "fa {$icon} icon-md",
				"state" => [
					"selected" => (int) $menu->selected ? true : false,
				],
				"children" => !(int) $menu->is_last ? true : false
			];
		}

		return $this->response->json($data);
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

	public function update_status() {
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

		$data = $this->input->post('data');
		$group_id = $this->input->post('group_id');
		$menu_id = $this->input->post('menu_id');

		$params = [
			"data" => $data,
			"group_id" => $group_id,
			"menu_id" => $menu_id
		];

		list(
			$status,
			$error
		) = $this->privilegeservice->save_menu($params);

		return $this->response
			->metadata($status, $status ? 'Menu Berhasil Disimpan' : $error)
			->json();
	}

	public function list() {
		if(!$this->request->is_ajax()){
			return show_404();
		}

		$keyword = $this->input->get('q', FALSE);
		$list = $this->privilegeservice->list($keyword);

		return $this->response
			->metadata()
			->json($list);
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