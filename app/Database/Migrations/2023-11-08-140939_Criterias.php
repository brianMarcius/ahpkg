<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Criterias extends Migration
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
			'criteria'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 30
			],
            'notes'       => [
				'type'           => 'VARCHAR',
                'constraint'     => 255,
			],
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat tabel news
		$this->forge->createTable('criterias', TRUE);

    }

    public function down()
    {
        $this->forge->dropTable('criterias');

    }
}
