<?php

class Subscription extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'subscription';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['phone, author_id', 'required'],
            ['phone', 'length', 'max' => 20],
            ['name', 'length', 'max' => 60],
            ['author_id', 'numerical', 'integerOnly' => true]
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'author' => array(self::BELONGS_TO, 'author', 'author_id'),
        ];
    }

    static public function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}