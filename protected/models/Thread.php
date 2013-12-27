<?php

/**
 * This is the model class for table "thread".
 *
 * The followings are the available columns in table 'thread':
 * @property string $id
 * @property string $user_id
 * @property string $replies
 * @property string $views
 * @property string $last_post
 * @property string $title
 * @property string $create_time
 */
class Thread extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'thread';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id, user_id, replies, views, title', 'required'),
			array('id, user_id', 'length', 'max'=>20),
			array('replies, views', 'length', 'max'=>10),
			array('title', 'length', 'max'=>512),
			array('last_post, create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, replies, views, last_post, title, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'replies' => 'Replies',
			'views' => 'Views',
			'last_post' => 'Last Post',
			'title' => 'Title',
			'create_time' => 'Create Time',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('replies',$this->replies,true);
		$criteria->compare('views',$this->views,true);
		$criteria->compare('last_post',$this->last_post,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Thread the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function setCreatetime($value) {
        $this->create_time=date('Y-m-d H:i:s',$value);
    }
}
