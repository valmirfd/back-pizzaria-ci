<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableOrders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'table' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'status'       => [
                'type'       => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
            'draft'       => [
                'type'       => 'BOOLEAN',
                'default' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'default'    => null,
            ],
            'created_at'       => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null,
            ],
            'updated_at'       => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null,
            ],

        ]);

        // primary key
        $this->forge->addKey('id', true);
        $this->forge->addKey('table');


        // create table
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
