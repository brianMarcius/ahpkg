<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bookmarks extends Migration
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
            'school_id'       => [
				'type'           => 'INT',
                'constraint'     => 5,
			],
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat tabel news
		$this->forge->createTable('bookmarks', TRUE);

    }

    public function down()
    {
        $this->forge->dropTable('bookmarks');
    }
}
