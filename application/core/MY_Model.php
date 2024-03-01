<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
  /**
   * @var string      $db_group     Contain group database that been use in config/database.php, default "default"
   * @var string|NULL $db_name      Database name, use when the table has different database name but still 
   *                                on the same group of database, default "NULL"
   * @var string      $table                          Table name
   * @var string      $alias                          Table alias name
   * @var string      $id_column_name                 Table id column name
   * @var array|NULL  $allowed_columns                Table alias name
   * @var string      $table_name                     Table name with alias
   * @var string      $id_column_name_with_alias      ID Column name with alias
   * 
   */
  public $db_group = 'default';
  public $db_name = NULL;
  public $table;
  public $alias = NULL;
  public $id_column_name = 'id';
  public $allowed_columns = NULL;
  private $table_name;
  private $id_column_name_with_alias;

  public function __construct(){
    parent::__construct();
    $this->table_name = $this->get_table_name();
    $this->id_column_name_with_alias = (!empty($alias)) ? $this->alias.'.'.$this->id_column_name : $this->id_column_name;
  }

  /**
   * Set Database Config
   * 
   * @return function
   */
  public function db_init(){
    return empty($this->db_group) 
      ? $this->db 
      : $this->load->database($this->db_group, TRUE);
  }

  /**
   * Get Table Name
   * 
   * @var boolean $with_alias     default is true, if its true, then it will return the table name with alias
   * 
   * @return string
   */
  public function get_table_name($with_alias = true){
    $table_name = (!empty($this->db_name) ? "{$this->db_name}." : "") . $this->table;

    if($with_alias && !empty($this->alias)) $table_name .= " AS {$this->alias}";

    return $table_name;
  }

  /**
   * Check if data contains non allowed columns
   * 
   * @param array $params
   * 
   * @return boolean
   */
  public function is_column_allowed($params){
    $dataKeys = array_key_exists('data', $params) ? array_keys($params['data']) : [];
    $dataFalseKeys = array_key_exists('data_false', $params) ? array_keys($params['data_false']) : [];
    $columns = array_unique(array_merge($dataKeys, $dataFalseKeys));

    return all_in_array($columns, $this->allowed_columns);
  }

  /**
   * Query SQL
   * 
   * @param string $query
   * 
   * @return object
   */
  public function query($query){
    $db = $this->db_init();

    $query = $db->query($query);
    $query->status = $query && $query->num_rows() ? true : false;

    return $query;
  }

  /**
   * Insert/Create New Data
   * 
   * @param array $params     contain data and data_false index. If you want to prevent data from being escaped, pass it to data_false index.
   * 
   * @return object
   */
  public function insert($params){
    if(!array_key_exists('data', $params) && !array_key_exists('data_false'))
      throw new Exception("There are no data to create!", 1);

    if(!empty($this->allowed_columns) && !$this->is_column_allowed($params))
      throw new Exception("Data contain not allowed columns", 1);

    $db = $this->db_init();

    if(array_key_exists('data', $params)) $db->set($params['data']);
    if(array_key_exists('data_false', $params)) 
      $db->set($params['data_false'], '', false);

    $table_name = $this->get_table_name(false);
    $query = $db->insert($table_name);

    return $query;
  }

  /**
   * Update Data
   * 
   * @param array $params
   * 
   * @return object
   */
  public function update($params){
    if(!empty($this->allowed_columns) && !$this->is_column_allowed($params))
      throw new Exception("Data contain not allowed coolumns", 1);

    $db = $this->db_init();

    if(array_key_exists('data', $params)) $db->set($params['data']);
    if(array_key_exists('data_false', $params)) 
      $db->set($params['data_false'], '', false);

    if(array_key_exists('where', $params))
      $db->where($params['where']);

    if(array_key_exists('where_false', $params))
      $db->where($params['where_false'], '', false);

    if(array_key_exists('where_in', $params)){
      $where_in = $params['where_in'];
      foreach ($where_in as $key => $data) {
        $db->where_in(
          $data[0] ?? $data['column'], 
          $data[1] ?? $data['value']
        );
      }
    }

    $query = $db->update($this->table_name);

    return $query;
  }

  /**
   * Delete Data
   * 
   * @param array $params
   * 
   * @return object
   */
  public function delete($params){
    $db = $this->db_init();

    if(array_key_exists('where', $params))
      $db->where($params['where']);

    if(array_key_exists('where_false', $params))
      $db->where($params['where_false'], '', false);

    if(array_key_exists('where_in', $params)){
      $where_in = $params['where_in'];
      foreach ($where_in as $key => $data) {
        $db->where_in(
          $data[0] ?? $data['column'], 
          $data[1] ?? $data['value']
        );
      }
    }

    $table_name = $this->get_table_name(false);
    $query = $db->delete($table_name);

    return $query;
  }

  /**
   * Get Data SQL Function
   * 
   * @param array $configs
   * @param boolean $last_query
   * 
   * @return object
   */
  public function find($configs = [], $last_query = false){
    // if(!array_key_exists('select', $configs))
    //   throw new Exception("Parameter \"select\" dibutuhkan", 1);

    if(!is_array($configs)) throw new Exception("Configs must be an array");

    // init database group
    $db = $this->db_init();

    // select??
    $select = $configs['select'] ?? $this->id_column_name_with_alias;

    // distinct??
    $distinct = $configs['distinct'] ?? FALSE;
    if($distinct) $db->distinct();
    
    // escape select??
    $escape = $configs['escape'] ?? NULL;

    // set select CI query builder
    $db->select($select, $escape);

    if(array_key_exists('join', $configs)){
      $join = $configs['join'];
      $db->join(
        $join[0] ?? $join['table'], 
        $join[1] ?? $join['on'], 
        $join[2] ?? $join['type'], 
        $join[3] ?? $join['escape'] ?? NULL
      );
    }

    if(array_key_exists('joins', $configs)){
      foreach ($configs['joins'] as $join) {
        $db->join(
          $join[0] ?? $join['table'], 
          $join[1] ?? $join['on'], 
          $join[2] ?? $join['type'], 
          $join[3] ?? $join['escape'] ?? NULL
        );
      }
    }

    if(array_key_exists('where', $configs))
      $db->where($configs['where']);
        
    if(array_key_exists('where_false', $configs))
      $db->where($configs['where_false'], '', false);

    if(array_key_exists('where_in', $configs)){
      $where_in = $configs['where_in'];
      foreach ($where_in as $key => $data) {
        $db->where_in(
          $data[0] ?? $data['column'], 
          $data[1] ?? $data['value'],
          $data[2] ?? $data['escape'] ?? NULL,
        );
      }
    }

    if(array_key_exists('where_not_in', $configs)){
      $where_not_in = $configs['where_not_in'];
      foreach ($where_not_in as $key => $data) {
        $db->where_not_in(
          $data[0] ?? $data['column'], 
          $data[1] ?? $data['value'], 
          $data[2] ?? $data['escape'] ?? NULL, 
        );
      }
    }

    if(array_key_exists('or_where', $configs))
      $db->or_where($configs['or_where']);

    if(array_key_exists('or_where_false', $configs))
      $db->or_where($configs['or_where_false'], '', FALSE);
    
    if(array_key_exists('or_where_in', $configs)){
      $or_where_in = $configs['or_where_in'];
      foreach ($or_where_in as $key => $data) {
        $db->or_where_in(
          $data[0] ?? $data['column'], 
          $data[1] ?? $data['value'], 
          $data[2] ?? $data['escape'] ?? NULL, 
        );
      }
    }

    if(array_key_exists('or_where_not_in', $configs)){
      $or_where_not_in = $configs['or_where_not_in'];
      foreach ($or_where_in as $key => $data) {
        $db->or_where_not_in(
          $data[0] ?? $data['column'], 
          $data[1] ?? $data['value'], 
          $data[2] ?? $data['escape'] ?? NULL, 
        );
      }
    }

    if(array_key_exists('group_where', $configs)){
      $groupWhere = $configs['group_where'];
      $db->group_start();
      $db->where($groupWhere['where']);
      if(array_key_exists('or_where', $groupWhere)){
        foreach ($groupWhere['or_where'] as $or_where) {
          $db->or_where($or_where);
        }
      }
      $db->group_end();
    }

    if(array_key_exists('group_wheres', $configs)){
      $groupWheres = $configs['group_wheres'];
      foreach ($groupWheres as $key => $groupWhere) {
        $db->group_start();
        $db->where($groupWhere['where']);
        if(array_key_exists('or_where', $groupWhere)){
          foreach ($groupWhere['or_where'] as $or_where) {
            $db->or_where($or_where);
          }
        }
        $db->group_end();
      }
    }

    if(array_key_exists('group_start', $configs) && $configs['group_start']){
      $db->group_start();
    }

    if(array_key_exists('group_end', $configs) && $configs['group_end']){
      $db->group_end();
    }

    if(array_key_exists('group_likes', $configs) && $configs['group_likes']){
      $group_likes = $configs['group_likes'];
      $db->group_start();
      if(array_key_exists('like', $group_likes)){
        $like = $group_likes['like'];
        $column = "lower(". $like['column'] .")";
        $db->like($column, $like['keyword'], $like['type'] ?? 'both');
      }
      if(array_key_exists('or_likes', $group_likes)){
        foreach ($group_likes['or_likes'] as $orLike) {
          $column = "lower(". $orLike['column'] .")";
          $db->or_like($column, $orLike['keyword'], $orLike['type'] ?? 'both');
        }
      }
      $db->group_end();
    }

    if(array_key_exists('like', $configs)){
      $like = $configs['like'];
      foreach ($like as $key => $data) {
        $column = $data[0] ?? $data['column'];
        $db->like(
          "lower({$column})", 
          $data[1] ?? $data['keyword'], 
          $data[2] ?? $data['type'] ?? 'both'
        );
      }
    }

    if(array_key_exists('or_like', $configs)){
      $or_like = $configs['or_like'];
      foreach ($or_like as $key => $data) {
        $db->or_like(
          $data[0] ?? $data['column'], 
          $data[1] ?? $data['keyword'], 
          $data[2] ?? $data['type'] ?? 'both'
        );
      }
    }

    if(array_key_exists('like_array', $configs))
      $db->like($configs['like_array']);

    if(array_key_exists('or_like_array', $configs))
      $db->or_like($configs['or_like_array']);

    if(array_key_exists('order_by', $configs)){
      if(!is_array($configs['order_by']))
        $db->order_by($configs['order_by']);
      else
        foreach ($configs['order_by'] as $order) {
          $db->order_by(
            $order[0] ?? $order['column'], 
            $order[1] ?? $order['dir'] ?? 'ASC'
          );
        }
    }

    if(array_key_exists('group_by', $configs))
      $db->group_by($configs['group_by']);

    if(array_key_exists('limit', $configs)){
      $limit = $configs['limit'];
      (is_array($limit))
        ? $db->limit(
          $limit[0] ?? $limit['length'], 
          $limit[1] ?? $limit['start']
        )
          : $db->limit($limit);
    }

    $table_name_as = $this->table_name;
    if(array_key_exists('table_alias', $configs) && !empty($configs['table_alias'])){
      $tmp_table_name = explode(' AS ', $this->table_name);
      $table_name_as = $tmp_table_name[0]." AS ".$configs['table_alias'];
    }

    if(array_key_exists('table', $configs) && !empty($configs['table']))
      $table_name_as = $configs['table'];

    if(array_key_exists('compile_select', $configs) && $configs['compile_select']){
      return $db->get_compiled_select($table_name_as);
    }

    if(array_key_exists('count_all_results', $configs) && $configs['count_all_results']){
      $result = $db->count_all_results($table_name_as, $configs['reset'] ?? TRUE);
    }

    if(array_key_exists('count_all', $configs) && $configs['count_all']){
      $result = $db->count_all($table_name_as);
    }

    if(!array_key_exists('count_all_results', $configs) && !array_key_exists('count_all', $configs)){
      $result = $db->get($table_name_as);
      $result->status = $result && $result->num_rows() ? true : false;
    }
      
    if($last_query)
      echo "## Start Last Query ##<br/>". $db->last_query() ."<br/>## END Last Query ##<br/>";
  
    return $result;
  }

  /**
   * Get Data SQL Function By ID
   * 
   * @param integer|string $id      ID data yang ingin di cari
   * @param string $id_column       Nama Kolom ID acuan, default "id"
   * @param string|array $select    Data akan ditampilkan berdasarkan kolom yang dipilih, default "*"
   * @param boolean|NULL $escape    default "NULL"
   * @param boolean $distinct       default "FALSE"
   * 
   * @return object
   */
  public function find_by_id(
    $value, 
    $column_name = "id", 
    $select = "*", 
    $escape = NULL, 
    $distinct = FALSE
  ) {
    $db = $this->db_init();

    if($distinct) $db->distinct();

    $query = $db->select($select, $escape)
      ->from($this->table_name)
      ->where($column_name, $value)
      ->get();
    $query->status = $query && $query->num_rows() ? true : false;
    
    return $query;
  }

  /**
   * Get Data SQL Function By specific column
   * 
   * @param integer|string $column  Kolom acuan pencarian
   * @param string $value           Parameter data yang akan dicari
   * @param string|array $select    Data akan ditampilkan berdasarkan kolom yang dipilih, default "*"
   * @param boolean|NULL $escape    default "NULL"
   * 
   * @return object
   */
  public function find_by($column_name, $value, $select = '*', $escape = NULL){
    $db = $this->db_init();

    $query = $db->select($select, $escape)
      ->from($this->table_name)
      ->where($column_name, $value)
      ->get();
    $query->status = $query && $query->num_rows() ? true : false;

    return $query;
  }

  /**
   * Function to get all data of current table
   * 
   * @param string|array $column
   * @param boolean|NULL $escape
   * 
   * @return object
   */
  public function get_all($column = "*", $escape = NULL){
    $db = $this->db_init();

    $query = $db->select($column, $escape)
      ->from($this->table_name)
      ->get();
    $query->status = $query && $query->num_rows() ? true : false;
    
    return $query;
  }
}
