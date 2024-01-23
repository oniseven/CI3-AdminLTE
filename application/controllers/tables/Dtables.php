<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dtables extends CI_Controller {
	public function index()
	{
		$this->template
			->page_title('Datatables')
      ->plugins(['datatables'])
			->page_js('assets/dist/js/pages/datatables.js')
      ->load('tables/datatables');

		// $this->template->load();
	}

	public function datatable()
	{
		// load the main model in here
		$this->load->model('users', 'dt_model');

		/**
     * @var array  $columns
     * @var array  $columnsDef
     * @var array  $order
     * @var array  $search
     * @var integer  $start
     * @var integer  $length
     */
		$columns = $this->input->post('columns', TRUE) ?? [];
		$columnsDef = $this->input->post('columnsDef', TRUE) ?? [];
		$orders = $this->input->post('order', TRUE) ?? [];
		$search = $this->input->post('search', TRUE) ?? [];
		$start = $this->input->post('start', TRUE);
		$length = $this->input->post('length', TRUE);

		// additional filter parameter goes here


		// start init $configs
    // must have parameter, add default filter value in here too if there are any
    $where = [];
    $where_false = [];

		// set default config
		$configs = [
			'where' => $where,
			'where_false' => $where_false,
		];

		// Join/s table goes here
    // join can only be use for joining one table, as an array with parameter table, on, and type
    // joins can be use for either joining one or more table/s as an array containt join parameter as an array 
		$configs['joins'] = [];

		// get total rows on the table without any filter
    $recordsTotal = $this->dt_model->find(['count_all' => true]);

		// order
    // get order param
    $orderBy = $this->datatables->getOrder($columns, $orders);
    if($orderBy) $configs['order_by'] = implode(' ', $orderBy);

		// search
    // get the search param
		// use getSimpleSearch($columns, $search) if datatable is using a simple search
		// use getIndividualSearch($columns, $columnsDef) if datatable is using individual search column
		$searchParam = $this->datatables->getIndividualSearch($columns, $columnsDef);
		$configs = array_merge_recursive($configs, $searchParam);

		// set column and other needed state
    // $numbering_over and $numbering_row is only for mysql 8++, postgresql, and sql server,
    // it creating auto numbering base on the order
    // if you dont use them then try another approach
    // $numbering_over = ($orderBy) ? "ORDER BY {$orderBy['column']} {$orderBy['dir']}" : "";
    // $numbering_row = "ROW_NUMBER() OVER({$numbering_over}) as no ";
		$select = [
      'id', 
      'fullname', 
      'username', 
      'email', 
      'is_active'
      // $numbering_row
    ];

		// set select on condition configs
    $configs['select'] = $select;

    // get total rows with filter
    $configs['count_all_results'] = true;
    $recordsFiltered = $this->dt_model->find($configs, false);
    unset($configs['count_all_results']);

		// limit
    $configs['limit'] = ['length' => $length, 'start' => $start];

    // get all limited filtered data
    $query = $this->dt_model->find($configs, false);
    $data = $query->status && $query->num_rows() ? $query->result() : [];

		// compile select
		// just for debuging, comment this if dont want to use it
		$configs['compile_select'] = true;
		$sql = $this->dt_model->find($configs);

		$response = [
			"sql" => $sql, // comment this if not using compile select
      "recordsTotal" => $recordsTotal,
      "recordsFiltered" => $recordsFiltered,
      "data" => $data,
			"sparam" => $searchParam
    ];

		return $this->response->json($response);
	}
}
