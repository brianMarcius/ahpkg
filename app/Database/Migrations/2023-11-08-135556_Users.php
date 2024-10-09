<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'username'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
			'fullname'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'default'        => 'John Doe',
			],
			'email' => [
				'type'           => 'VARCHAR',
				'constraint'           => 100,
			],
            'password' => [
				'type'           => 'TEXT',
			],
            'decrypted_password' => [
				'type'           => 'TEXT',
			],
			'level'          => [
				'type'           => 'INT',
				'constraint'     => 5,
			],
			'school_id'      => [
				'type'           => 'INT',
				'constraint'     => 5,
			],
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat tabel news
		$this->forge->createTable('users', TRUE);

    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
