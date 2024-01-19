<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Response
{
  /**
   * @var object  $CI             Codeigniter main object
   * @var integer $http_code      http status code
   * @var array $metadata         metadata parameter contain status & message
   */
  var $CI;
  public $http_code = 200;
  public $metadata = [];

  public function __construct()
  {
    $this->CI = &get_instance();
  }

  /**
   * Set html code to specific code
   * 
   * @param integer $status_code  html status code. default: 200
   * 
   * @return object
   */
  public function status($status_code)
  {
    $this->http_code = $status_code;

    return $this;
  }

  /**
   * Set metadata of response
   * 
   * @param boolean $status
   * @param string  $message
   * 
   * @return object
   */
  public function metadata($status = true, $message = "Sukses")
  {
    $this->metadata = [
      "status" => $status,
      "message" => $message
    ];

    return $this;
  }

  /**
   * Set html code to specific code
   * 
   * @param array|object|null $data
   * 
   * @return void
   */
  public function json($data = null)
  {
    set_status_header($this->http_code);
    $response = [];

    if(empty($this->metadata) && empty($data))
      throw new Exception("Data response json tidak boleh kosong apabila tanpa metadata");
  
    if(empty($this->metadata) && (!is_array($data) && !is_object($data)))
      throw new Exception("Data response json harus berupa array atau object");

    if(empty($this->metadata))
      $response = $data;

    if(!empty($this->metadata)){
      $response["metadata"] = $this->metadata;

      if(!empty($data))
        $response["data"] = $data;
    } 
      
    $this->CI->output->set_content_type('application/json')
      ->set_output(json_encode($response));

    // if(!is_array($response) && !is_object($response))
      //   $payload = [$response];
      // else
      //   $payload = $response;
  }

  public function not_found($is_ajax = false)
  {
    if($is_ajax)
      $this->status(404)->metadata(false, 'Not Found')->json();
    else
      show_404();
  }
}
