<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privileges extends CI_Controller {
	private string $page_model = 'privilege';

	public function index() {
		$this->template
			->page_title('Setting Hak Akses')
      ->plugins(['datatables', 'jstree', 'validation'])
			->page_js('assets/dist/js/pages/setting/privileges.js')
      ->load('setting/privileges');
	}

	public function datatable() {
		// check if its ajax request
		if(!$this->request->is_ajax())
			return show_404();

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