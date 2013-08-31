<?php

/**
 * This is the model class for table "sector".
 *
 * The followings are the available columns in table 'sector':
 * @property string $sector_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Startup[] $startups
 * @property User[] $users
 */
class Sector extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sector';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sector_id, name', 'safe', 'on'=>'search'),
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
			'startups' => array(self::MANY_MANY, 'Startup', 'startup_sector(sector_id, startup_id)'),
			'users' => array(self::MANY_MANY, 'User', 'user_sector(sector_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sector_id' => 'Sector',
			'name' => 'Name',
		);
	}
    
    /**
	 * added to handle saving MANY_TO_MANY 
	 */
    public function behaviors(){
        return array('ESaveRelatedBehavior' => array(
            'class' => 'application.components.ESaveRelatedBehavior')
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

		$criteria->compare('sector_id',$this->sector_id,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sector the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getOptionsIds($userId=NULL)
	{
		if($userId==NULL)
            $sectors=$this->findAll();
        else
            $sectors=User::model()->findByPk($userId)->sectors;
		$names = array();
		foreach($sectors as $sector)
		{
			$names[]=$sector->sector_id;
		}
		return $names;
	}
	
	public function getOptionsStartupIds($startupId=NULL)
	{
		if($startupId==NULL)
            $sectors=$this->findAll();
        else
            $sectors=Startup::model()->findByPk($startupId)->sectors;
		$names = array();
		foreach($sectors as $sector)
		{
			$names[]=$sector->sector_id;
		}
		return $names;
	}
}
