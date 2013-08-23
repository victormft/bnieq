<?php


/**
 * This is the model class for table "profile".
 *
 * The followings are the available columns in table 'profile':
 * @property string $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $profile_picture
 * @property string $birthday
 * @property string $gender
 * @property string $telephone
 * @property string $skype
 * @property string $resume
 * @property string $address
 * @property string $facebook
 * @property string $linkedin
 * @property string $twitter
 * @property string $experiences
 * @property string $interests
 *
 * The followings are the available model relations:
 * @property Address $address0
 * @property Image $profilePicture
 */

class Profile extends CActiveRecord
{
    
    public $regMode = false;
    
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
			array('birthday', 'date', 'format'=>'yyyy-mm-dd', 'message'=>"Wrong format"),
            array('gender', 'in', 'range'=>array('M','F')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, firstname, lastname, profile_picture, birthday, gender, telephone, skype, resume, address, facebook, linkedin, twitter, experiences, interests', 'safe', 'on'=>'search'),
		);
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
		return array(
			'user_id' => 'User',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'profile_picture' => 'Profile Picture',
			'birthday' => 'Birthday',
			'gender' => 'Gender',
			'telephone' => 'Telephone',
			'skype' => 'Skype',
			'resume' => 'Resume',
			'address' => 'Address',
			'facebook' => 'Facebook',
			'linkedin' => 'Linkedin',
			'twitter' => 'Twitter',
			'experiences' => 'Experiences',
			'interests' => 'Interests',
		);
	}
	
	public function getGenderOptions()
	{
		return array(
			''=>UserModule::t('Select gender...'),
			self::GENDER_MALE=>UserModule::t('Male'),
			self::GENDER_FEMALE=>UserModule::t('Female'),
		);
	}
    
	
	
	
}