<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;
	
	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;
	    
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
	 */
    
    public $_roles;

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
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && Yii::app()->getModule('user')->isAdmin()))?array(
			array('username', 'length', 'max'=>128, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 128 characters).")),
            array('username','in','range'=>array('user','messages','pitch','site','startup','message','rights'),'allowEmpty'=>false, 'not'=>true, 'message' => 'Username inválido'),
            array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_.]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser, investor, founder', 'in', 'range'=>array(0,1)),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('username, email, superuser, status', 'required'),
			array('superuser, status, investor, founder', 'numerical', 'integerOnly'=>true),
			array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status', 'safe', 'on'=>'search'),            
            ):((Yii::app()->user->id==$this->id)?array(
			array('username, email', 'required'),
            array('username','in','range'=>array('user','messages','pitch','site','startup','message','rights'),'allowEmpty'=>false, 'not'=>true, 'message' => 'Username inválido'),
            array('username', 'length', 'max'=>128, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 128 characters).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_.]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        return array(
            'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
			'senders' => array(self::HAS_MANY, 'Message', 'sender_id'),
			'receivers' => array(self::HAS_MANY, 'Message', 'receiver_id'),
			'startups' => array(self::MANY_MANY, 'Startup', 'user_startup(user_id, startup_id)',
                'together' => true,
                'on'=>'startups.published=:p',
                'params'=>array(':p' => 1)
            ),
			'followers' => array(self::HAS_MANY, 'UserFollow', 'followed_id'),    //o numero de followers eh quantas vezes aparece ele como followed_id
			'following' => array(self::HAS_MANY, 'UserFollow', 'follower_id'),
			'roles' => array(self::MANY_MANY, 'Role', 'user_role(user_id, role_id)'),
			'sectors' => array(self::MANY_MANY, 'Sector', 'user_sector(user_id, sector_id)'),
			'skills' => array(self::MANY_MANY, 'Skill', 'user_skill(user_id, skill_id)'),
			'universities' => array(self::MANY_MANY, 'University', 'user_university(user_id, university_id)'),
			'userWebsites' => array(self::HAS_MANY, 'UserWebsite', 'user_id'),
            'startupFollows' => array(self::MANY_MANY, 'Startup', 'startup_follow(user_id, startup_id)'),
		);
        
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			'username'=>UserModule::t("username"),
			'password'=>UserModule::t("password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
			'email'=>UserModule::t("E-mail"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'create_at' => UserModule::t("Registration date"),			
			'lastvisit_at' => UserModule::t("Last visit"),
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),            
			'investor' => UserModule::t('Investor'),
            'founder' => UserModule::t('Founder'),
		);
	}

	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANNED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, create_at, lastvisit_at, superuser, status',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status',
        ));
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANNED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
	
/**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }
    
    /**
	 * added to handle saving MANY_TO_MANY 
	 */
    public function behaviors()
    {
        return array('ESaveRelatedBehavior' => array(
            'class' => 'application.components.ESaveRelatedBehavior')
        );
    }
    
    /**
	 * @return a string with the role names 
	 */
    public function getRoleNames()
    {
        $string="";
        $array = $this->roles;
        
        $lastElement = end($array);
        foreach ($array as $role)
        {
            $string = $string . $role->name ;
            if($role !== $lastElement) $string = $string . ', ';
        }
        
        return $string;
    }
    
    public function getRolesForPrint()
    {
        $string="";
        $roles=$this->roles;
        $lastElement = end($roles);
        foreach($roles as $role) {
            $string = $string.'<a href="'. Yii::app()->baseUrl.'/user?g=&rol[0]='.$role->role_id .'">'.UserModule::t($role->name).'</a>' ;
            if ($role!==$lastElement) $string = $string.' · ';
        } 
        
        return $string;
    }
    
    /**
	 * @return a string with the role names 
	 */
    public function getRoleIds()
    {        
        $roles = $this->roles;
        $arr = array();
        $i=0;
        foreach ($roles as $role)
        {
            $arr[$i] = $role->role_id;
            $i++;
        }
        
        return $arr;
    }
    
    /**
	 * @return a string with the sector names 
	 */
    public function getSectorNames()
    {
        $string="";
        $array = $this->sectors;
        
        $lastElement = end($array);
        foreach ($array as $sector)
        {
            $string = $string . $sector->name;
            if($sector !== $lastElement) $string = $string . ', ';
        }
        
        return $string;
    }
    
    public function getSectors()
    {
        return $this->sectors;
    }
    
    
    /**
	 * @return a string with the role names 
	 */
    public function getSectorIds()
    {        
        $sectors = $this->sectors;
        $arr = array();
        $i=0;
        foreach ($sectors as $sector)
        {
            $arr[$i] = $sector->sector_id;
            $i++;
        }
        
        return $arr;
    }
    
    /**
	 * @return a string with skills and dots in the middle
	 */
    public function getSectorsForPrint()
    {
        $string="";
        $sectors=$this->sectors;
        $lastElement = end($sectors);
        foreach($sectors as $sector) {
            $string = $string.'<a href="'. Yii::app()->baseUrl.'/startup?g=&sec[0]='.$sector->sector_id .'">'.$sector->name.'</a>' ;
            if ($sector!==$lastElement) $string = $string.' · ';
        } 
        
        return $string;
    }
    
    /**
	 * @return a string with the role names 
	 */
    public function getSkillNames()
    {
        $string="";
        $array = $this->skills;
        
        $lastElement = end($array);
        foreach ($array as $skill)
        {
            $string = $string . $skill->name;
            if($skill !== $lastElement) $string = $string . ', ';
        }
        
        return $string;
    }
    
    /**
	 * @return a string with the role names 
	 */
    public function getSkillIds()
    {        
        $skills = $this->skills;
        $arr = array();
        $i=0;
        foreach ($skills as $skill)
        {
            $arr[$i] = $skill->skill_id;
            $i++;
        }
        
        return $arr;
    }
    
    /**
	 * @return a string with skills and dots in the middle
	 */
    public function getSkillsForPrint()
    {
        $string="";
        $skills=$this->skills;
        $lastElement = end($skills);
        foreach($skills as $skill) {
            $string = $string.'<a href="'. Yii::app()->baseUrl.'/user?g=&ski[0]='.$skill->skill_id .'">'.$skill->name.'</a>' ;
            if ($skill!==$lastElement) $string = $string.' · ';
        } 
        
        return $string;
    }
    
    // class User
    public function getFullName() {
        return $this->profile->firstname.' '.$this->profile->lastname;
    }
    public function getSuggest($q) {
        $c = new CDbCriteria();
        $c->addSearchCondition('username', $q, true, 'OR');
        $c->addSearchCondition('email', $q, true, 'OR');
        return $this->findAll($c);
    }
    
    public function hasUserFollowing($id)
	{
		foreach ($this->followers as $user)
        {
            if($user->follower_id==$id)
            {	
                return true;
            }
        }		
		return false;
	}
    
    public function hasUserFollowed($id)
	{
		foreach ($this->following as $user)
        {
            if($user->followed_id==$id)
            {	
                return true;
            }
        }		
		return false;
	}
    
    //see if the user who is making the request is the one logged in
    public function isReallyYou()
    {
        return Yii::app()->user->id === $this->id;        
    } 
    
    public function getStartupsByRole($role)
    {
        $array=array();
        $i=0;
        foreach ($this->startups as $startup)
        {
            if($startup->isUserInRole($role, $this->id)){
                $array[$i] = $startup;
                $i++;                
            }
        }
        
        return $array;
    }
    
    public function echoWithComma($array)
    {
        $string="";
        $lastElement = end($array);
        foreach($array as $a) {
            $string = $string.CHtml::link($a->name, array('/startup/view', 'name'=>$a->startupname)); ;
            if ($a!==$lastElement) $string = $string.', ';
        } 
        
        return $string;
    }
    
    public function isUserInRole($role)
    {
        foreach ($this->startups as $startup)
        {
            if($startup->isUserInRole($role, $this->id))
                return true;           
        }
        return false;
    }
        
}