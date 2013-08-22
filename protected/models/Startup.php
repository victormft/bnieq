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
 * @property string $blog
 * @property string $address
 * @property string $client_segment
 * @property string $value_proposition
 * @property string $market_size
 * @property string $sales_marketing
 * @property string $revenue_generation
 * @property string $competitors
 * @property string $competitive_advantage
 * @property string $video
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property File[] $files
 * @property Investment[] $investments
 * @property Pitch[] $pitches
 * @property Address $address0
 * @property Image $logo0
 * @property User[] $users
 * @property Image[] $images
 * @property Sector[] $sectors
 * @property StartupWebsite[] $startupWebsites
 * @property User[] $users1
 */
class Startup extends CActiveRecord
{

	//to upload logo
	public $pic;	
		
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
			array('pic', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty'=>true, 'maxSize' => 1024 * 1024 * 2, 'tooLarge' => 'Size should be less then 2MB !!!'),
			array('pic', 'length', 'max' => 255, 'tooLong' => '{attribute} is too long (max {max} chars).'),
			array('name, one_line_pitch', 'required'),
			array('name, email, skype', 'length', 'max'=>99),
			array('logo, address', 'length', 'max'=>20),
			array('company_size, company_stage, telephone, company_number', 'length', 'max'=>45),
			array('facebook, twitter, blog, video', 'length', 'max'=>150),
			array('product_description, foundation, client_segment, value_proposition, market_size, sales_marketing, revenue_generation, competitors, competitive_advantage, create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, logo, one_line_pitch, product_description, company_size, company_stage, foundation, email, telephone, skype, company_number, facebook, twitter, blog, address, client_segment, value_proposition, market_size, sales_marketing, revenue_generation, competitors, competitive_advantage, video, create_time', 'safe', 'on'=>'search'),
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
			'address0' => array(self::BELONGS_TO, 'Address', 'address'),
			'logo0' => array(self::BELONGS_TO, 'Image', 'logo'),
			'users' => array(self::MANY_MANY, 'User', 'startup_follow(startup_id, user_id)'),
			'images' => array(self::MANY_MANY, 'Image', 'startup_image(startup_id, image_id)'),
			'sectors' => array(self::MANY_MANY, 'Sector', 'startup_sector(startup_id, sector_name)'),
			'startupWebsites' => array(self::HAS_MANY, 'StartupWebsite', 'startup_id'),
			'users1' => array(self::MANY_MANY, 'User', 'user_startup(startup_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
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
			'blog' => 'Blog',
			'address' => 'Address',
			'client_segment' => 'Client Segment',
			'value_proposition' => 'Value Proposition',
			'market_size' => 'Market Size',
			'sales_marketing' => 'Sales Marketing',
			'revenue_generation' => 'Revenue Generation',
			'competitors' => 'Competitors',
			'competitive_advantage' => 'Competitive Advantage',
			'video' => 'Video',
			'create_time' => 'Create Time',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('one_line_pitch',$this->one_line_pitch,true);
		$criteria->compare('product_description',$this->product_description,true);
		$criteria->compare('company_size',$this->company_size,true);
		$criteria->compare('company_stage',$this->company_stage,true);
		$criteria->compare('foundation',$this->foundation,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('skype',$this->skype,true);
		$criteria->compare('company_number',$this->company_number,true);
		$criteria->compare('facebook',$this->facebook,true);
		$criteria->compare('twitter',$this->twitter,true);
		$criteria->compare('blog',$this->blog,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('client_segment',$this->client_segment,true);
		$criteria->compare('value_proposition',$this->value_proposition,true);
		$criteria->compare('market_size',$this->market_size,true);
		$criteria->compare('sales_marketing',$this->sales_marketing,true);
		$criteria->compare('revenue_generation',$this->revenue_generation,true);
		$criteria->compare('competitors',$this->competitors,true);
		$criteria->compare('competitive_advantage',$this->competitive_advantage,true);
		$criteria->compare('video',$this->video,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
}
