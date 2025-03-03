<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_menus_table extends CI_Migration {

  private $tableName = "menus";

  public function up() {
    // Define the table
    $this->dbforge->add_field(array(
      'id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'parent_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
        'null' => true
      ],
      'position' => [
        'type' => 'ENUM',
        'constraint' => ['left', 'top'],
        'default' => 'left'
      ],
      'name' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
      ],
      'slug' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'unique' => true,
      ],
      'link' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
      ],
      'icon' => [
        'type' => 'VARCHAR',
        'constraint' => 30,
      ],
      'is_last' => [
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
      ],
      'is_active' => [
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
      ]
    ));

    // Define the primary key
    $this->dbforge->add_key('id', TRUE);

    // Create the table
    $this->dbforge->create_table($this->tableName);

    // insert dummy menu, it would be nice if there is a seeder
    $this->db->query("insert  into `menus`(`id`,`parent_id`,`position`,`name`,`slug`,`link`,`icon`,`is_last`,`is_active`) values 
        (1,NULL,'left','Starter Page','/','/','fas fa-tachometer-alt',1,1),
        (2,NULL,'left','Tables','table','#','fas fa-table',0,1),
        (3,2,'left','Simple Table','simple_table','tables/simple','far fa-circle',1,1),
        (4,2,'left','Datatables','dtables','tables/dtables','far fa-circle',1,1),
        (5,2,'left','JqGrid','jqgrid','tables/jqgrid','far fa-circle',1,1),
        (6,NULL,'left','Level 1','level_1','#','fas fa-circle',0,1),
        (7,6,'left','Level 2','level_2','#','far fa-circle',1,1),
        (8,6,'left','Level 2','level_2_2','#','far fa-circle',0,1),
        (9,8,'left','Level 3','level_3','#','fas fa-circle',1,1),
        (10,NULL,'top','Home','home','#','far fa-circle',1,1),
        (11,NULL,'top','Contact','contact','#','far fa-circle',1,1),
        (12,NULL,'left','Extra','extra','#','far fa-plus-square',0,1),
        (13,12,'left','Login','login','login','far fa-circle',1,1),
        (14,12,'left','Register','register','register','far fa-circle',1,1),
        (15,NULL,'left','Setting','setting','#','far fa-circle',0,1),
        (16,15,'left','Privileges','privileges','setting/privileges','far fa-circle',1,1)");
  }

  public function down() {
    // Drop the table
    $this->dbforge->drop_table($this->tableName);
  }
}