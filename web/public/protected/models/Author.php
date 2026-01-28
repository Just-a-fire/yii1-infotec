<?php

class Author extends CActiveRecord
{
    /**
     * @var int BILLBOARD SIZE
     */
    const BILLBOARD_SIZE = 10;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'author';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('first_name', 'required'),
            array('first_name, last_name, patronymic', 'length', 'max'=>128),
            array(['first_name', 'last_name', 'patronymic'], 'filter', 'filter' => 'trim'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, first_name, last_name, patronymic, booksCount', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'booksCount' => array(self::STAT, 'book', 'author_book(author_id, book_id)', 'select' => 'COUNT(*)'),
            'books' => array(self::MANY_MANY, 'book', 'author_book(author_id, book_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'patronymic' => 'Отчество',
            'booksCount' => 'Количество книг'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('first_name',$this->first_name,true);
        $criteria->compare('last_name',$this->last_name,true);
        $criteria->compare('patronymic',$this->patronymic,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function findTopOfYear($year)
    {
        $authors = Yii::app()->db->createCommand()
            ->select('a.id, first_name, last_name, patronymic, count(b.id) AS booksCount')
            ->from('author a')
            ->join('author_book ab', 'a.id = ab.author_id')
            ->join('book b', 'b.id = ab.book_id')
            ->where('release_year = :release_year', [':release_year' => $year])
            ->group('a.id')
            ->order('booksCount DESC')
            ->limit(self::BILLBOARD_SIZE)
            ->queryAll();
        $dataProvider = new CArrayDataProvider($authors, [
            'id' => 'author',
            'sort' => [
                'attributes' => [
                    'first_name', 'last_name', 'patronymic', 'booksCount',
                ],
            ],
            // 'pagination' => ['pageSize' => 10],
        ]);
        return $dataProvider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Author the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    protected function beforeDelete()
    {
        if (!parent::beforeDelete()) return false;
        
        if ($this->hasBookRelations()) {
            throw new LogicException('Нельзя удалить автора с книгами');

        }
        return true;
    }

    private function hasBookRelations()
    {
        // Поиск связей
        $authorBooks = AuthorBook::model()->findAll('author_id = :author_id', array(':author_id' => $this->id));
        
        return count($authorBooks) > 0;
    }
}