<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_menu_privileges_table extends CI_Migration {

  private $tableName = "menu_privileges";

  public function up() {
    // Define the table
    $this->dbforge->add_field(array(
      'id' => [
        'type' => 'BIGINT',
        'constraint' => 20,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'privilege_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
      ],
      'menu_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
      ],
      'is_selected' => [
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
      ]
    ));

    // Define the primary key
    $this->dbforge->add_key('id', TRUE);

    // Create the table
    $this->dbforge->create_table($this->tableName);

    $this->db->query('ALTER TABLE menu_privileges ADD CONSTRAINT uq_menu_privilege UNIQUE (privilege_id, menu_id), ADD CONSTRAINT fk_menu_privileges_privilege FOREIGN KEY (privilege_id) REFERENCES privileges(id) ON DELETE RESTRICT ON UPDATE CASCADE, ADD CONSTRAINT fk_menu_privileges_menu FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE RESTRICT ON UPDATE CASCADE');
  }

  public function down() {
    // Drop the foreign key constraint first
    $this->db->query('ALTER TABLE menu_privileges DROP INDEX uq_menu_privilege, DROP FOREIGN KEY fk_menu_privileges_privilege, DROP FOREIGN KEY fk_menu_privileges_menu');

    // Drop the table
    $this->dbforge->drop_table($this->tableName);
  }
}