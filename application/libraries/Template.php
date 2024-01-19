<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template
{
  /**
   * @var object        $CI                       Codeigniter main object
   * @var string        $template_view_folder     root view folder of the template
   * @var boolean       $content_toolbar          On/Off to show content_toolbar of the default template, default: true
   * @var boolean       $breadcrums               On/Off to show breadcrums of the default template, default: true
   * @var boolean       $footer                   On/Off to show footer of the default template, default: true
   * @var string        $page_title               Page title
   * @var array|string  $page_title               Custom page javascript
   * @var integer       $privilege_id             User privilege id
   * @var object        $setting                  App setting variable from App_setting library
   * @var object        $profile                  Company Profile value from App_setting library using get function with "profile" key
   * @var object        $sessions                 Contain user login sessions
   * @var array         $css                      Plugin css
   * @var array         $js                       Plugin js
   */
  var $CI;
  private $template_view_folder = 'template';
  public $content_toolbar = true;
  public $breadcrums = true;
  public $footer = true;
  public $page_title = 'Default Title';
  public $page_js = [];
  public $sessions, $privilege_id;
  public $setting, $profile;
  public $css = [];
  public $js = [];

  public function __construct() {
    $this->CI =& get_instance();
    // $this->privilege_id = $this->CI->auth->get_user_data("privilege_id");
    // $this->sessions = $this->CI->auth->get_user_data();
    // $this->setting = $this->CI->app_setting->get();
    // $this->profile = $this->setting->profile;
  }

  /**
   * Function to add page title, default: Default Title
   * 
   * @param string $title
   * 
   * @return object
   */
  public function page_title($title) {
    $this->page_title = $title;
    return $this;
  }

  /**
   * Function to add page title, default: Default Title
   * 
   * @param string|array $paths
   * 
   * @return object
   */
  public function page_js($paths) {
    if(!empty($paths)) 
      $this->page_js = !is_array($paths) ? [$paths] : $paths;

    return $this;
  }

  /**
   * Function to hide content toolbar div
   * Use it only when you use default template
   * not a print tempate
   * 
   * @return object
   */
  public function hide_content_toolbar() {
    $this->content_toolbar = false;
    return $this;
  }

  /**
   * Function to hide breadcrums
   * Use it only when you use default template
   * not a print tempate
   * 
   * @return object
   */
  public function hide_breadcrumsr() {
    $this->breadcrums = false;
    return $this;
  }

  /**
   * Function to hide footer div / section
   * Use it only when you use default template
   * not a print tempate
   */
  public function hide_footer() {
    $this->footer = false;
    return $this;
  }

  /**
   * Function to hide some section in template
   * such as content_title, breadcrums, and footer for now
   * you can add more if you want to
   * Use it only when you use default template
   * not a print tempate
   * 
   * @param string|array $indexs
   * 
   * @return object
   */
  public function hide($indexs){
    if(!is_array($indexs)){
      $this->$indexs = false;
    } else {
      foreach ($indexs as $key => $index) {
        $this->$index = false;
      }
    }

    return $this;
  }

  /**
   * Function to add some plugin css and js in header and footer
   * 
   * @param string|array $vendor
   * 
   * @return object
   */
  public function plugins($vendors){
    $this->css = $this->js = [];
    $plugins = $this->CI->config->item("plugins");
    $vendors = !is_array($vendors) ? [$vendors] : $vendors;
    foreach ($vendors as $key => $vendor) {
      if(array_key_exists($vendor, $plugins)){
        $plugin = $plugins[$vendor];
        if($plugin['css']) $this->css = array_merge($this->css, $plugin['css']);
        if($plugin['js']) $this->js = array_merge($this->js, $plugin['js']);
      }
    }

    return $this;
  }

  /**
   * Load default template
   * 
   * @param string $view  page view file
   * @param array $data   template data and settings
   * 
   * @return html
   */
  public function load($view, $data = []) {   
    $data['show'] = [
      "content-toolbar" => $this->content_toolbar,
      "breadcrums" => $this->breadcrums,
      "footer" => $this->footer
    ];
    // $data['session'] = $this->sessions;
    // $data['setting'] = $this->setting;
    // $data['profile'] = $this->profile;
    $data['page_title'] = $this->page_title;
    $data['plugin_css'] = array_unique(array_merge($this->css, ($data["plugin_css"] ?? [])));
    $data['plugin_js'] = array_unique(array_merge($this->js, ($data["plugin_js"] ?? [])));
    $data['page_css'] = array_unique($data['page_css'] ?? []);
    $data['page_js'] = array_unique($this->page_js);

    // generate top menu
    $data['top_menus'] = $this->generate_html_menu("top"); 

    // generate sidebar / left menu
    $data['left_menus'] = $this->generate_html_menu(); 
    
    $this->CI->load->view("{$this->template_view_folder}/default/header", $data);
    $this->CI->load->view("{$this->template_view_folder}/default/sidebar");
    $this->CI->load->view("{$this->template_view_folder}/default/start_content");
    $this->CI->load->view($view);
    $this->CI->load->view("{$this->template_view_folder}/default/end_content");
    $this->CI->load->view("{$this->template_view_folder}/default/control_sidebar");
    $this->CI->load->view("{$this->template_view_folder}/default/footer");
  }

  /**
   * Load template for printing
   * 
   * @param string $view  page view file
   * @param array $data   template data and settings
   * 
   * @return html
   */
  public function print($view, $data = []) {
    // $data['session'] = $this->sessions;
    // $data['setting'] = $this->setting;
    // $data['profile'] = $this->profile;
    
    $this->CI->load->view("{$this->template_view_folder}/print/header", $data);
    $this->CI->load->view($view);
    $this->CI->load->view("{$this->template_view_folder}/print/footer");
  }

  /**
   * Function to get all menu from root and children on the database base on user privilege
   * 
   * @param integer $parent_id
   * @param string  $position
   * 
   * @return array
   */
  private function get_menu($parent_id = null, $position = 'left'){
    $this->CI->load->model('menus');
    $column = ['id', 'parent_id', 'name', 'slug', 'link', 'icon', 'is_last'];
    $params = [
      'select' => $column,
      'where' => [
        'parent_id' => $parent_id,
        'is_active' => 1,
        'position' => $position
      ]
    ];
    $query = $this->CI->menus->find($params);
    if(!$query->status) return [];
    
    $data = $query->result();
    foreach ($data as $key => $row) {
      if(!$row->is_last) {
        $childs = $this->get_menu($row->id);
        $data[$key]->childs = $childs;
      }
    }

    return $data;
  }

  /**
   * Function to generate menu data to html
   * 
   * @param string $position
   * 
   * @return string
   * 
   */
  private function generate_html_menu($position = 'left'){
    $data = $this->get_menu(null, $position);

    if(empty($data)) return "";
    
    return $this->CI->load->view("{$this->template_view_folder}/default/menu_{$position}", ['menus' => $data], true);
  }
}