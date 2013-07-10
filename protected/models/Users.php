<?php

/**
 * This is the model class for table "{{_users}}".
 *
 * The followings are the available columns in table '{{_users}}':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $date_add
 * @property string $date_edit
 * @property integer $flag_ban
 * @property integer $role
 * @property string $email
 * @property string $realname
 */
class Users extends CActiveRecord
{

	const ROLE_SUPERADMIN = 'moderator';
	const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_BANNED = 'banned';
	
	public $verifyCode;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return '{{_users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email', 'required'),
			array('email', 'email'),
			array('username', 'match','pattern'=>'/^([A-Za-z0-9 ]+)$/u','message'=>'Допустимые символы A-Za-z0-9 '),
			array('flag_ban, role', 'numerical', 'integerOnly'=>true),
			array('username, password, email, realname', 'length', 'max'=>255),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(),'on'=>'registration', ),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			
			array('id, username, password, date_add, date_edit, flag_ban, role, email, realname', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Пользователь',
			'password' => 'Пароль',
			'date_add' => 'Дата добавления',
			'date_edit' => 'Дата изменения',
			'flag_ban' => 'Flag Ban',
			'role' => 'Role',
			'email' => 'Email',
			'realname' => 'Настоящее имя',
			'verifyCode' => 'Код с картинки',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_edit',$this->date_edit,true);
		$criteria->compare('flag_ban',$this->flag_ban);
		$criteria->compare('role',$this->role);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('realname',$this->realname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function BeforeSave()
	{
		if ($this->isNewRecord)
		{

			$this->date_add=date("Y-m-d H:i:s");
			$this->role = 1;
			
			$settings = Setting::model()->findByPk(1);
			if ($settings->defaultStatusUser==0)
			{
				$this->flag_ban=0;
			}
			else {
				$this->flag_ban=1;
			}
					
		}
		$this->date_edit=date("Y-m-d H:i:s");
		if (isset($this->password))
		{
			$this->password=md5('jjsjdjfbbb477dfgjjs'.$this->password);
		}
		return parent::BeforeSave();
		
	}
	public static function all()
	{
		$models = self::model()->findAll();
		return CHtml::listData($models, 'id', 'username');
	}
}