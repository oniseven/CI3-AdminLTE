<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_user_privileges_table extends CI_Migration {

  private $tableName = "user_privileges";

  public function up() {
    // Define the table
    $this->dbforge->add_field(array(
      'user_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
      ],
      'privilege_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
      ],
    ));

    // Define the primary key
    $this->dbforge->add_key('user_id', TRUE);
    $this->dbforge->add_key('privilege_id', TRUE);

    // Create the table
    $this->dbforge->create_table($this->tableName);

    // Add foreign key constraint
    $this->db->query('ALTER TABLE user_privileges ADD CONSTRAINT fk_user_privileges_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE, ADD CONSTRAINT fk_user_privileges_privilege FOREIGN KEY (privilege_id) REFERENCES privileges(id) ON DELETE RESTRICT ON UPDATE CASCADE');
  }

  public function down() {
    // Drop the foreign key constraint first
    $this->db->query('ALTER TABLE user_privileges DROP FOREIGN KEY fk_user_privileges_user, DROP FOREIGN KEY fk_user_privileges_privilege');

    // Drop the table
    $this->dbforge->drop_table($this->tableName);
  }
}