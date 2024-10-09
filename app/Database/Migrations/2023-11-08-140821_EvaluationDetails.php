<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EvaluationDetails extends Migration
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
			'evaluation_id'       => [
				'type'           => 'INT',
				'constraint'     => 5
			],
            'question_id'       => [
				'type'           => 'INT',
				'constraint'     => 5
			],
            'option_id'       => [
				'type'           => 'INT',
				'constraint'     => 5
			],            
            'score'       => [
				'type'           => 'INT',
                'constraint'     => 11,
			],


		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat tabel news
		$this->forge->createTable('evaluation_details', TRUE);


    }

    public function down()
    {
        $this->forge->dropTable('evaluation_details');

    }
}
