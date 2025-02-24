<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PrivilegeService {
  protected $ci;

  public function __construct() {
    // Get CodeIgniter instance
    $this->ci =& get_instance();

    // Load necessary models/library/helper
    $this->ci->load->model('privilege');
  }

  public function input_validation($id = null): array {
    $this->ci->load->library('form_validation');
    // is_unique_exclude_id is listed in helpers/opt_validation_helper.php
    $is_unique = empty($id) ? "|is_unique[privileges.name]" : "|is_unique_exclude_id[{$id}.privilege.name]";

    $config = array(
      array(
        'field' => 'id',
        'label' => 'ID',
        'rules' => 'integer'
      ),
      array(
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'required|alpha_numeric_spaces'.$is_unique,
        'errors' => array(
          'required' => '%s tidak boleh kosong!',
          'alpha_numeric_spaces' => '%s harus berupa huruf, angka, dan space!',
          'is_unique' => '%s harus unik tidak boleh sama dengan yang lainnya!'
        ),
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

  public function has_data(int $id) {
    $this->ci->load->model([
      'userprivilege',
      'menuprivilege'
    ]);

    // check if privilege has been use in user_privileges
    $query = $this->ci->userprivilege->find_by('privilege_id', $id);
    if($query->status) {
      return [true, 'Tidak dapat dihapus dikarenakan<br>beberapa pengguna telah memiliki hak akses ini!'];
    }

    $query = $this->ci->menuprivilege->find_by('privilege_id', $id);
    if($query->status) {
      return [true, 'Tidak dapat dihapus dikarenakan<br>telah memiliki menu!'];
    }

    return [false, null];
  }

  public function save(int $id, string $name, int $is_active) {
    $status = false;
    $message = "Data gagal disimpan, silahkan coba lagi!";
    $error = null;

    $paramData = [
      'data' => [
        'name' => $name,
        'is_active' => $is_active
      ]
    ];
    if(!$id){
      $query = $this->ci->privilege->insert($paramData);
    } else {
      $paramData['where'] = ['id' => $id];
      $query = $this->ci->privilege->update($paramData);
    }

    if($query || $query->status) {
      $status = true;
      $message = "Data berhasil di simpan!";
    } {
      $error = $this->ci->db->error();
    }

    return [$status, $message, $error];
  }

  public function delete(int $id): array {
    // check if privilege is already use in other table
    list(
      $hasdata,
      $err_message
    ) = $this->has_data($id);
    if($hasdata) {
      return [false, $err_message];
    }

    // delete privilege
    $query = $this->ci->privilege->delete([
      'where' => [ 'id' => $id ]
    ]);

    $status = $query ? true : false;
    $textStatus = $query ? 'berhasil' : 'gagal';

    return [$status, "Data {$textStatus} di hapus!"];
  }

  public function save_menu(array $params){
    $this->ci->load->model('menuprivilege');
    $db = $this->ci->menuprivilege->db_init();

    $status = false;
    $message = 'Akses menu gagal disimpan';

    list(
      "data" => $data,
      "group_id" => $group_id,
      "menu_id" => $menu_id
    ) = $params;

    $db->trans_start();
    $query = $this->ci->menuprivilege->delete([
      "where" => [ "privilege_id" => $group_id ]
    ]);
    
    if(!empty($data)){
      $query = $this->ci->menuprivilege->insertbatch($data);
    }

    $db->trans_complete();
    if($db->trans_status() === FALSE){
			$db->trans_rollback();
		} else {
			$db->trans_commit();
			$status = true;
      $message = 'Akses menu berhasil disimpan';
		}
    
    return [ $status, $message ];
  }

  public function update_status(int $id, int $checked): array {
    $textStatus = $checked ? 'aktifkan' : 'non-aktifkan';
    $query = $this->ci->privilege->update([
			'data' => [
				'is_active' => $checked ?? 0
			],
			"where" => [ "id" => $id ]
		]);

    $status = $query ? true : false;
    $message = $query ? "Data berhasil di {$textStatus}" : "Data gagal di {$textStatus}!";

    return [$status, $message];
  }

  public function list(string $keyword = null) {
    $params = [
      'select' => ['id', 'name as text'],
      'where' => [
        "is_active" => 1
      ]
    ];
    if(!empty($keyword))
      $params['like'] = [['name', $keyword]];

    $query = $this->ci->privilege->find($params);

    return $query->status ? $query->result() : [];
  }
}