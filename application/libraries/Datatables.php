<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  
  class Datatables {
    public function getSimpleSearch($columns, $search)
    {
      $keyword = trim($search['value']);
      $param = [];
      if(!empty($keyword)){
        foreach ($columns as $key => $column) {
          if($column['searchable'] === "true"){
            // $param['likes'][] = [ $column['data'], $search['value'] ];
            $param['or_likes'][] = [
              'column' => $column['data'],
              'keyword' => $search['value'],
              'type' => 'both'
            ];
          }
        }
      }      

      return $param;
    }

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
              $param['likes'][] = [
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