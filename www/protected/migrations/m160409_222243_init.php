<?php

class m160409_222243_init extends CDbMigration
{
	public function safeUp()
	{
        set_time_limit(0);
        ignore_user_abort(true);
		$this->execute(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'db.sql'));
	}

	public function safeDown()
	{
		return false;
	}
}