<?php

use yii\db\Migration;

class m170203_160000_clients extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(255)->notNull(),
            'status' => $this->integer(),
            'register_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%clients}}');
    }

}
