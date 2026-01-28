<?php
Yii::import('application.traits.MigrationTrait');

class m260128_002635_insert_new_authors extends CDbMigration
{
	use MigrationTrait;

	const TABLE_NAME = 'author';

	public function safeUp()
	{
		$nameFields = ['first_name', 'patronymic', 'last_name'];

		$fullNames = $this->getFullNames();

		$tableRows = array_map(function ($item) use ($nameFields) {
			return array_combine($nameFields, explode(' ', $item));
		}, $fullNames);

		$this->insertMultiple(self::TABLE_NAME, $tableRows);
	}

	public function safeDown()
	{
		$fullNames = $this->getFullNames();

		foreach ($fullNames as $fullName) {
			[$firstName, $patronymic, $lastName] = explode(' ', $fullName);
			$this->delete(
				self::TABLE_NAME,
				'first_name = :first_name AND patronymic = :patronymic AND last_name = :last_name',
				[':first_name' => $firstName, ':patronymic' => $patronymic, ':last_name' => $lastName]
			);
		}

		$this->restoreAutoincrement(self::TABLE_NAME, count($fullNames));
	}

	private function getFullNames(): array
	{
		return [
			'Александр Николаевич Островский',
			'Борис Леонидович Пастернак',
			'Иван Александрович Гончаров',
			'Михаил Александрович Шолохов',
			'Михаил Евграфович Салтыков-Щедрин',
			'Николай Михайлович Карамзин',
			'Николай Семёнович Лесков',
			'Павел Петрович Бажов'
		];		
	}
	
}