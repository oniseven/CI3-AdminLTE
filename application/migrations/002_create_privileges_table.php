<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_privileges_table extends CI_Migration {

  private $tableName = "privileges";

  public function up() {
    // Define the table
    $this->dbforge->add_field(array(
      'id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
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
  }

  public function down() {
    // Drop the table
    $this->dbforge->drop_table($this->tableName);
  }
}