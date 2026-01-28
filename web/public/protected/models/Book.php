<?php
use Biblys\Isbn\Isbn;
/**
 * This is the model class for table "book".
 *
 * The followings are the available columns in table 'book':
 * @property string $id
 * @property string $title
 * @property string $release_year
 * @property string $summary
 * @property string $isbn
 * @property string $photo
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property AuthorBook[] $authorBooks
 */
class Book extends CActiveRecord
{
    /**
     * @var array
     */
    public $authorIds = [];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'book';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, release_year', 'required'),
            array('title', 'length', 'max'=>256),
            array('release_year', 'length', 'max'=>4),
            array('release_year', 'numerical', 'min' => 1901, 'max' => date('Y'), 'integerOnly' => true),
            array('summary', 'length', 'max'=>2024),
            array('isbn', 'length', 'max' => 17),
            array('isbn', 'isbn', 'size' => 13),
            array('photo', 'length', 'max'=>255),
            // array(['title', 'summary', 'isbn', 'photo'], 'trim'),
            array(['title', 'summary', 'isbn', 'photo'], 'filter', 'filter' => 'trim'),
            array('authorIds', 'required'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, release_year, summary, isbn, photo', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'authorsCount' => array(self::STAT, 'author', 'author_book(author_id, book_id)', 'select' => 'COUNT(*)'),
            'authors' => array(self::MANY_MANY, 'author', 'author_book(author_id, book_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Название',
            'release_year' => 'Год выпуска',
            'summary' => 'Описание',
            'isbn' => 'Isbn',
            'photo' => 'Фото главной страницы',
            // 'created_at' => 'Created At',
            // 'updated_at' => 'Updated At',
            'authors' => 'Автор' // их может быть несколько, но чаще всего 1
        );
    }

    public function isbn($attribute, $params)
    {
        $value = $this->$attribute;
        $size = $params['size'] ?: '13';
        try {
            if ($size == '10') {
                Isbn::validateAsIsbn10($value);
            } else {
                Isbn::validateAsIsbn13($value);
            }              
        } catch(Exception $e) {
            $this->addError($attribute, "ISBN $value is invalid: " . $e->getMessage());
        }
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
        $criteria->compare('title',$this->title,true);
        $criteria->compare('release_year',$this->release_year,true);
        $criteria->compare('summary',$this->summary,true);
        $criteria->compare('isbn',$this->isbn,true);
        $criteria->compare('photo',$this->photo,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('updated_at',$this->updated_at,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Book the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    protected function afterSave()
    {
        parent::afterSave();
        // Manual handling of the associative table
        $this->updateAuthors();
    }

    private function updateAuthors()
    {
        // Удаление существующих связей
        AuthorBook::model()->deleteAll('book_id = :book_id', [':book_id' => $this->id]);
        
        if (is_array($this->authorIds)) { 
            foreach ($this->authorIds as $authorId) {
                $AuthorBook = new AuthorBook();
                $AuthorBook->book_id = $this->id;
                $AuthorBook->author_id = $authorId;
                $AuthorBook->save();
            }
        }
    }
}