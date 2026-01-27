<?php

class m260127_135507_create_subscription_table extends CDbMigration
{
	const TABLE_NAME = 'subscription';
	const RELATION_TABLE_NAME = 'author';
	public function safeUp()
	{
		$this->createTable(self::TABLE_NAME, [
			'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'phone' => "VARCHAR(20) NOT NULL COMMENT 'Телефон'",
			'name' => "VARCHAR(60) COMMENT 'Имя'",
			'author_id' => "int(11) unsigned NOT NULL COMMENT 'Автор'",
			'created_at' => 'timestamp NOT NULL DEFAULT current_timestamp()',
			'UNIQUE KEY `phone` (`phone`)'
		], 'engine = innodb character set = utf8');

		$this->addForeignKey(
			'FK_' . self::RELATION_TABLE_NAME . '_id',
			self::TABLE_NAME,
			self::RELATION_TABLE_NAME . '_id',
			self::RELATION_TABLE_NAME,
			'id',
			'CASCADE',
			'CASCADE'			
		);

		$this->insertMultiple(self::TABLE_NAME, [
			['phone' => '8(901)123-44-55', 'name' => 'Petr', 'author_id' => 1],
			['phone' => '8(964)444-11-22', 'name' => 'Ivan', 'author_id' => 1],
			['phone' => '8(987)543-00-11', 'name' => 'Alex', 'author_id' => 8],
		]);
	}

	public function safeDown()
	{
		$this->delete(self::TABLE_NAME);

		$this->dropForeignKey('FK_' . self::RELATION_TABLE_NAME . '_id', self::TABLE_NAME);

		$this->dropTable(self::TABLE_NAME);
	}
}