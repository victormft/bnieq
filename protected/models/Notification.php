<?php

/**
 * This is the model class for table "notification".
 *
 * The followings are the available columns in table 'notification':
 * @property string $id
 * @property string $user_id
 * @property integer $notification_type
 * @property string $source_id
 * @property string $target_id
 * @property string $time
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Notification extends CActiveRecord
{
    const FOLLOW_USER=1;
	const ASK_MEMBERSHIP_STARTUP=2;
	const ADDED_TO_STARTUP=3;
    
    
    public $unseenNotificationsCount;
    
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, notification_type, source_id', 'required'),
			array('notification_type, user_id, source_id, target_id, seen', 'numerical', 'integerOnly'=>true),
			array('user_id, source_id, target_id', 'length', 'max'=>20),
            array('time', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('seen', 'default', 'value' => 0, 'setOnEmpty' => true, 'on' => 'insert'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, notification_type, source_id, target_id, time', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'notification_type' => 'Notification Type',
			'source_id' => 'Source',
			'target_id' => 'Target',
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
		$criteria->compare('notification_type',$this->notification_type);
		$criteria->compare('source_id',$this->source_id,true);
		$criteria->compare('target_id',$this->target_id,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getCountUnreaded($userId) {
		if (!$this->unseenNotificationsCount) {
			$c = new CDbCriteria();
			$c->addCondition('t.user_id = :uId');
			$c->addCondition('t.seen = "0"');
			$c->params = array(
				'uId' => $userId,
			);
			$count = self::model()->count($c);
			$this->unseenNotificationsCount = $count;
		}

		return $this->unseenNotificationsCount;
	}
    
    public function saveFollow()
    {
        $sql = "SELECT * FROM notification WHERE user_id=:uId AND source_id=:sId";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":uId", $this->user_id, PDO::PARAM_INT);
        $command->bindValue(":sId", $this->source_id, PDO::PARAM_INT);
        if($command->execute()!==1) $this->save(); 
    }
}
