<?php

class m260125_121239_new_users_table extends CDbMigration
{
	const TABLE_NAME = 'user';

	const ROWS_COUNT = 10;

	public function safeUp()
	{
		$this->createTable(self::TABLE_NAME, [
			'id' => 'pk',
			'username' => 'string not null',
			'encrypted_pass' => 'string not null',
			'email' => 'string not null',
		], 'engine = innodb character set = utf8');

		$tableRows = array_map(
			fn($i) => [
				'id' => $i,
				'username' => "test$i",
				'encrypted_pass' => CPasswordHelper::hashPassword("pass$i"),
				'email' => "test$i@example.com"
			],
			range(1, self::ROWS_COUNT)
		);
		$this->insertMultiple(self::TABLE_NAME, $tableRows);
	}

	public function safeDown()
	{
		$this->delete(self::TABLE_NAME, 'id BETWEEN 1 AND :ROWS_COUNT', [':ROWS_COUNT' => self::ROWS_COUNT]);

		$this->dropTable(self::TABLE_NAME);
	}
}