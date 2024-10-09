<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Schools extends Migration
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
			'schoolname'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
			'npsn'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
            'address' => [
				'type'           => 'TEXT',
			],
			'telp'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
			],
			'logo'      => [
				'type'           => 'TEXT',
			],
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat tabel news
		$this->forge->createTable('schools', TRUE);

    }

    public function down()
    {
        $this->forge->dropTable('schools');

    }
}
