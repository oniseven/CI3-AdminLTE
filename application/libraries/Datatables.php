<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  
  class Datatables {
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
    public function getSimpleSearch($columns, $search)
    {
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
     * @param array $columnsDef   ColumnsDef input
     * 
     * @return array
     */
    public function getIndividualSearch($columns, $columnsDef)
    {
      $param = [];
      foreach ($columns as $key => $column) {
        $searchAble = $column['searchable'];
        if('false' === $searchAble) continue;

        if(array_key_exists('search', $column) 
          && strlen($column['search']['value']) 
            && (int) $column['search']['value'] !== -1)
        {
          $columnDef = $columnsDef[$key];
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
              $param['where'][$columnDef['value']] = $column['search']['value'];
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
    public function getOrder($columns, $order){
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