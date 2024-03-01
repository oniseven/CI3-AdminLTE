<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Controller {
  public function __construct()
  {
    parent::__construct();

    $this->load->model('test_crud');
  }

  public function index()
  {
    $this->template
      ->page_title('CRUD Example')
      ->load('crud');
  }

  public function create()
  {
    $param = [
      'data' => [
        'name' => 'John Doe',
        'about' => 'Just human being'
      ],
      'data_false' => [
        'created_at' => 'CURRENT_TIMESTAMP()'
      ]
    ];
    
    $query = $this->test_crud->insert($param);

    var_dump($query);
  }

  public function edit()
  {
    $param = [
      'data' => [
        'name' => 'Doe John',
        'about' => 'Am I human being?'
      ],
      'where' => [
        'id' => 1
      ]
    ];

    $query = $this->test_crud->update($param);

    var_dump($query);
  }

  public function del()
  {
    $param = [
      'where' => [ 'id' => 1 ]
    ];

    $query = $this->test_crud->delete($param);

    var_dump($query);
  }

  public function get()
  {
    $this->load->model('users');
    $param = [
      'select' => ['id', 'fullname', 'username', 'email'],
      'where' => [
        'is_active' => 1
      ]
    ];

    $query = $this->users->find($param);
  
    echo "<pre>";
    print_r($query->result());
  }
}
