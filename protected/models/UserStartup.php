<?php

/**
 * This is the model class for table "user_startup".
 *
 * The followings are the available columns in table 'user_startup':
 * @property string $user_id
 * @property string $startup_id
 * @property string $position
 * @property string $title
 * @property integer $current_position
 * @property integer $profile
 */
class UserStartup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_startup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, startup_id, position', 'required'),
			array('current_position, profile, approved', 'numerical', 'integerOnly'=>true),
			array('user_id, startup_id', 'length', 'max'=>20),
			array('position', 'length', 'max'=>45),
			array('title', 'length', 'max'=>100),
            array('title', 'safe'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, startup_id, position, title, current_position, profile, order, approved', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'startup_id' => 'Startup',
			'position' => 'Position',
			'title' => 'Title',
			'current_position' => 'Current Position',
			'profile' => 'Profile',
            'approved' => 'Approved',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('startup_id',$this->startup_id,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('current_position',$this->current_position);
		$criteria->compare('profile',$this->profile);
        $criteria->compare('approved',$this->approved);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserStartup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
