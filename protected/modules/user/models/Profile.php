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
 * @property string $location
 * @property string $facebook
 * @property string $linkedin
 * @property string $twitter
 * @property string $experiences
 * @property string $interests
 *
 * The followings are the available model relations:
 * @property Location $city
 * @property Image $profilePicture
 */

class Profile extends CActiveRecord
{

    //search do index
    public $fullname;
    public $followers_count;
    
    //to groups in listing
	public $group;
    
    const MALE = 0;
    const FEMALE = 1;

    
    //to upload logo
	public $pic;
    
    public $regMode = false;
    

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
            //validation for pic
			array('pic', 'file', 'types'=>'jpg, png, jpeg', 'wrongType'=>' - Imagem apenas do tipo: jpg, jpeg, png', 'allowEmpty'=>true, 'maxSize' => 1024 * 1024 * 5, 'tooLarge' => ' - Imagem deve ser menor que 5MB !!!'),
			array('pic', 'length', 'max' => 255, 'tooLong' => '{attribute} is too long (max {max} chars).'),            
            
			array('firstname, lastname', 'required'),
			array('firstname, lastname', 'length', 'max'=>50),
			array('profile_picture, location', 'length', 'max'=>20),
			array('gender', 'length', 'max'=>1),
			array('skype', 'length', 'max'=>45),
            array('telephone', 'match', 'pattern'=>'/^([+]?[0-9 ]+)$/', 'message'=>'Caracteres válidos: "+" no começo (se necessário) e apenas números'),			
            array('telephone', 'length', 'min'=>10, 'max'=>30, 'tooShort'=>'Telefone muito pequeno', 'tooLong'=>'Telefone muito grande'),
            array('facebook, linkedin, twitter', 'length', 'max'=>150),
			array('birthday, resume, experiences, interests', 'safe'),
			array('birthday', 'date', 'format'=>'yyyy-mm-dd', 'message'=>"Wrong format"),
            array('birthday', 'default', 'setOnEmpty' => true, 'value' => null),
            array('facebook', 'url'),
            array('linkedin', 'url'),
            array('twitter', 'url'),
            array('gender', 'in', 'range'=>array('M','F')),
            array('gender', 'default', 'value' => null),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, firstname, lastname, profile_picture, birthday, gender, telephone, skype, resume, location, facebook, linkedin, twitter, experiences, interests', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'Cidade', 'location'),
			'logo' => array(self::BELONGS_TO, 'Image', 'profile_picture'),
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
			'firstname' => 'First name',
			'lastname' => 'Last name',
			'profile_picture' => 'Profile Picture',
			'birthday' => 'Birthday',
			'gender' => 'Gender',
			'telephone' => 'Telephone',
			'skype' => 'Skype',
			'resume' => 'Resume',
			'location' => 'Location',
			'facebook' => 'Facebook',
			'linkedin' => 'Linkedin',
			'twitter' => 'Twitter',
			'experiences' => 'Experiences',
			'interests' => 'Interests',
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
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('profile_picture',$this->profile_picture,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('skype',$this->skype,true);
		$criteria->compare('resume',$this->resume,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('facebook',$this->facebook,true);
		$criteria->compare('linkedin',$this->linkedin,true);
		$criteria->compare('twitter',$this->twitter,true);
		$criteria->compare('experiences',$this->experiences,true);
		$criteria->compare('interests',$this->interests,true);

        $criteria->compare('(SELECT COUNT(user_follow.follower_id) FROM user_follow WHERE t.user_id=user_follow.followed_id)',$this->followers_count);//making the filters work
        	       
        
        if($this->group)
		{
			if($this->group=='Mais seguidos'){
                $criteria->together=true;
                $criteria->select="t.*,(SELECT COUNT(user_follow.followed_id) FROM user_follow WHERE t.user_id=user_follow.followed_id) AS followers_count"; 
                $criteria->group='t.user_id';
                $criteria->order='followers_count DESC';
            }				
		}
        
        if($this->roles){
			$criteria->with = array('roles');
			$criteria->together = true;
			$criteria->compare('roles.role_id', $this->roles,true);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
	
	
	
}