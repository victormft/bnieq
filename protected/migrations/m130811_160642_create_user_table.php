<?php

class m130811_160642_create_user_table extends CDbMigration
{
	public function up()
	{
		//create user table
		$this->createTable('user', array(
			'id' => 'pk',
			'first_name' => 'string NOT NULL',
			'last_name' => 'string NOT NULL',
			'username' => 'string NOT NULL',
			'email' => 'string NOT NULL',
			'password' => 'string NOT NULL',
			'profile_picture' => 'int(11) DEFAULT NULL',
			'birthday' => 'date DEFAULT NULL',
			'telephone' => 'string DEFAULT NULL',
			'skype' => 'string DEFAULT NULL',
			'resume' => 'text',
			'location' => 'int(11) DEFAULT NULL',
			'address' => 'string DEFAULT NULL',
			'facebook' => 'string DEFAULT NULL',
			'linkedin' => 'string DEFAULT NULL',
			'twitter' => 'string DEFAULT NULL',
			'experiences' => 'text',
			'interests' => 'text',
			'investor_profile' => 'boolean DEFAULT NULL',
			'last_login_time' => 'datetime DEFAULT NULL',
			'create_time' => 'datetime DEFAULT NULL',
			'update_time' => 'datetime DEFAULT NULL',
		), 'ENGINE=InnoDB');
	
		//create startup table
		$this->createTable('startup', array(
			'id' => 'pk',
			'name' => 'string NOT NULL',
			'logo' => 'int(11) DEFAULT NULL',		
			'one_line_pitch' => 'text',
			'website' => 'string DEFAULT NULL',
			'product_description' => 'text',
			'company_size' => 'string DEFAULT NULL',
			'company_stage' => 'string DEFAULT NULL',
			'foundation' => 'date DEFAULT NULL',
			'contact_member' => 'int(11) DEFAULT NULL',
			'email' => 'string DEFAULT NULL',
			'telephone' => 'string DEFAULT NULL',
			'skype' => 'string DEFAULT NULL',
			'website' => 'string DEFAULT NULL',
			'facebook' => 'string DEFAULT NULL',
			
			
		), 'ENGINE=InnoDB');		
		
		
		//add foreign keys
		
	}
	
	
	
	

	public function down()
	{
		$this->dropTable('user');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}