<?php

/**
 * This is the model class for table "message_conversation".
 *
 * The followings are the available columns in table 'message_conversation':
 * @property integer $id
 * @property integer $initiator_id
 * @property integer $interlocutor_id
 * @property string $deleted_by
 *
 * The followings are the available model relations:
 * @property Message[] $messages
 */
class Conversation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'message_conversation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('initiator_id, interlocutor_id', 'required'),
			array('initiator_id, interlocutor_id', 'numerical', 'integerOnly'=>true),
			array('deleted_by', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, initiator_id, interlocutor_id, deleted_by', 'safe', 'on'=>'search'),
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
			'messages' => array(self::HAS_MANY, 'Message', 'conversation_id'),
            'initiator' => array(self::BELONGS_TO, 'User', 'initiator_id'),
			'interlocutor' => array(self::BELONGS_TO, 'User', 'interlocutor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'initiator_id' => 'Initiator',
			'interlocutor_id' => 'Interlocutor',
			'deleted_by' => 'Deleted By',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('initiator_id',$this->initiator_id);
		$criteria->compare('interlocutor_id',$this->interlocutor_id);
		$criteria->compare('deleted_by',$this->deleted_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Conversation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
