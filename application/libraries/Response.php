<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class for handling HTTP response status and metadata.
 */
class Response {
  /**
   * @var object  $CI         Codeigniter main object
   * @var integer $http_code  HTTP status code, default is 200
   * @var array   $metadata   Metadata containing status and message
   */
  var $CI;
  public $http_code = 200;
  public $metadata = [];

  /**
   * Constructor to initialize the CodeIgniter instance.
   */
  public function __construct() {
    $this->CI = &get_instance();
  }

  /**
   * Set the HTTP status code for the response.
   * 
   * @param integer $status_code The HTTP status code. Default is 200.
   * 
   * @return object Returns the current instance for method chaining.
   */
  public function status(integer $status_code) {
    $this->http_code = $status_code;

    return $this;
  }

  /**
   * Set the metadata for the response.
   * 
   * @param boolean $status   The status of the response. Default is true.
   * @param string  $message  The message to be returned in the response. Default is "Sukses".
   * 
   * @return object Returns the current instance for method chaining.
   */
  public function metadata(bool $status = true, string $message = "Sukses") {
    $this->metadata = [
      "status" => $status,
      "message" => $message
    ];

    return $this;
  }

  /**
   * Outputs a JSON response with optional metadata and data.
   * 
   * This method sets the HTTP status code, validates the response data,
   * and outputs it in JSON format. If no metadata is provided, the data 
   * must not be empty and must be either an array or an object.
   * 
   * @param array|object|null $data The data to include in the JSON response.
   *                                Can be null if metadata is provided.
   * 
   * @return void Outputs the JSON response directly to the client. Halts execution
   *              with a CodeIgniter error message if validation fails.
   */
  public function json($data = null): void {
    // Set the HTTP status code for the response
    set_status_header($this->http_code);

    // Validate the input data
    if(empty($this->metadata) && empty($data)){
      show_error("Data response json tidak boleh kosong apabila tanpa metadata");
    }
  
    if(empty($this->metadata) && (!is_array($data) && !is_object($data))){
      show_error("Data response json harus berupa array atau object");
    }

    // Prepare the response
    $response = [];
    if(empty($this->metadata)) {
      $response = $data; // No metadata, use the data directly
    } else {
      $response["metadata"] = $this->metadata;
      if(!empty($data)) {
        $response["data"] = $data;
      }
    }
      
    $this->CI->output->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  /**
   * Handles 404 Not Found responses.
   * 
   * This method handles the response for a "Not Found" situation. 
   * If the request is an AJAX request, it sends a JSON response with a 404 status.
   * Otherwise, it calls the `show_404` function to display the default 404 page.
   * 
   * @param bool $is_ajax Indicates whether the request is an AJAX request. Defaults to false.
   * 
   * @return void
   */
  public function not_found(bool $is_ajax = false) {
    if($is_ajax)
      $this->status(404)->metadata(false, 'Not Found')->json();
    else
      show_404();
  }
}
