<?php

use yii\db\Schema;

class m131225_070735_create_task_table extends \yii\db\Migration
{
	public function up()
	{
		// MySQL-specific table options. Adjust if you plan working with another DBMS
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

		$this->createTable('tbl_task', array(
			'id' => Schema::TYPE_PK,
			'author_id' => Schema::TYPE_INTEGER.' NOT NULL',
			'user_id' => Schema::TYPE_INTEGER.' NOT NULL',
			'title' => Schema::TYPE_STRING.' NOT NULL',
			'content' => 'longtext NOT NULL',
			'expiration_time' => Schema::TYPE_INTEGER.' NOT NULL',
			'status' => 'tinyint NOT NULL DEFAULT 0',
			'create_time' => Schema::TYPE_INTEGER.' NOT NULL',
			'update_time' => Schema::TYPE_INTEGER.' NOT NULL',
		), $tableOptions);

		$this->createIndex('author_id', 'tbl_task', 'author_id');
		$this->addForeignKey('FK_task_author', 'tbl_task', 'author_id', 'tbl_user', 'id', 'CASCADE', 'RESTRICT');

	}

	public function down()
	{
		$this->dropTable('tbl_task');
	}
}
