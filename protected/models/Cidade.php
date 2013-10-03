<?php

/**
 * This is the model class for table "cidade".
 *
 * The followings are the available columns in table 'cidade':
 * @property integer $id
 * @property string $nome
 *
 * The followings are the available model relations:
 * @property Profile[] $profiles
 */
class Cidade extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cidade';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome', 'length', 'max'=>120),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome', 'safe', 'on'=>'search'),
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
			'profiles' => array(self::HAS_MANY, 'Profile', 'location'),
			'startups' => array(self::HAS_MANY, 'Startup', 'location'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nome' => 'Nome',
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
		$criteria->compare('nome',$this->nome,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cidade the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getCities()
    {
        //see if it is in the cache, if so, just return it
        if( ($cache=Yii::app()->cache)!==null)
        {
            $key='cidades.dessa.porra';
            if(($cities=$cache->get($key))!==false)
            return $cities;
        }
        //The system message was either not found in the cache, or
        //there is no cache component defined for the application
        //retrieve the system message from the database
        $cities = CHtml::listData(Cidade::model()->findAll(), 'id', 'nome');
        if($cities != null)
        {
            //a valid message was found. Store it in cache for future retrievals
            if(isset($key))
            $cache->set($key,$cities,1800);
            return $cities;
        }
        else
            return null;
        
    }
    
    public function suggestPerson($keyword, $limit=20)
	{
		$criteria=array(
			'condition'=>'nome LIKE :keyword',
			'order'=>'nome',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>"$keyword%"
			)
		);
		$models=$this->findAll($criteria);
		$data=array();
		foreach($models as $model) {
	    	$data[] = array(
	    		'id'=>$model->id,
	        	'text'=>$model->nome,
	        );
		}
		return $data;
	}
}
