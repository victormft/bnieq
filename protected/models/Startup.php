<?php

/**
 * This is the model class for table "startup".
 *
 * The followings are the available columns in table 'startup':
 * @property string $id
 * @property string $name
 * @property string $logo
 * @property string $one_line_pitch
 * @property string $product_description
 * @property string $company_size
 * @property string $company_stage
 * @property string $foundation
 * @property string $email
 * @property string $telephone
 * @property string $skype
 * @property string $company_number
 * @property string $facebook
 * @property string $twitter
 * @property string $linkedin
 * @property string $website
 * @property string $location
 * @property string $client_segment
 * @property string $tech
 * @property string $value_proposition
 * @property string $market_size
 * @property string $sales_marketing
 * @property string $revenue_generation
 * @property string $competitors
 * @property string $competitive_advantage
 * @property string $history
 * @property string $video
 * @property string $create_time
 * @property string $selecionada
 * @property string $followers_num
  * @property string $completion
 *
 * The followings are the available model relations:
 * @property File[] $files
 * @property Investment[] $investments
 * @property Pitch[] $pitches
 * @property Location $location0
 * @property Image $logo0
 * @property User[] $users
 * @property Image[] $images
 * @property Sector[] $sectors
 * @property User[] $users1
 */
class Startup extends CActiveRecord
{

	//to upload logo
	public $pic;	
	
	//to upload mult images
	public $mult_pic;
	
	//to groups in listing
	public $group;
    
    public $followers_count;
	
	public $user_role;
	
	public $sec;
	
	//para os erros no publish/edit
	public $err;
	
	//to rand() in 'search' method
	public $rand = true;
	
	//to set default sort in 'search' method
	public $default_sort = true;
	
	//company size
	const SIZE_1="1-5";
	const SIZE_2="6-10";
	const SIZE_3="10+";
	
	//company stage
	const STAGE_1="Concept";
	const STAGE_2="Development";
	const STAGE_3="Prototype";
	const STAGE_4="Final Product";
	
	//company position (role that user has towards startup)
	const POS_1="Founder";
	const POS_2="Member";
	const POS_3="Investor";
	const POS_4="Advisor";
	
	//traction period
	const TRA_1="Total";
	const TRA_2="Daily";
	const TRA_3="Monthly";
	const TRA_4="Yearly";
		
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'startup';
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
			array('pic, mult_pic', 'file', 'types'=>'jpg, png, jpeg', 'wrongType'=>'Apenas os tipos: jpg, jpeg, png', 'allowEmpty'=>true, 'maxSize' => 1024 * 1024 * 5, 'tooLarge' => 'Deve ser menor que 5MB !!!'),
			array('pic, mult_pic', 'length', 'max' => 255, 'tooLong' => '{attribute} is too long (max {max} chars).'),
			array('name, one_line_pitch, location', 'required', 'message'=>UserModule::t("Required")),
			array('product_description, company_stage, sec', 'required', 'message'=>UserModule::t("Required"), 'on'=>'publish'),
			array('product_description, company_stage, sec, location', 'required', 'message'=>UserModule::t("Required"), 'on'=>'editable'),
			array('company_stage','in','range'=>array('Concept','Development','Prototype','Final Product'), 'message' => UserModule::t('Invalid Value!'), 'on'=>'editable'),
			//array('sectors', 'required', 'message'=>UserModule::t("Required"), 'on'=>'updateSectors'),
			array('location', 'compare', 'compareValue'=>0, 'operator'=>'!=', 'strict'=>true, 'message'=>UserModule::t("Required")),
			array('name', 'length', 'max'=>40),
			array('name', 'match', 'pattern' => '/^[\w\.\_\&\'\"\-\ÀÁÂÃÄÈÉÊËÌÍÎÏĨÒÓÔÕÖÙÚÛÜŨÇàáâãäèéêëìíîïĩòóôõöùúûüũç\ ]+$/u','message' =>UserModule::t("Incorrect Symbols")),
			array('one_line_pitch', 'length', 'max'=>80),
			array('email, skype', 'length', 'max'=>99),
			array('product_description, tech, client_segment, revenue_generation, competitors, competitive_advantage, history', 'length', 'max'=>1000, 'tooLong' => 'Texto muito longo (máximo de 1000 caracteres).'),
			array('logo, location', 'length', 'max'=>20),
			array('facebook, linkedin, twitter, website, video', 'url'),
            array('selecionada', 'in', 'range'=>array(0,1)),
			array('company_size, company_stage, telephone, company_number', 'length', 'max'=>45),
			array('facebook, twitter, linkedin, website, video', 'length', 'max'=>150),
			array('product_description, foundation, client_segment, tech, value_proposition, market_size, sales_marketing, revenue_generation, competitors, competitive_advantage, history, create_time, sec', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, logo, one_line_pitch, product_description, company_size, company_stage, foundation, email, telephone, skype, company_number, facebook, twitter, linkedin, location, client_segment, tech, value_proposition, market_size, sales_marketing, revenue_generation, competitors, competitive_advantage, history, video, create_time, selecionada, followers_num, followers_count, completion', 'safe', 'on'=>'search'),
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
			'files' => array(self::HAS_MANY, 'File', 'startup_id'),
			'investments' => array(self::HAS_MANY, 'Investment', 'startup_id'),
			'pitches' => array(self::HAS_MANY, 'Pitch', 'startup_id'),
			'press' => array(self::HAS_MANY, 'Press', 'startup_id'),
			'traction' => array(self::HAS_MANY, 'Traction', 'startup_id'),
			'past' => array(self::HAS_MANY, 'PastInvestment', 'startup_id'),
			'logo0' => array(self::BELONGS_TO, 'Image', 'logo'),
			'users' => array(self::MANY_MANY, 'User', 'startup_follow(startup_id, user_id)'),
			'images' => array(self::MANY_MANY, 'Image', 'startup_image(startup_id, image_id)'),
			'sectors' => array(self::MANY_MANY, 'Sector', 'startup_sector(startup_id, sector_id)'),
			'users1' => array(self::MANY_MANY, 'User', 'user_startup(startup_id, user_id)'),
			'city' => array(self::BELONGS_TO, 'Cidade', 'location'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Nome',
			'logo' => 'Logo',
			'one_line_pitch' => 'One Line Pitch',
			'product_description' => 'Product Description',
			'company_size' => 'Company Size',
			'company_stage' => 'Company Stage',
			'foundation' => 'Foundation',
			'email' => 'Email',
			'telephone' => 'Telephone',
			'skype' => 'Skype',
			'company_number' => 'Company Number',
			'facebook' => 'Facebook',
			'twitter' => 'Twitter',
			'linkedin' => 'Linkedin',
			'website' => 'Website',
			'location' => 'Location',
			'client_segment' => 'Client Segment',
			'tech' => 'Technology',
			'value_proposition' => 'Value Proposition',
			'market_size' => 'Market Size',
			'sales_marketing' => 'Sales Marketing',
			'revenue_generation' => 'Revenue Generation',
			'competitors' => 'Competitors',
			'competitive_advantage' => 'Competitive Advantage',
			'history' => 'History',
			'video' => 'Video',
			'create_time' => UserModule::t('Joined'),
			'selecionada' => 'Selecionada',
			'followers_num' => UserModule::t('Followers'),
			'completion' => 'Completion',
		);
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
	public function search($pageSize=null, $group=null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		if($group)
		{
			$this->default_sort=false;
			
			switch ($group) {
                case 1:
                    $this->selecionada=1;
                    break;
                case 2:
                    $criteria->order="t.followers_num DESC";
                    break;
                case 3:
                    $criteria->order="t.create_time DESC";
                    break;
            }            
		}
		
		$criteria->addCondition('t.published = 1');
		
		
		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.logo',$this->logo,true);
		$criteria->compare('t.one_line_pitch',$this->one_line_pitch,true/*, 'OR'*/);
		$criteria->compare('t.product_description',$this->product_description,true);
		$criteria->compare('t.company_size',$this->company_size,true);
		$criteria->compare('t.company_stage',$this->company_stage,true);
		$criteria->compare('t.foundation',$this->foundation,true);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.telephone',$this->telephone,true);
		$criteria->compare('t.skype',$this->skype,true);
		$criteria->compare('t.company_number',$this->company_number,true);
		$criteria->compare('t.facebook',$this->facebook,true);
		$criteria->compare('t.twitter',$this->twitter,true);
		$criteria->compare('t.linkedin',$this->linkedin,true);
		$criteria->compare('t.website',$this->website,true);
		$criteria->compare('t.location',$this->location,false);
		$criteria->compare('t.client_segment',$this->client_segment,true);
		$criteria->compare('t.tech',$this->tech,true);
		$criteria->compare('t.value_proposition',$this->value_proposition,true);
		$criteria->compare('t.market_size',$this->market_size,true);
		$criteria->compare('t.sales_marketing',$this->sales_marketing,true);
		$criteria->compare('t.revenue_generation',$this->revenue_generation,true);
		$criteria->compare('t.competitors',$this->competitors,true);
		$criteria->compare('t.competitive_advantage',$this->competitive_advantage,true);
		$criteria->compare('t.history',$this->history,true);
		$criteria->compare('t.video',$this->video,true);
		$criteria->compare('t.t.create_time',$this->create_time,true);
		$criteria->compare('t.selecionada',$this->selecionada,true);
		$criteria->compare('(SELECT COUNT(startup_follow.user_id) FROM startup_follow WHERE t.id=startup_follow.startup_id)',$this->followers_count);//making the filters work
        
        $criteria->select="t.*,(SELECT COUNT(startup_follow.user_id) FROM startup_follow WHERE t.id=startup_follow.startup_id) AS followers_count";                
      
        /*if($this->rand)
		{
			$criteria->order="rand()";
		}
		*/
		
		if($this->default_sort)
		{
			$criteria->order="t.create_time DESC";
		}
		
		
		if($this->group)
		{
			if($this->group=='Populares')
				$criteria->order="t.followers_num DESC";
				
			else if($this->group=='Novidades')
				$criteria->order="t.id DESC";
		}
		
		if($this->sectors){
			$criteria->with = array('sectors');
			$criteria->together = true;
			$criteria->compare('sectors.sector_id', $this->sectors,true);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$pageSize,
			),
            'sort'=>array(
                'attributes'=>array(
                    'followers_count'=>array(                        
                        'asc' => 'followers_count',
                        'desc' => 'followers_count DESC', 
                        'label' => UserModule::t('Followers'),
                        'default'=>'desc',
                    ),
                    '*',
                )
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Startup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCompanySizeOptions()
	{
		return array(
			self::SIZE_1=>'1-5',
			self::SIZE_2=>'6-10',
			self::SIZE_3=>'10+',
		);
	}	
	
	public function getCompanyStageOptions()
	{
		return array(
			self::STAGE_1=>UserModule::t("Concept"),
			self::STAGE_2=>UserModule::t("Development"),
			self::STAGE_3=>UserModule::t("Prototype"),
			self::STAGE_4=>UserModule::t("Final Product"),
		);
	}
	
	public function getCompanyPositionOptions()
	{
		return array(
			self::POS_1=>UserModule::t("Founder"),
			self::POS_2=>UserModule::t("Member"),
			self::POS_3=>UserModule::t("Investor"),
			self::POS_4=>UserModule::t("Advisor"),
		);
	}
	
	public function getTractionPeriodOptions()
	{
		return array(
			self::TRA_1=>"Total",
			self::TRA_2=>"Diário",
			self::TRA_3=>"Mensal",
			self::TRA_4=>"Anual",
		);
	}
/*
	public function getCompanyMembersPositionOptions()
	{
		return array(
			self::POS_1=>UserModule::t("Founder"),
			self::POS_2=>UserModule::t("Member"),
		);
	}
*/
	public function getSectorNames()
    {
        $string="";
        $array = $this->sectors;
        
        $lastElement = end($array);
        foreach ($array as $sector)
        {
            $string = $string .'<span class="label">'. CHtml::encode($sector->name) . '</span>';
            if($sector !== $lastElement) $string = $string . ' ';
        }
        
        return $string;
    }
	
	public function getSectorForPrint()
    {
        $string="";
        $sectors=$this->sectors;
        $lastElement = end($sectors);
        foreach($sectors as $sector) {
            $string = $string.'<a href="'. Yii::app()->baseUrl.'/startup?g=&sec[0]='.CHtml::encode($sector->sector_id) .'">'.CHtml::encode($sector->name).'</a>' ;
            if ($sector!==$lastElement) $string = $string.' · ';
        } 
        
        return $string;
    }
	
	public function getSectorCommaNames()
    {
        $string="";
        $array = $this->sectors;
        
        $lastElement = end($array);
        foreach ($array as $sector)
        {
            $string = $string . CHtml::encode($sector->name);
            if($sector !== $lastElement) $string = $string . ', ';
        }
        
        return $string;
    }
	
	public function getSectorCommaIds()
    {
        $string="";
        $array = $this->sectors;
        
        $lastElement = end($array);
        foreach ($array as $sector)
        {
            $string = $string . CHtml::encode($sector->sector_id);
            if($sector !== $lastElement) $string = $string . ',';
        }
        
        return $string;
    }
	
	/**
	 * @return an array with the sector ids
	 */
    public function getSectorIds()
    {        
        $sectors = $this->sectors;
        $arr = array();
        $i=0;
        foreach ($sectors as $sector)
        {
            $arr[$i] = CHtml::encode($sector->sector_id);
            $i++;
        }
        
        return $arr;
    }
	
	public function hasUserFollowing($id)
	{
		foreach ($this->users as $user)
			{
				if($user->id==$id)
				{	
					return true;
				}
			}
		
		return false;
	}
	
	public function getFollowNumber()
	{
		return count($this->users);
	}
	
	public function getAllUsers()
	{
		$users=User::model()->findAll();
		$arr = array();
		$i=0;
		
        foreach ($users as $user)
        {
            $arr[$i] = $user->profile->firstname .' '. $user->profile->lastname;
            $i++;
        }
        
        return $arr;
		
	}
	
	public function getAutoTest()
	{
		$query = User::model()->findAll();
		$list = array();        
		foreach($query as $q){
			$data['value'] = $q->id;
			$data['description'] = $q->profile->resume;
			$data['label'] = $q->profile->firstname .' '. $q->profile->lastname;
			$data['image'] = $q->profile->logo->name;

			$list[] = $data;
			unset($data);
		}

		echo json_encode($list);
	}
    
    public function allowCurrentUser($position)
    {
        $sql = "SELECT * FROM user_startup WHERE startup_id=:startupId AND user_id=:userId AND position=:position AND approved=1";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":startupId", $this->id, PDO::PARAM_INT);
        $command->bindValue(":userId", Yii::app()->user->getId(), PDO::PARAM_INT);
        $command->bindValue(":position", $position, PDO::PARAM_STR);
        return $command->execute()==1;
    }
    
    public function hasUserRelation()
    {
		//if(UserModule::isAdmin()) return 1;
        $sql = "SELECT * FROM user_startup WHERE startup_id=:startupId AND user_id=:userId";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":startupId", $this->id, PDO::PARAM_INT);
        $command->bindValue(":userId", Yii::app()->user->getId(), PDO::PARAM_INT);
        return $command->execute()==1;
    }
    
    public function isUserInRole($position, $user_id)
    {
        $sql = "SELECT * FROM user_startup WHERE startup_id=:startupId AND user_id=:userId AND position=:position AND approved=1";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":startupId", $this->id, PDO::PARAM_INT);
        $command->bindValue(":userId", $user_id, PDO::PARAM_INT);
        $command->bindValue(":position", $position, PDO::PARAM_STR);
        return $command->execute()==1;
    }
    
    public function isUserEditor($userid)
    {
        foreach ($this->userStartups as $userstartup)
        {
            if($userstartup->user_id==$userid)
            {	
                if($userstartup->position == 'Founder' || $userstartup->position == 'Member')
                    return true;
            }
        }		
		return false;
    }
    
    public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'StartupSelecionada' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),				
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
    
    public function getUserRole($user_id) {
        $relational_tbl=UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>$user_id, ':s_id'=>$this->id));
        return UserModule::t($relational_tbl->position);
    }
		
	public function getStartupsForPortfolio()
	{
		$query = Startup::model()->findAll();
		$list = array();        
		foreach($query as $q){
			$data['value'] = $q->id;
			//$data['description'] = $q->profile->resume;
			$data['label'] = $q->name;
			$data['image'] = $q->logo0->name;

			$list['myData'][] = $data;
			unset($data);
		}

		echo json_encode($list);
	}
    
    public function setCreatetime($value) {
        $this->create_time=date('Y-m-d H:i:s',$value);
    }
    
    public function getUsersByRole($role)
    {
        $array=array();
        $i=0;
        foreach ($this->users1 as $u)
        {
            if($u->isUserInRoleForStartup($role, $this->id)){
                $array[$i] = $u;
                $i++;                
            }
        }
        
        return $array;
    }
}
