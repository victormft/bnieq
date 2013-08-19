<?php

class Profile extends UActiveRecord
{
	/**
	 * The followings are the available columns in table 'profile':
	 * @var integer $id
	 * @var boolean $regMode
	 */
	public $regMode = false;
	
	private $_model;
	private $_modelReg;
	private $_rules = array();
	
	//constantes para Gender
	const GENDER_MALE="M";
	const GENDER_FEMALE="F";

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableProfiles;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname', 'required'),
			array('firstname, lastname', 'length', 'max'=>50),
			array('profile_picture, address', 'length', 'max'=>20),
			array('gender', 'length', 'max'=>1),
			array('telephone, skype', 'length', 'max'=>45),
			array('facebook, linkedin, twitter', 'length', 'max'=>150),
			array('birthday, resume, experiences, interests', 'safe'),
			array('birthday', 'date', 'format'=>'d-M-yyyy', 'message'=>"Wrong format"),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, firstname, lastname, profile_picture, birthday, gender, telephone, skype, resume, address, facebook, linkedin, twitter, experiences, interests', 'safe', 'on'=>'search'),
		);
	}	
	
	/**
	 * funções para salvar o birthday
	 */
	protected function afterFind(){
		parent::afterFind();
		$this->birthday=date('d-m-Y', strtotime(str_replace("-", "", $this->birthday)));       
	}
	protected function beforeSave(){
		if(parent::beforeSave()){
			$this->birthday=date('Y-m-d', strtotime(str_replace(",", "", $this->birthday)));
			return TRUE;
		}
		else return false;
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'user'=>array(self::HAS_ONE, 'User', 'id'),
			'address' => array(self::BELONGS_TO, 'Address', 'address'),
			'profilePicture' => array(self::BELONGS_TO, 'Image', 'profile_picture'),
		);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
			'user_id' => UserModule::t('User ID'),
			'birthday' => UserModule::t('Birthday'),
			'resume' => UserModule::t('Resume'),
		);
		$model=$this->getFields();
		
		foreach ($model as $field)
			$labels[$field->varname] = ((Yii::app()->getModule('user')->fieldsMessage)?UserModule::t($field->title,array(),Yii::app()->getModule('user')->fieldsMessage):UserModule::t($field->title));
			
		return $labels;
	}
	
	private function rangeRules($str) {
		$rules = explode(';',$str);
		for ($i=0;$i<count($rules);$i++)
			$rules[$i] = current(explode("==",$rules[$i]));
		return $rules;
	}
	
	static public function range($str,$fieldValue=NULL) {
		$rules = explode(';',$str);
		$array = array();
		for ($i=0;$i<count($rules);$i++) {
			$item = explode("==",$rules[$i]);
			if (isset($item[0])) $array[$item[0]] = ((isset($item[1]))?$item[1]:$item[0]);
		}
		if (isset($fieldValue)) 
			if (isset($array[$fieldValue])) return $array[$fieldValue]; else return '';
		else
			return $array;
	}
	
	public function widgetAttributes() {
		$data = array();
		$model=$this->getFields();
		
		foreach ($model as $field) {
			if ($field->widget) $data[$field->varname]=$field->widget;
		}
		return $data;
	}
	
	public function widgetParams($fieldName) {
		$data = array();
		$model=$this->getFields();
		
		foreach ($model as $field) {
			if ($field->widget) $data[$field->varname]=$field->widgetparams;
		}
		return $data[$fieldName];
	}
	
	public function getFields() {
		if ($this->regMode) {
			if (!$this->_modelReg)
				$this->_modelReg=ProfileField::model()->forRegistration()->findAll();
			return $this->_modelReg;
		} else {
			if (!$this->_model)
				$this->_model=ProfileField::model()->forOwner()->findAll();
			return $this->_model;
		}
	}
	
	public function getGenderOptions()
	{
		return array(
			'0'=>UserModule::t('Select gender...'),
			self::GENDER_MALE=>UserModule::t('Male'),
			self::GENDER_FEMALE=>UserModule::t('Female'),
		);
	}
	
	
	
}