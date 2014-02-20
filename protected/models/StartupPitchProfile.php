<?php

/**
 * This is the model class for table "startup_pitch_profile".
 *
 * The followings are the available columns in table 'startup_pitch_profile':
 * @property string $startup_id
 * @property string $cnpj
 * @property string $full_address
 * @property integer $complete
 *
 * The followings are the available model relations:
 * @property Startup $startup
 */
class StartupPitchProfile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'startup_pitch_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('startup_id', 'required'),
			array('complete', 'numerical', 'integerOnly'=>true),
			array('startup_id', 'length', 'max'=>20),
			array('cnpj', 'length', 'max'=>14),
			array('full_address', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('startup_id, cnpj, full_address, complete', 'safe', 'on'=>'search'),
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
			'startup_id' => 'Startup',
			'cnpj' => 'Cnpj',
			'full_address' => 'Full Address',
			'complete' => 'Complete',
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

		$criteria->compare('startup_id',$this->startup_id,true);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('full_address',$this->full_address,true);
		$criteria->compare('complete',$this->complete);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StartupPitchProfile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
