<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserService {
  protected $ci;

  public function __construct() {
    // Get CodeIgniter instance
    $this->ci =& get_instance();

    // Load necessary models/library/helper
    $this->ci->load->model('users');
    $this->ci->load->model('userprivilege');
  }

  public function input_validation(): array {
    $this->ci->load->library('form_validation');

    $id = $this->ci->input->post('id', TRUE);
    $username = $this->ci->input->post('username', TRUE);
    $password = $this->ci->input->post('password', TRUE);

    // is_unique_exclude_id is listed in helpers/opt_validation_helper.php
    $uniqueUsername = empty($id) ? "|is_unique[users.username]" : "|is_unique_exclude_id[{$id}.users.username]";
    $uniqueEmail = empty($id) ? "|is_unique[users.email]" : "|is_unique_exclude_id[{$id}.users.email]";
    $validPassword = '';

    if(empty($id)) {
      $validPassword = 'min_length[6]|required';
    } else if(!empty($id) && !empty($password)){
      $validPassword = 'min_length[6]';
    }

    $config = array(
      array(
        'field' => 'id',
        'label' => 'ID',
        'rules' => 'integer'
      ),
      array(
        'field' => 'fullname',
        'label' => 'Nama Lengkap',
        'rules' => 'required|alpha_numeric_spaces',
        'errors' => array(
          'required' => '%s tidak boleh kosong!',
          'alpha_numeric_spaces' => '%s harus berupa huruf, angka, dan space!',
        ),
      ),
      array(
        'field' => 'username',
        'label' => 'Username',
        'rules' => 'required|alpha_numeric_spaces'.$uniqueUsername,
        'errors' => array(
          'required' => '%s tidak boleh kosong!',
          'alpha_numeric_spaces' => '%s harus berupa huruf, angka, dan space!',
          'is_unique' => '%s harus unik tidak boleh sama dengan yang lainnya!'
        ),
      ),
      array(
        'field' => 'email',
        'label' => 'E-mail',
        'rules' => 'required|valid_email'.$uniqueEmail,
        'errors' => array(
          'required' => '%s tidak boleh kosong!',
          'valid_email' => '%s harus alamat email yang valid!',
          'is_unique' => '%s harus unik tidak boleh sama dengan yang lainnya!'
        ),
      ),
      array(
        'field' => 'password',
        'label' => 'Password',
        'rules' => $validPassword,
      ),
      array(
        'field' => 'privilege',
        'label' => 'Hak Akses',
        'rules' => 'required|integer',
        'error' => [
          'required' => '%s tidak boleh kosong'
        ]
      ),
      array(
        'field' => 'is_active',
        'label' => 'Status Aktif',
        'rules' => 'integer'
      ),
    );

    $this->ci->form_validation->set_rules($config);
    if ($this->ci->form_validation->run() == FALSE){
      return [false, validation_errors()];
    }

    return [true, null];
  }

  public function save() {
    $status = false;
		$message = "Data gagal di proses!";
		$error = null;

    $id = $this->ci->input->post('id', TRUE);
    $fullname = $this->ci->input->post('fullname', TRUE);
    $username = $this->ci->input->post('username', TRUE);
    $email = $this->ci->input->post('email', TRUE);
    $password = $this->ci->input->post('password', TRUE);
    $privilege = $this->ci->input->post('privilege', TRUE);
    $active = $this->ci->input->post('is_active', TRUE);
    $active = (empty($active) ? 0 : 1);

    $db = $this->ci->users->db_init();
    $paramData = [
			'data' => [
				'fullname' => $fullname,
				'username' => $username,
				'email' => $email,
				'is_active' => $active
			]
		];
    if(!empty($password))
      $paramData['data']['password'] = password_hash($password, PASSWORD_DEFAULT);

    // I'm not using transaction in here, but you should devinitely use transaction
    try {
      if(empty($id)){
        $id = $this->ci->users->insert($paramData, true);
      } else {
        $paramData['where'] = [ 'id' => $id ];
        $query = $this->ci->users->update($paramData);
      }
  
      // delete existing privilege of the user
      $this->ci->userprivilege->delete([
        'where' => [
          "user_id" => $id
        ]
      ]);
  
      // insert user privileges
      $query = $this->ci->userprivilege->insert([
        "data" => [
          "user_id" => $id,
          "privilege_id" => $privilege
        ]
      ]);

      $status = true;
      $message = 'Data berhasil di proses!';
    } catch (Exception $e) {
      $error = $e->getMessage();
    }

    return [$status, $message, $error];
  }

  public function delete(int $id) {
    // delete existing privilege of the user
    $this->ci->userprivilege->delete([
      'where' => [
        "user_id" => $id
      ]
    ]);

    // delete user
    $query = $this->ci->users->delete([
      'where' => [ 'id' => $id ]
    ]);

    $status = $query ? true : false;
    $textStatus = $query ? 'berhasil' : 'gagal';

    return [$status, "Data {$textStatus} di hapus!"];
  }
}