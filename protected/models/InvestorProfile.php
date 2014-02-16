<?php

/**
 * This is the model class for table "investor_profile".
 *
 * The followings are the available columns in table 'investor_profile':
 * @property string $user_id
 * @property string $full_name
 * @property string $cpf
 * @property string $rg
 *
 * The followings are the available model relations:
 * @property User $user
 */
class InvestorProfile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'investor_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'length', 'max'=>20),
            array('complete', 'numerical', 'integerOnly'=>true),
			array('full_name', 'length', 'max'=>150),
			array('cpf', 'length', 'max'=>14),
			array('rg', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, full_name, cpf, rg, complete', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'full_name' => 'Full Name',
			'cpf' => 'CPF',
			'rg' => 'RG',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('cpf',$this->cpf,true);
		$criteria->compare('rg',$this->rg,true);
        $criteria->compare('complete',$this->complete);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InvestorProfile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function isFilled()
    {
        return $this->full_name != '' ? true : false;
    }
    
    public function isComplete()
    {
        return $this->complete == 1 ? true : false;
    }
}
