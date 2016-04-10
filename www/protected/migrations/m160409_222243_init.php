<?php

class m160409_222243_init extends CDbMigration
{
	public function safeUp()
	{
		$this->execute(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'db.sql'));
	}

	public function safeDown()
	{
		return false;
	}
}