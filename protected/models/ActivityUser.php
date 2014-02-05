<?php


class ActivityUser extends CActiveRecord
{
	const FOLLOW_USER = 1;
	const FOLLOW_STARTUP = 2;
    const FOUNDED_STARTUP = 3;
    const IS_IN_STARTUP = 4;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'activity_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type, target_id', 'required'),
			array('user_id, type, target_id', 'numerical', 'integerOnly'=>true),
			array('user_id, target_id', 'length', 'max'=>20),
			array('time', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type, target_id, time', 'safe', 'on'=>'search'),
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
			'type' => 'Activity Type',
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
		$criteria->compare('type',$this->type);
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
	 * @return ActivityStartup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function saveFollow()
    {
        $sql = "SELECT id FROM activity_user WHERE user_id=:uId AND target_id=:tId";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":uId", $this->user_id, PDO::PARAM_INT);
        $command->bindValue(":tId", $this->target_id, PDO::PARAM_INT);
        if($command->execute()!==1) $this->save(); 
    }
}
