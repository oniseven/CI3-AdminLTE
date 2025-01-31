<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dtables extends CI_Controller {
	private string $page_model = 'users';

	public function index()
	{
		$this->template
			->page_title('Datatables')
      ->plugins(['datatables'])
			->page_js('assets/dist/js/pages/datatables.js')
      ->load('tables/datatables');
	}

	public function datatable() {
		// check if its ajax request
		if(!$this->request->is_ajax())
			return show_404();

		$select = [
			'id', 
      'fullname', 
      'username', 
      'email', 
      'is_active'
		];

		$data = $this->datatables
			->select($select)
			->search_type("column")
			->show_query()
			->show_configs()
			->load($this->page_model);

		return $this->response->json($data);
	}
}
