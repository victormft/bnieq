<?php

/**
 * This is the model class for table "pitch".
 *
 * The followings are the available columns in table 'pitch':
 * @property string $id
 * @property string $startup_id
 * @property string $investment_required
 * @property double $equity
 * @property string $video
 * @property string $pitch_text
 * @property string $exit_strategy
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Startup $startup
 */
class Pitch extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	 
	public $sort_funded = 0;
	public $c_stage_sort;
	
	public function tableName()
	{
		return 'pitch';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('startup_id, investment_required, equity, video, pitch_text, exit_strategy', 'required'),
			array('equity', 'numerical'),
			array('startup_id', 'length', 'max'=>20),
			array('investment_required, funded', 'length', 'max'=>10),
			array('video','url', 'defaultScheme' => 'http'),
			array('video','length', 'max'=>150),
			array('create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, startup_id, investment_required, equity, video, pitch_text, exit_strategy, create_time', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'startup_id' => 'Startup',
			'investment_required' => 'Investment Required',
			'funded' => 'Funded',
			'equity' => 'Equity',
			'video' => 'Video',
			'pitch_text' => 'Pitch Text',
			'exit_strategy' => 'Exit Strategy',
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
	public function search($pageSize=null, $group = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array( 'startup' );

		$criteria->compare('id',$this->id,true);
		$criteria->compare('startup_id',$this->startup_id,true);
		$criteria->compare('investment_required',$this->investment_required,true);
		$criteria->compare('funded',$this->funded,true);
		$criteria->compare('equity',$this->equity);
		$criteria->compare('video',$this->video,true);
		$criteria->compare('pitch_text',$this->pitch_text,true);
		$criteria->compare('exit_strategy',$this->exit_strategy,true);
		$criteria->compare('create_time',$this->create_time,true);
		
		$criteria->order="t.funded ASC";
		if($this->sort_funded == 1) {
			$criteria->condition='funded >= investment_required';
			$this->sort_funded = 0;
		}
		if(isset($this->c_stage_sort)) {
			$criteria->compare( 'startup.company_stage', $this->c_stage_sort, true );
			$this->c_stage_sort = NULL;
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize' =>$pageSize,
				),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pitch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	  * Returns an array to fill the dropBox fields
	 */
	public static function getStartupOptions() {
		
		$user_model = User::model()->findByPk(Yii::app()->user->id);
		$startup_list = $user_model->startups;
		$options = array();

		foreach($startup_list as $startup) {
			$options[$startup->id] = $startup->name;
		}
		return $options;
	
	}
}
