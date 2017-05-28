<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property integer $role_id
 * @property integer $approved
 */
class User extends CActiveRecord
{
	public $newPassword;
	public $RepeatPassword;
	public $oldPassword;
	public $setOldPassword; //used in order to validate password on password change.
	 //used in order to validate password on password change.
	/**
	* Returns the static model of the specified AR class.
	* @param string $className active record class name.
	* @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		if(!Yii::app()->user->isGuest)
			$password=Yii::app()->user->loadUser()->password;
		else $password="";
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('email', 'required'),
				array('username', 'length', 'max'=>32),
				array('password, salt', 'length', 'max'=>40),
				array('email', 'length', 'max'=>64),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('user_id, username, password, salt, email', 'safe', 'on'=>'search'),

				array('email','email'),
				array('username','unique'),
				array('RepeatPassword,password,username','required','on'=>'create'),
				array('password','compare', 'compareAttribute'=>'RepeatPassword','on'=>'create'),

				array('oldPassword,newPassword,RepeatPassword','required','on'=>'changePassword'),
				array('newPassword','compare', 'compareAttribute'=>'RepeatPassword','on'=>'changePassword'),
				array('oldPassword','compare','compareAttribute'=>'password','on'=>'changePassword'),
				
                array('newPassword,RepeatPassword','required','on'=>'resetPassword'),
                array('newPassword','compare', 'compareAttribute'=>'RepeatPassword','on'=>'resetPassword'),
					
				array('oldPassword,newPassword,RepeatPassword','required','on'=>'adminChangePassword'),
				array('newPassword','compare', 'compareAttribute'=>'RepeatPassword','on'=>'adminChangePassword'),
				array('oldPassword','compare', 'compareValue'=>$password,'on'=>'adminChangePassword','message'=>'Wrong password given. Try again!'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'user_id' => 'ID',
				//'membership' => 'I am',
				//'interest' => 'Biomass Purpose',
				//'biomass_count' => 'Quantity',
				//'biomass_unit' => 'Unit',
				//'biomass_mater' => 'Material',
				//'role_id' => 'Role'	
						);
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

		$criteria->compare('username',$this->username,true);
		//$criteria->compare('password',$this->password,true);
		//$criteria->compare('salt',$this->salt,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('approved',$this->approved,true);
		//$criteria->compare('created_at',$this->created_at);
		
		//$criteria->compare('admin',$this->admin,true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
						'pageSize'=>'25',
				),
		));
	}
	
		protected function generateSalt()
	{
		return uniqid('',true);
	}

	public function beforeValidate(){
		if($this->scenario!=='changePassword'&&$this->scenario!=='adminChangePassword')
			return true;
		$temp=$this->oldPassword;
		$password="";
		if($this->scenario=='changePassword'){

			$this->oldPassword=md5($this->oldPassword.$this->salt);
			$password=$this->password;
		}
		else if($this->scenario=='adminChangePassword'){
			$this->oldPassword=md5($this->oldPassword.Yii::app()->user->loadUser()->salt);
			$password=Yii::app()->user->loadUser()->password;
		}
		if($this->oldPassword!=$password||$this->newPassword!=$this->RepeatPassword)
			$this->oldPassword=$temp;
		if($this->newPassword!=$this->RepeatPassword||empty($this->newPassword)){
			$this->setOldPassword=$temp;
		}
		return true;
	}

	public function afterValidate(){
		if(!empty($this->setOldPassword))
			$this->oldPassword=$this->setOldPassword;
		return true;
	}

	public function beforeSave() {
		if(!empty($this->newPassword) and !$this->isNewRecord)
			$this->password=$this->newPassword;
		if (!empty($this->password)){
			if(!$this->isNewRecord and $this->password==User::findByPk($this->user_id)->password)
				return true;
			$this->salt=$this->generateSalt();
			$this->password=md5($this->password.$this->salt);
		}
		return true;
	}

	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}

	public function hashPassword($password,$salt)
	{
		//return $password;
		return md5($password.$salt);
	}
	/*** Generates a salt that can be used to generate a password hash.
	 * @return string the salt
	*/
	
}
