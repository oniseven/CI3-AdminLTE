<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth {
  var $CI;
  var $session_key;

  public function __construct() {
    $this->CI = &get_instance();
    $this->session_key = $_ENV["SESSION_LOGIN_KEY"];
    $this->CI->load->model('users');
  }

  /**
   * Function to set user loggin session
   * 
   * @param array $userData
   * 
   * @return void
   */
  public function login($user_data, $module = "") {
    if(empty($user_data))
      throw new Exception("User data tidak boleh kosong");

    $this->CI->users->update([
      'data_false' => [
        'last_login' =>  'NOW()'
      ],
      'where' => [
        'id' => $user_data['id']
      ]
    ]);

    $this->CI->session->set_userdata($this->session_key, $user_data);
  }

  /**
   * Function to check if session is exist or not
   * 
   * @return boolean
   */
  public function is_login($module = "") {
    return $this->CI->session->has_userdata($this->session_key);
  }

  /**
   * Function to get all / specific user session data base on index that have been provide
   * 
   * @param string $index
   * 
   * @return array|string|null
   */
  public function get_user_data($index = "all", $module = "") {
    $sessions = $this->CI->session->userdata($this->session_key);

    if($index == "all")
      return $sessions;
    
    return $sessions[$index] ?? null;
  }

  /**
   * Function to check if user is login or not
   * 
   * @return html|void
   */
  public function login_check($module = "") {
    if (!$this->is_login($module)) {
      if ($this->CI->input->is_ajax_request()) {
        $this->CI->response
          ->status(401)
          ->metadata(false, 'Unauthorize User')
          ->json();
        exit();
      } else {
        redirect(base_url(), 'refresh');
      }
    }
  }

  /**
   * Function to check if current user privilege
   * has access to current menu
   * 
   * @param integer $menu_id
   * @param integer $module
   * 
   * @return html|void;
   */
  public function menu_privilege_check($menu_id, $module = "") {
    if(!isset($menu_id) || empty($menu_id))
      throw new Exception("ID Menu tidak boleh kosong saat pengecekan hak akses menu");
      
    $user_id = $this->get_user_data('id', $module);
    
    // load model menu
    $this->CI->load->model('lisrs/views/usermenus');
    $query = $this->CI->usermenus->find([
      'where' => [
        'id' => $menu_id,
        'user_id' => $user_id
      ]
    ]);
    
    $message = 'Anda tidak memiliki akses ke fitur/halaman ini!';
    // check if privilege id has access on the menu
    if(!$query->status && $this->CI->request->is_ajax()){
      $this->CI->response
        ->status(403)
        ->metadata(false, $message)
        ->json();
      exit();
    } else if(!$query->status) {
      echo $this->CI->load->view('errors/custom/error_403', ['error_message' => $message], true);
      exit();
    }
  }

  public function logout() {
    $this->CI->session->unset_userdata($this->session_key);
  }
}
