<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class for handling HTTP requests and related operations.
 */
class Request {
  /**
   * @var object $CI CodeIgniter main object for accessing CI services.
   */
  var $CI;

  /**
   * @var string $method The HTTP request method (e.g., GET, POST, etc.).
   */
  protected $method;

  /**
   * Constructor to initialize the CodeIgniter instance and the request method.
   */
  public function __construct() {
    $this->CI = &get_instance();
    $this->method = $this->CI->input->method(TRUE);
  }

  /**
   * Check if the HTTP method matches the given one.
   *
   * @param string $compare The HTTP method to compare with (e.g., 'GET', 'POST').
   * 
   * @return boolean Returns true if the request method matches, false otherwise.
   */
  public function method_is(string $compare)
  {
    return $compare === $this->method;
  }

  /**
   * Check if the request is an AJAX request.
   * 
   * @return boolean Returns true if the request is an AJAX request, false otherwise.
   */
  public function is_ajax() {
    return $this->CI->input->is_ajax_request();
  }

  /**
   * Get the JSON input data as an associative array.
   * 
   * @param boolean $array Whether to return the decoded data as an associative array (default is false).
   * 
   * @return array|false The decoded JSON data as an associative array, or false if the request is not AJAX or if JSON decoding fails.
   */
  public function get_json(bool $array = false) {
    // Check if the request is an AJAX request
    if ($this->CI->input->is_ajax_request()) {
      // Read the raw input stream
      $json = $this->CI->input->raw_input_stream;
      
      // Decode the JSON data
      $data = json_decode($json, $array); // Decode as associative array or not

      // Check if the JSON decoding was successful
      if (json_last_error() === JSON_ERROR_NONE) {
        return $data;
      }
    }
    
    // Return false if the request is not AJAX or JSON is invalid
    return false;
  }
}