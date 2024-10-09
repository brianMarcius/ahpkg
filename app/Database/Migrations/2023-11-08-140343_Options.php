<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Options extends Migration
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
			'question_id'       => [
				'type'           => 'INT',
				'constraint'     => 5
			],
            'option'       => [
				'type'           => 'VARCHAR',
                'constraint'     => 255,
			],
            'score'       => [
				'type'           => 'INT',
                'constraint'     => 11,
			],

		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat tabel news
		$this->forge->createTable('options', TRUE);

    }

    public function down()
    {
        $this->forge->dropTable('options');

    }
}
