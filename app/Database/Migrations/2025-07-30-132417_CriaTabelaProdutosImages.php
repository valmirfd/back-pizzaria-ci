<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaProdutosImages extends Migration
{
     public function up()
    {
        $this->forge->addField([

            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'produto_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'image'       => [
                'type'       => 'VARCHAR',
                'constraint' => '240',
            ],

        ]);


        $this->forge->addKey('id', true); // primary key        

        $this->forge->addForeignKey('produto_id', 'produtos', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('produtos_images');
    }

    public function down()
    {
        $this->forge->dropTable('produtos_images');
    }
}
