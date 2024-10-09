<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Evaluations extends Migration
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
			'user_id'       => [
				'type'           => 'INT',
				'constraint'     => 5
			],
            'date'       => [
				'type'           => 'DATETIME',
			],
            'score'       => [
				'type'           => 'INT',
                'constraint'     => 11,
			],
            'link_drive'       => [
				'type'           => 'TEXT',
			],


		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat tabel news
		$this->forge->createTable('evaluations', TRUE);

    }

    public function down()
    {
        $this->forge->dropTable('evaluations');

    }
}
