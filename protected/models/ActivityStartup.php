<?php

/**
 * This is the model class for table "activity_startup".
 *
 * The followings are the available columns in table 'activity_startup':
 * @property string $id
 * @property string $user_id
 * @property string $startup_id
 * @property integer $activity_type
 * @property integer $seen
 * @property string $time
 *
 * The followings are the available model relations:
 * @property Startup $startup
 */
class ActivityStartup extends CActiveRecord
{
	const FOLLOW_STARTUP=1;
	const ADD_TRACTION=2;
	const ADD_PRESS=3;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'activity_startup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('startup_id, activity_type', 'required'),
			array('activity_type, seen', 'numerical', 'integerOnly'=>true),
			array('user_id, startup_id', 'length', 'max'=>20),
			array('time', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('seen', 'default', 'value' => 0, 'setOnEmpty' => true, 'on' => 'insert'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, startup_id, activity_type, seen, time', 'safe', 'on'=>'search'),
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
			'startup' => array(self::BELONGS_TO, 'Startup', 'startup_id'),
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
			'startup_id' => 'Startup',
			'activity_type' => 'Activity Type',
			'seen' => 'Seen',
			'time' => 'Time',
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
		$criteria->compare('startup_id',$this->startup_id,true);
		$criteria->compare('activity_type',$this->activity_type);
		$criteria->compare('seen',$this->seen);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ActivityStartup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
