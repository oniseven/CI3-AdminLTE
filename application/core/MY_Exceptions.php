<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

  /**
   * 404 Error Handler
   *
   * @uses    CI_Exceptions::show_error()
   *
   * @param   string  $page       Page URI
   * @param   bool    $log_error  Whether to log the error
   * @return  void
   */
  public function show_404($page = '', $log_error = TRUE)
  {
    if(is_cli()){
      $heading = 'Not Found';
			$message = 'The controller/method pair you requested was not found.';
    } else {
      $heading = '404 Page Not Found';
			$message = 'The page you requested was not found.';
      $CI = &get_instance();
      $CI->template
        ->page_type('blank')
        ->page_title($heading)
        ->load('errors/custom/error_404');
    }

    // By default we log this, but allow a dev to skip it
    if ($log_error)
      log_message('error', $heading.': '.$page);

    if(is_cli())
      echo $this->show_error($heading, $message, 'error_404', 404);
    else
      echo $CI->output->get_output();

    exit(4);
  }
}
