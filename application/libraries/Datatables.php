<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  
  class Datatables {
    /**
     * Required variable
     * 
     * @var string|array  $select
     * @var boolean       $escape
     * @var array         $joins
     * @var array         $conditions
     * @var enum          $search_type    simple/individu   default simple
     * 
     */
    public $select = "*";
    public $escape = FALSE;
    public $joins = [];
    public $conditions = [];
    public $search_type = "simple";
    public $add_orders = [];
    public $show_query = false;
    public $show_configs = false;

    public function __construct() {
      $this->CI =& get_instance();
    }

    /**
     * Set the columns to select for the Datatable query.
     * 
     * This method sets the columns that will be selected in the SQL query for the Datatable, 
     * and also determines whether the query should escape values to prevent SQL injection.
     * 
     * @param string|array $columns  The column(s) to be selected, either as a string (for a single column) 
     *                               or an array (for multiple columns).
     * @param bool         $escape   Whether to escape the values in the query (default: FALSE).
     * 
     * @return $this  The current instance of the Datatables class to allow method chaining. Halts execution
     *                with a CodeIgniter error message if $columns is empty.
     * 
     * @example 
     * $this->datatables->select(["id", "name"]);
     */
    public function select($columns, $escape = FALSE) {
      if(empty($columns)){
        show_error('Datatables parameter Select tidak boleh kosong. cth<br/><code>$this->datatables->select(["id", "name"])</code>');
      }

      $this->select = $columns;
      $this->escape = $escape;
      return $this;
    }

    /**
     * Set join tables for the Datatable query
     * 
     * This method defines the tables to be joined in the Datatable query, including the type of join 
     * (e.g., INNER, LEFT) and the join conditions.
     * 
     * @param array $joins  An array of join information, where each entry is an array containing:
     *                      - Table name and alias (e.g., `"table as alias"`)
     *                      - The condition for the join (e.g., `"alias.id = table.id"`)
     *                      - The join type (e.g., `"inner"`, `"left"`).
     * 
     * @return $this The current instance of the Datatables class to allow method chaining. Halts execution
     *               with a CodeIgniter error message if $joins is empty.
     * 
     * @example for one join table
     * $this->datatables->joins([
     *  [
     *    "tb2 as tb2",
     *    "tb2.id = tb1.id"
     *    "inner"
     *  ]
     * ]);
     * 
     * @example for 2 or more join table
     * $this->datatables->joins([
     *  [
     *    "tb2 as tb2",
     *    "tb2.id = tb1.id"
     *    "inner"
     *  ],
     *  [
     *    "tb3 as tb3",
     *    "tb3.id = tb2.id"
     *    "left"
     *  ]
     * ]);
     */
    public function joins($joins) {
      if(empty($joins))
        show_error('Datatables joins table tidak boleh kosong. cth<br/>
        <code>
          $this->datatables->joins([<br/>
            &emsp;&emsp;&emsp;&emsp;[<br/>
              &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;"table as tb",<br/>
              &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;"tb.id = t.id",<br/>
              &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;"inner"<br/>
            &emsp;&emsp;&emsp;&emsp;],<br/>
            &emsp;&emsp;&emsp;&emsp;[<br/>
              &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;"table" => "table as tb",<br/>
              &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;"on" => "tb.id = t.id",<br/>
              &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;"type" => "inner"<br/>
            &emsp;&emsp;&emsp;&emsp;],<br/>
          ])<br/>
        </code>');

      $this->joins = $joins;

      return $this;
    }

    public function conditions($conditions) {
      if(empty($conditions))
        show_error('Datatables conditions tidak boleh kosong. Konsep condition sama dengan MY_Model. cth.<br/>
          <code>
          $this->datatables->conditions([<br/>
            &emsp;&emsp;&emsp;&emsp;"where" => ["id" => 1], <br/>
            &emsp;&emsp;&emsp;&emsp;"where_in" => [<br/>
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;"id" => [1, 2, 3, 4]<br>
            &emsp;&emsp;&emsp;&emsp;] <br/>
          ]);
          </code>
        ');

      $this->conditions = $conditions;

      return $this;
    }

    public function search_type($type = "simple") {
      if(!in_array($type, ['simple', 'column']))
        show_error('Datatables tipe search, harus berisi "simple" / "column"');

      $this->search_type = $type;

      return $this;
    }

    public function order_by($columns, $direction = "ASC") {
      if(!in_array($direction, ['ASC', 'DESC', 'asc', 'desc']))
      show_error('Datatables order by sort, harus berisi ASC / DESC / asc /desc');

      $this->add_orders[] = [$columns, $direction];

      return $this;
    }

    public function orders($sort_by) {
      if(!is_array($sort_by))
      show_error('Datatables orders parameter harus berupa array');

      $this->add_orders = $sort_by;

      return $this;
    }

    /**
     * Function to show sql query on the datatable response
     * 
     */
    public function show_query() {
      $this->show_query = true;

      return $this;
    }

    /**
     * Function to show MY_Model configs
     * 
     */
    public function show_configs() {
      $this->show_configs = true;

      return $this;
    }

    public function load($model, $table_alias = false) {
      // get all datatable parameter input
      $columns = $this->CI->input->post('columns', TRUE) ?? [];
      $columnDefs = $this->CI->input->post('columnDefs', TRUE) ?? [];
      $orders = $this->CI->input->post('order', TRUE) ?? [];
      $search = $this->CI->input->post('search', TRUE) ?? [];
      $start = $this->CI->input->post('start', TRUE) ?? [];
      $length = $this->CI->input->post('length', TRUE) ?? [];

      // load the datatable model
      $this->CI->load->model($model, 'model_dt');

      // set column and other needed state
      // $numbering_over and $numbering_row is only for mysql 8++, postgresql, and sql server,
      // it creating auto numbering base on the order
      // if you dont use them then try another approach
      // $numbering_over = ($orderBy) ? "ORDER BY {$orderBy['column']} {$orderBy['dir']}" : "";
      // $numbering_row = "ROW_NUMBER() OVER({$numbering_over}) as no ";
      $configs = [
        'select' => $this->select,
        'escape' => $this->escape
      ];

      // set table_alias
      if($table_alias && !empty($table_alias)) $configs['table_alias'] = $table_alias;

      // set additional condition
      if(!empty($this->conditions)) $configs = array_merge_recursive($configs, $this->conditions);

      // join can only be use for joining one table, as an array with parameter table, on, and type
      // joins can be use for either joining one or more table/s as an array containt join parameter as an array 
      if(!empty($this->joins)) $configs['joins'] = $this->joins;

      // set order by
      $orderBy = $this->getOrder($columns, $orders);
      if($orderBy) $configs['order_by'] = [$orderBy];
      
      // if there is additional order by
      if(!empty($this->add_orders)){
        foreach ($this->add_orders as $key => $order_by) {
          $configs['order_by'][] = $order_by;
        }
      }

      // get total data without filtering
      $recordsTotal = $this->CI->model_dt->find(['count_all' => true]);

      // search
      // get the search param
      // use getSimpleSearch($columns, $search) if datatable is using a simple search
      // use getIndividualSearch($columns, $columnDefs) if datatable is using individual search column
      $searchParam = 
        $this->search_type === 'simple'
          ? $this->getSimpleSearch($columns, $search)
          : $this->getIndividualSearch($columns, $columnDefs);

      if($searchParam) $configs = array_merge_recursive($configs, $searchParam);

      // get total rows with filter
      $configs['count_all_results'] = true;
      $recordsFiltered = $this->CI->model_dt->find($configs);
      unset($configs['count_all_results']);

      // limit
      if((int) $length > 0)
        $configs['limit'] = ['length' => $length, 'start' => $start];

      // get all limited filtered data
      $query = $this->CI->model_dt->find($configs);
      $data = $query->status && $query->num_rows() ? $query->result() : [];

      $response = [
        "recordsTotal" => $recordsTotal,
        "recordsFiltered" => $recordsFiltered,
        "data" => $data,
        // "sparam" => $searchParam
      ];

      if($this->show_query){
        $response["sql"] = $query->sql;
      }

      if($this->show_configs){
        $response["configs"] = $configs;
      }

      return $response;
    }

    /**
     * Function to generate simple search pattern 
     * that will be use to get some data in model 
     * using MY_Model Core
     * 
     * @param array $columns    Datatables columns input
     * @param array $search     Datatables search input
     * 
     * @return array
     */
    public function getSimpleSearch($columns, $search) {
      $keyword = trim($search['value']);
      $param = [];
      if(!empty($keyword)){
        foreach ($columns as $key => $column) {
          if($column['searchable'] === "true"){
            // $param['likes'][] = [ $column['data'], $search['value'] ];
            $param['or_like'][] = [
              'column' => $column['data'],
              'keyword' => $search['value'],
              'type' => 'both'
            ];
          }
        }
      }      

      return $param;
    }

    /**
     * Function to generate individual column search pattern 
     * that will be use to get some data in model using MY_Model Core
     * 
     * @param array $columns      Datatables columns input
     * @param array $columnDefs   ColumnDefs input
     * 
     * @return array
     */
    public function getIndividualSearch($columns, $columnDefs) {
      $param = [];
      foreach ($columns as $key => $column) {
        $searchAble = $column['searchable'];
        if('false' === $searchAble) continue;

        if(array_key_exists('search', $column) 
          && strlen($column['search']['value']) 
            && (int) $column['search']['value'] !== -1)
        {
          $columnDef = $columnDefs[$key];
          switch ($columnDef['type']) {
            case 'string':
              $param['like'][] = [
                'column' => $columnDef['value'],
								'keyword' => $column['search']['value'],
								'type' => 'both'
              ];
              break;
            
            case 'date':
              $param['where'][$columnDef['value']] = YmdDate($column['search']['value']);
              break;

            case 'enum':
            case 'num':
            case 'int':
              if($column['search']['value'] !== 'null'){
                $param['where'][$columnDef['value']] = $column['search']['value'];
              } else {
                $param['where'][$columnDef['value']." IS NULL"] = null;
              }
              break;

            default:
              $param['where'][$columnDef['value']] = $column['search']['value'];
              break;
          };
        }
      }

      return $param;
    }

    /**
     * Function to generate column order pattern 
     * that will be use to get some data in model using MY_Model Core
     * 
     * @param array $columns    Datatables columns input
     * @param array $order      Datatables order input
     * 
     * @return array
     */
    public function getOrder($columns, $order) {
      if(empty($order)) return false;
      
      $indexColumnOrder = $order[0]['column'];
      $columnOrderAble = $columns[$indexColumnOrder]['orderable'];
      $orderColumnName = $columns[$indexColumnOrder]['data'];
      $orderDirection = $order[0]['dir'];
    
      if($columnOrderAble !== "true") 
        return false;

      return [
        'column' => $orderColumnName,
        'dir' => $orderDirection
      ];
    }
  }
